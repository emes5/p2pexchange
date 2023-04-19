<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\EmailVerifyRequest;
use App\Http\Requests\Api\ForgotPasswordRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\SignUpRequest;
use App\Http\Requests\g2fverifyRequest;
use App\Http\Services\AuthService;
use App\Model\UserVerificationCode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use PragmaRX\Google2FA\Google2FA;

class AuthController extends Controller
{
    protected $service;
    function __construct()
    {
        $this->service = new AuthService();
    }

    /**
     * @param SignUpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signUp(SignUpRequest $request)
    {
        $response = $this->service->signUpProcess($request);
        return response()->json($response);
    }

    // log in process
    public function login(LoginRequest $request)
    {
        $response = $this->service->loginProcess($request);

        return response()->json($response);
    }

    public function g2fVerifyApp(g2fverifyRequest $request){
        $google2fa = new Google2FA();
        $google2fa->setAllowInsecureCallToGoogleApis(true);
        $valid = $google2fa->verifyKey(Auth::user()->google2fa_secret, $request->code, 8);
        if ($valid){
            $user = Auth::user();
            Cache::put('g2f_checked',true);
            $img = asset('assets/common/img/avater.png');
            if (!empty($user->photo)) {
                $img = asset(IMG_USER_PATH.$user->photo);
            }
            $user->photo = $img;

            $data = ['success' => true, 'data' => ['user'=>$user,'g2f_verify'=>false], 'message' => __('Login successful')];
        }
        else{
            $data = ['success' => false, 'data' => ['user'=>null,'g2f_verify'=>true], 'message' => __('Code not matched!')];
        }
        return response()->json($data);

    }

    /**
     * @param EmailVerifyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function emailVerify(EmailVerifyRequest $request)
    {
        $response = $this->service->emailVerifyProcess($request);

        return response()->json($response);
    }

    public function resendEmailVerificationCode(Request $request){
        if(isset($request->email) && !empty($request->email)){
            try {
                $user = User::where('email', $request->email)->first();
                if(isset($user->id)){
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
                    $this->service->sendVerifyemail($user, $mail_key);
                    $data['success'] = true;
                    $data['data']=[];
                    $data['message'] = __('Your email is not verified yet. Please verify your mail.');
                }
                else{
                    $data = ['success' => false, 'data' => [], 'message' => __('Email not found!')];
                }
            } catch (\Exception $e) {
                $data['success'] = false;
                $data['data'] = [];
                $data['message'] = $e->getMessage();
            }
        }
        else{
            $data = ['success' => false, 'data' => [], 'message' => __('Email not found!')];
        }
        return response()->json($data);
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetCode(ForgotPasswordRequest $request)
    {
        if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            $data = ['success' => false, 'data' => [], 'message' => __('Invalid email address')];
            return response()->json($data);
        }
        $response = $this->service->sendForgotPasswordCode($request);

        return response()->json($response);
    }

    // reset password process
    public function resetPassword(ResetPasswordRequest $request)
    {
        if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            $data = ['success' => false, 'data' => [], 'message' => __('Invalid email address')];
            return response()->json($data);
        }
        $response = $this->service->resetPasswordProcess($request);

        return response()->json($response);
    }

    public function changePassword(ChangePasswordRequest $request){
        return $this->service->changePasswordApp($request);
    }

    public function logOutApp()
    {
        Cache::forget('g2f_checked');
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json(['success' => true, 'data' => [], 'message' => __('Logout successfully!')]);
    }
}
