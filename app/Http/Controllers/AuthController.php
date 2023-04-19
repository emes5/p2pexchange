<?php

namespace App\Http\Controllers;

use App\Http\Requests\g2fverifyRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUser;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ResetPasswordSaveRequest;
use App\Http\Services\AuthService;
use App\Model\AffiliationCode;
use App\Model\Coin;
use App\Model\Referral;
use App\Model\Subscriber;
use App\Model\UserVerificationCode;
use App\Model\Wallet;
use App\Repository\AffiliateRepository;
use App\Services\Logger;
use App\Services\MailService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FA\Google2FA;

class AuthController extends Controller
{
    private $logger;
    private $service;
    function __construct()
    {
        $this->logger = new Logger();
        $this->service = new AuthService();
    }
    //login
    public function login()
    {
        default_coin_api_settings();
        if (Auth::user()) {
            if (Auth::user()->role == USER_ROLE_ADMIN) {
                return redirect()->route('adminDashboard');
            } elseif (Auth::user()->role == USER_ROLE_USER) {
                return redirect()->route('userDashboard');
            } else {
                Auth::logout();
                return view('auth.login');
            }
        }
        return view('auth.login');
    }

    // sign up
    public function signUp()
    {
        if (Auth::user()) {
            if (Auth::user()->role == USER_ROLE_ADMIN) {
                return redirect()->route('adminDashboard');
            } elseif (Auth::user()->role == USER_ROLE_USER) {
                return redirect()->route('userDashboard');
            } else {
                Auth::logout();
                return view('auth.signup');
            }
        }
        return view('auth.signup');
    }

    // forgot password
    public function forgotPassword()
    {
        if (Auth::user()) {
            if (Auth::user()->role == USER_ROLE_ADMIN) {
                return redirect()->route('adminDashboard');
            } elseif (Auth::user()->role == USER_ROLE_USER) {
                return redirect()->route('userDashboard');
            } else {
                Auth::logout();
                return view('auth.forgot_password');
            }
        }
        return view('auth.forgot_password');
    }

    // forgot password
    public function resetPasswordPage()
    {
        return view('auth.reset_password');
    }

    // sign up process with referral sign up
    public function signUpProcess(RegisterUser $request)
    {
        $response = $this->service->signUpProcess($request);
        if ($response['success'] == true) {
            return redirect()->route('login')->with('success', $response['message']);
        } else{
            return redirect()->back()->with('dismiss', $response['message']);
        }
    }

