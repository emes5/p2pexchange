<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\AdminCreateUser;
use App\Http\Services\AuthService;
use App\Model\Coin;
use App\Model\UserVerificationCode;
use App\Model\VerificationDetails;
use App\Model\Wallet;
use App\Services\Logger;
use App\Services\MailService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private $logger;
    private $service;
    function __construct()
    {
        $this->logger = new Logger();
        $this->service = new AuthService();
    }

    // user list
    public function adminUsers(Request $request)
    {
        $data['title'] = __('Users');
        if ( !$request->ajax() ) {
            return view('admin.users.users', $data);
        } else {
            $user = User::where('role', USER_ROLE_USER)->where('id', '<>', Auth::user()->id);
            if ($request->type == 'active_users') {}
            $users = $user->where('status', STATUS_SUCCESS);
            if ($request->type == 'suspend_user')
                $users = $user->where('status', STATUS_SUSPENDED);
            if ($request->type == 'deleted_user')
                $users = $user->where('status', STATUS_DELETED);
            if ($request->type == 'email_pending')
                $users = $user->where('is_verified','!=', STATUS_SUCCESS );
            if ($request->type == 'phone_pending')
                $users = $user->where('phone_verified','!=', STATUS_SUCCESS );
            return datatables($users)

                ->addColumn('status', function ($item) {
                    return statusAction($item->status);
                })
                ->editColumn('first_name', function ($item) {
                    return $item->first_name.' '.$item->last_name;
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at ? with(new Carbon($item->created_at))->format('d M Y') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d %M %Y') like ?", ["%$keyword%"]);
                })
                ->addColumn('activity', function ($item) use ($request) {
                    return getActionHtml($request->type,$item->unique_code,$item);
                })
                ->rawColumns(['activity'])
                ->make(true);
        }
    }

    // generate verification key
    private function generate_email_verification_key()
    {
        $key = randomNumber(6);
        return $key;
    }

    // create and edit user
    public function UserAddEdit(AdminCreateUser $request)
    {
        $request->merge(['password' => 'demopassword']);
        $response = $this->service->signUpProcess($request);
        if ($response['success'] == true) {
            return redirect()->back()->with('success', __('New user created successfully'));
        } else {
            return redirect()->back()->with('dismiss', $response['message']);
        }
    }

    // user edit page
    public function adminUserProfile(Request $request)
    {
        $data['title'] = __('User Profile');
        $data['user'] = User::where('unique_code', $request->id)->first();
        $data['type'] = $request->type;

        return view('admin.users.profile',$data);
    }

    // user edit page
    public function UserEdit(Request $request)
    {
        $data['title'] = __('User Edit');
        $data['user'] = User::where('unique_code', $request->id)->first();
        $data['type'] = $request->type;

        return view('admin.users.edit',$data);
    }

    // delete user
    public function adminUserDelete($id)
    {
        $user = User::where('unique_code', $id)->first();
        $user->status = STATUS_DELETED;
        $user->save();

        return redirect()->back()->with('success',__('User deleted successfully'));
    }

    // suspend user
    public function adminUserSuspend($id){
        $user = User::where('unique_code', $id)->first();
        $user->status = STATUS_SUSPENDED;
        $user->save();
        return redirect()->back()->with('success',__('User suspended successfully'));
    }

    // remove user gauth
    public function adminUserRemoveGauth($id){
        $user = User::where('unique_code', $id)->first();
        $user->google2fa_secret = '';
        $user->g2f_enabled  = '0';
        $user->save();
        return redirect()->back()->with('success',__('User gauth removed successfully'));
    }

    // activate user
    public function adminUserActive($id){
        $user = User::where('unique_code', $id)->first();
        $user->status = STATUS_SUCCESS;
        $user->save();
        return redirect()->back()->with('success',__('User activated successfully'));
    }

    // verify user email
    public function adminUserEmailVerified(Request $request, $id){
        $user = User::where('unique_code', $id)->first();
        $user->is_verified = STATUS_SUCCESS;
        $user->save();
        if($request->ajax()) {
            return ['success' => true, 'message' => __('Email verified successfully')];
        }
        return redirect()->back()->with('success',__('Email verified successfully'));
    }

    // verify user email
    public function adminUserPhoneVerified($id){
        $user = User::where('unique_code', $id)->first();
        if (empty($user->phone)) {
            return redirect()->back()->with('dismiss',__('User phone number is empty'));
        }
        $user->phone_verified = STATUS_SUCCESS;
        $user->save();
        return redirect()->back()->with('success',__('Phone verified successfully'));
    }

    //ID Verification
    public function adminUserIdVerificationPending(Request $request)
    {
        if ($request->ajax()) {
            $data['items'] = VerificationDetails::join('users','users.id','verification_details.user_id')
                ->select('users.id','users.unique_code','users.updated_at', 'users.first_name', 'users.last_name', 'users.email')
                ->groupBy('user_id')
                ->where('verification_details.status',STATUS_PENDING)
                ->where(function ($query) {
                });

            return datatables()->of($data['items'])
                ->addColumn('actions', function ($item) {
                    return '<ul class="d-flex activity-menu">
                        <li class="viewuser"><a title="'.__('Details').'" href="' . route('adminUserDetails', ($item->unique_code)) . '?tab=photo_id"><i class="fa fa-eye"></i></a></li>
                        </ul>';
                })->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.users.users-pending-id-verification');
    }

    // verification details
    public function VerificationDetails($id)
    {
        $user = User::where('unique_code', $id)->first();
        $data['user_id'] = $user->unique_code;
        $data['pending'] = VerificationDetails::where('user_id',$user->id)->where('status',STATUS_PENDING)->get();
        $data['fields_name'] = VerificationDetails::where('user_id',$user->id)->where('status',STATUS_PENDING)->get()->pluck('id','field_name')->toArray();
        if (!empty($data['pending'])) {
            return view('admin.users.users-pending-id-verification-details',$data);
        }

        return redirect()->route('adminUserIdVerificationPending');
    }

    // activate user verification
    public function adminUserVerificationActive($id,$type)
    {
        try {
            $user = User::where('unique_code', $id)->first();
            if ($type == 'nid'){
                $verified = ['nid_front','nid_back'];
                VerificationDetails::where('user_id',($user->id))
                    ->whereIn('field_name',$verified)->update(['status'=>STATUS_SUCCESS]);

                return redirect()->route('adminUserIdVerificationPending')->with(['success' => __('Successfully Updated')]);
            } elseif ($type == 'driving'){
                $verified = ['drive_front','drive_back'];
                VerificationDetails::where('user_id',($user->id))
                    ->whereIn('field_name',$verified)->update(['status'=>STATUS_SUCCESS]);

                return redirect()->route('adminUserIdVerificationPending')->with(['success' => __('Successfully Updated')]);
            } elseif ($type == 'passport') {
                $verified = ['pass_front','pass_back'];
                VerificationDetails::where('user_id',($user->id))
                    ->whereIn('field_name',$verified)->update(['status'=>STATUS_SUCCESS]);

                return redirect()->route('adminUserIdVerificationPending')->with(['success' => __('Successfully Updated')]);
            }
        } catch (\Exception $exception){
            return redirect()->route('adminUserIdVerificationPending')->with(['dismiss' => __('Something went wrong')]);
        }
    }

    // verification reject process
    public function varificationReject(Request $request){
        try {
            $companyName = env('APP_NAME');
            $user = User::where('unique_code', $request->user_id)->first();
            $data['data'] = User::find(($user->id));
            $data['cause'] = $request->couse;
            $data['email'] = $data['data']->email;
            $user = $data['data'] ;
            $this->sendIdVerificationEmail($data,$user);

            if (isset($request->ids[0])) {
                foreach ($request->ids as $key => $value) {
                    deleteFile(IMG_USER_PATH, $value);
                }
            }
            VerificationDetails::whereIn('photo',$request->ids)->update(['status'=>STATUS_REJECTED, 'photo'=>'']);

            return redirect()->route('adminUserIdVerificationPending')->with('success',__('Rejected successfully'));
        } catch (\Exception $e) {
            Log::info('mail send ex ->'. $e->getMessage());
//            return redirect()->back()->with('dismiss', $e->getMessage());
            return redirect()->back()->with('dismiss',__('Please check your mail credential'));
        }

    }

    public function sendIdVerificationEmail($data,$user)
    {
        $servise = new MailService();
        $servise->send('email.verification_fields', $data, $user->email, $user->name, 'Id Verification Reject');

        return true;
    }

}