    // login process
    public function loginProcess(LoginRequest $request)
    {
        $data['success'] = false;
        $data['message'] = '';
        $user = User::where('email', $request->email)->first();

        if (!empty($user)) {
            if(empty($user->email_verified_at))
                $user->email_verified_at =  0;

            if(($user->role == USER_ROLE_USER) || ($user->role == USER_ROLE_ADMIN) || ($user->role == USER_ROLE_SUB_ADMIN)) {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    //Check email verification
                    if ($user->status == STATUS_SUCCESS) {
                        if (!empty($user->is_verified)) {
                            $data['message'] = __('Login successful');
                            if ((Auth::user()->role == USER_ROLE_ADMIN) || (Auth::user()->role == USER_ROLE_SUB_ADMIN)) {
                                return redirect()->route('adminDashboard')->with('success',$data['message']);
                            } else {
                                createUserActivity(Auth::user()->id, USER_ACTIVITY_LOGIN);
                                return redirect()->route('marketPlace')->with('success',$data['message']);
                            }
                        } else {
                            $existsToken = User::join('user_verification_codes','user_verification_codes.user_id','users.id')
                                ->where('user_verification_codes.user_id',$user->id)
                                ->whereDate('user_verification_codes.expired_at' ,'>=', Carbon::now()->format('Y-m-d'))
                                ->first();
                            if(!empty($existsToken)) {
                                $mail_key = $existsToken->code;
                            } else {
                                $mail_key = randomNumber(6);
                                UserVerificationCode::create(['user_id' => $user->id, 'code' => $mail_key, 'status' => STATUS_PENDING, 'expired_at' => date('Y-m-d', strtotime('+15 days'))]);
                            }
                            try {
                                $this->service->sendVerifyemail($user, $mail_key);
                                $data['success'] = false;
                                $data['message'] = __('Your email is not verified yet. Please verify your mail.');
                                Auth::logout();

                                return redirect()->back()->with('dismiss',$data['message']);
                            } catch (\Exception $e) {
                                $data['success'] = false;
                                $data['message'] = $e->getMessage();
                                Auth::logout();

                                return redirect()->back()->with('dismiss',$data['message']);
                            }
                        }
                    } elseif ($user->status == STATUS_SUSPENDED) {
                        $data['success'] = false;
                        $data['message'] = __("Your account has been suspended. please contact support team to active again");
                        Auth::logout();
                        return redirect()->back()->with('dismiss',$data['message']);
                    } elseif ($user->status == STATUS_DELETED) {
                        $data['success'] = false;
                        $data['message'] = __("Your account has been deleted. please contact support team to active again");
                        Auth::logout();
                        return redirect()->back()->with('dismiss',$data['message']);
                    } elseif ($user->status == STATUS_PENDING) {
                        $data['success'] = false;
                        $data['message'] = __("Your account has been pending for admin approval. please contact support team to active again");
                        Auth::logout();
                        return redirect()->back()->with('dismiss',$data['message']);
                    }

                } else {
                    $data['success'] = false;
                    $data['message'] = __("Email or Password does not match");
                    return redirect()->back()->with('dismiss',$data['message']);
                }
            } else {
                $data['success'] = false;
                $data['message'] = __("You have no login access");
                Auth::logout();
                return redirect()->back()->with('dismiss',$data['message']);
            }
        } else {
            $data['success'] = false;
            $data['message'] = __("You have no account,please register new account");
            return redirect()->back()->with('dismiss',$data['message']);
        }
    }

    // send token

    public function sendForgotMail(Request $request)
    {

        $rules = ['email' => 'required|email'];
        if (isset(allsetting()['google_recapcha']) && (allsetting()['google_recapcha'] == STATUS_ACTIVE)) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }
        $messages = ['email.required' => __('Email field can not be empty'), 'email.email' => __('Email is invalid')];
        $validatedData = $request->validate($rules,$messages);
        $user = User::where(['email' => $request->email])->first();

        if ($user) {
            DB::beginTransaction();
            try {
                $key = randomNumber(6);
                $existsToken = User::join('user_verification_codes','user_verification_codes.user_id','users.id')
                    ->where('user_verification_codes.user_id',$user->id)
                    ->whereDate('user_verification_codes.expired_at' ,'>=', Carbon::now()->format('Y-m-d'))
                    ->first();
                if(!empty($existsToken)) {
                    $token = $existsToken->code;
                } else {
                    UserVerificationCode::create(['user_id' => $user->id, 'code'=>$key,'expired_at' => date('Y-m-d', strtotime('+15 days')), 'status' => STATUS_PENDING]);
                    $token = $key;
                }

                $user_data = [
                    'user' => $user,
                    'token' => $token,
                ];

                $mailService = new MailService();
                $userName = $user->first_name.' '.$user->last_name;
                $userEmail = $user->email;
                $companyName = isset(allsetting()['app_title']) && !empty(allsetting()['app_title']) ? allsetting()['app_title'] : __('Company Name');
                $subject = __('Forgot Password | :companyName', ['companyName' => $companyName]);
                $mailService->send('email.password_reset', $user_data, $userEmail, $userName, $subject);

                $data['message'] = 'Mail sent successfully to ' . $user->email . ' with password reset code.';
                $data['success'] = true;
                Session::put(['resend_email'=>$user->email]);
                DB::commit();

                return redirect(route('resetPasswordPage'))->with('success',$data['message']);
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('dismiss', __('Something went wrong. Please check mail credential.'));
            }

        } else {
            return redirect()->back()->with('dismiss',__('Email not found'));
        }
    }

    // logout
    public function logOut()
    {
        Session::forget('g2f_checked');
        Session::flush();
        Auth::logout();
        return redirect()->route('logOut')->with('success', __('Logout successful'));
    }

    // reset password save process

    public function resetPasswordSave(ResetPasswordSaveRequest $request)
    {
        try {
            $vf_code = UserVerificationCode::where(['code' => $request->token, 'status' => STATUS_PENDING])->first();

            if (!empty($vf_code)) {
                $user = User::where(['id'=> $vf_code->user_id, 'email'=>$request->email])->first();
                if (empty($user)) {
                    return redirect()->back()->withInput()->with('dismiss', __('User not found'));
                }
                $data_ins['password'] = hash::make($request->password);
                $data_ins['is_verified'] = STATUS_SUCCESS;
                if(!Hash::check($request->password,User::find($vf_code->user_id)->password)) {

                    User::where(['id' => $vf_code->user_id])->update($data_ins);
                    UserVerificationCode::where(['id' => $vf_code->id])->delete();

                    $data['success'] = 'success';
                    $data['message'] = __('Password Reset Successfully');
                } else {
                    $data['success'] = 'dismiss';
                    $data['message'] = __('You already used this password');
                    return redirect()->back()->with($data['success'],$data['message']);
                }

            } else {
                $data['success'] = 'dismiss';
                $data['message'] = __('Invalid code');

                return redirect()->back()->with('dismiss', __('Invalid code'));
            }
            return redirect()->route('login')->with($data['success'],$data['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }
    }

    // 2 fa check page
    public function g2fChecked(Request $request)
    {
        return view('auth.g2f');
    }

    // g2fa verification
    public function g2fVerify(g2fverifyRequest $request){

        $google2fa = new Google2FA();
        $google2fa->setAllowInsecureCallToGoogleApis(true);
        $valid = $google2fa->verifyKey(Auth::user()->google2fa_secret, $request->code, 8);

        if ($valid){
            Session::put('g2f_checked',true);
            return redirect()->route('userDashboard')->with('success',__('Login successful'));
        }
        return redirect()->back()->with('dismiss',__('Code doesn\'t match'));

    }
    // verify email
    //
    public function verifyEmailPost(Request $request)
    {
        try {
            $token = explode('email',$request->token);
            $user = User::where(['email' => decrypt($token[1])])->first();
            if (!empty($user)) {
                $varify = UserVerificationCode::where(['user_id' => $user->id])
                    ->where('code', decrypt($token[0]))
                    ->where('status', STATUS_PENDING)
                    ->whereDate('expired_at', '>', Carbon::now()->format('Y-m-d'))
                    ->first();

                if ($varify) {
                    $check = $user->update(['is_verified' => STATUS_SUCCESS]);
                    if ($check) {
                        UserVerificationCode::where(['user_id' => $user->id])->delete();
                        return redirect()->route('login')->with('success',__('Verify successful,you can login now'));
                    }
                } else {
                    Auth::logout();
                    return redirect()->route('login')->with('dismiss',__('Your verify token was expired,you can generate new token'));
                }
            } else {
                return redirect()->route('login')->with('dismiss',__('Your verify token was expired,you can generate new token'));
            }
        } catch (\Exception $e) {
            $this->logger->log('verifyEmailPost', $e->getMessage());
            return redirect()->route('login')->with('dismiss',__('Something went wrong'));
        }
    }

    // subscription process
    public function subscriptionProcess(Request $request)
    {
        $rules = [
            'email'=>'required|unique:subscribers'
        ];
        $messages = [
            'email.unique' => __('Already subscribed')
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            return redirect()->back()->withInput()->with(['dismiss' => $errors[0]]);
        }

        try {
            if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
                return redirect()->back()->withInput()->with('dismiss', __('Invalid email address'));
            }
            Subscriber::create(['email' => $request->email]);
            return redirect()->back()->withInput()->with(['success' => __('Subscription successful')]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with(['dismiss' => __('Something went wrong')]);
        }
    }
}
