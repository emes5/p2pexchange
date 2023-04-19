<?php

namespace App\Http\Services;
use App\Jobs\SendUserMailJob;
use App\Model\UserBankDetail;
use App\Model\UserCompanyDetail;
use App\Model\UserKycVerification;
use App\Model\UserVerificationCode;
use App\Services\Logger;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserService
{
    private $logger;
    private $commonService;
    public function __construct()
    {
        $this->logger = new Logger();
        $this->commonService = new CommonService();
    }

    public function userAddEdit(Request $request){
        DB::beginTransaction();
        $response = [];
        try {
            if (!empty($request->id)){
                $this->updateUser($request->id,$request);
                $response = ['success'=>TRUE,'message'=>__('Admin updated successfully.')];
            }else{
                $user = $this->createUser($request);
                $token = $this->sendUserVerificationCode($user);
//                $this->sendPasswordResetMail($user, $token);
                $response = ['success'=>TRUE,'message'=>__('New admin created successfully.')];
            }
            DB::commit();
        } catch (\Exception $e) {
            $response = ['success'=>FALSE,'message'=> $e->getMessage()];
            DB::rollback();
        }
        return $response;
    }

    private function createUser(Request $request){
        $update_data = $request->except('_token');
        $update_data['role'] = USER_ROLE_SUB_ADMIN;
        $update_data['role_id'] = $request->role;
        $update_data['unique_code'] = uniqid().date('').time();
        $update_data['password'] = Hash::make('demopassword');
        return User::create($update_data);
    }

    private function updateUser($id,Request $request){
        $update_data = $request->except('_token');
        return User::where('id',$id)->update($update_data);
    }

    private function sendUserVerificationCode($user){
        $key = randomNumber(6);
        $existsToken = User::join('user_verification_codes', 'user_verification_codes.user_id', 'users.id')
                           ->where('user_verification_codes.user_id', $user->id)
                           ->whereDate('user_verification_codes.expired_at', '>=', Carbon::now()->format('Y-m-d'))
                           ->first();

        if ( !empty($existsToken) ) {
            $token = $existsToken->code;
        } else {
            $s = UserVerificationCode::create(['user_id' => $user->id, 'code' => $key, 'expired_at' => date('Y-m-d', strtotime('+15 days')), 'status' => STATUS_PENDING]);
            $token = $key;
        }
        return $token;
    }

    private function sendPasswordResetMail($user,$token){
        $body = [
            'email' => $user->email,
            'token' => $token,
        ];
        $subject = __('Change Password Mail');
        dispatch(new SendUserMailJob($user, $body, $subject, 'email.password_reset'));

    }

    public function userBankDetailsSave(Request $request){
        try {
            $user_id = Auth::user()->id;
            $data = $request->except('_token');
            $data['user_id'] = $user_id;
            $bank_details = UserBankDetail::where('user_id',$user_id)->first();
            if (isset($bank_details)){
                UserBankDetail::where('user_id',$user_id)->update($data);
                UserLevelUpdate($user_id);
                return ['success'=>TRUE, 'message'=>__('User bank details updated successfully')];
            }else{
                UserBankDetail::create($data);
                KycVerificationUpdate($user_id,BANK_VERIFICATION,STATUS_PENDING);
                UserLevelUpdate($user_id);
                $this->commonService->sendKycNotification($user_id,KYC_NOTIFY_BANK_SUBMIT);
                return ['success'=>TRUE, 'message'=>__('User bank details created successfully')];
            }
        }catch (\Exception $exception){
            return ['success'=>FALSE, 'message'=>$exception->getMessage()];
        }

    }

    public function userCompanyDetailsSave(Request $request){
        try {
            $user_id = Auth::user()->id;
            $data = $request->except('_token');
            $data['user_id'] = $user_id;
            if (isset($request->registration_document) && $request->hasFile('registration_document')){
                $data['registration_document'] = uploadOnlyFile($request->registration_document,'assets/user/documents/company/');
            }
            $company_details = UserCompanyDetail::where('user_id',$user_id)->first();
            if (isset($company_details)){
                UserCompanyDetail::where('user_id',$user_id)->update($data);
                UserLevelUpdate($user_id);
                return ['success'=>TRUE, 'message'=>__('User company details updated successfully')];
            }else{
                UserCompanyDetail::create($data);
                KycVerificationUpdate($user_id,COMPANY_VERIFICATION,STATUS_PENDING);
                UserLevelUpdate($user_id);
                sendKycNotificationUpdate($user_id,KYC_NOTIFY_COMPANY_DETAILS_SUBMIT,'');

                return ['success'=>TRUE, 'message'=>__('User company details created successfully')];
            }
        }catch (\Exception $exception){
            return ['success'=>FALSE, 'message'=>$exception->getMessage()];
        }
    }

    public function getUserCompanyList($status){
        return UserKycVerification::join('users','users.id','user_kyc_verifications.user_id')
                           ->join('user_company_details','users.id','user_company_details.user_id')
                           ->select(
                               'user_kyc_verifications.id',
                               'users.unique_code',
                               'users.name',
                               'users.user_name',
                               'users.email',
                               'user_company_details.registration_document',
                               'user_company_details.descriptive_information',
                               'user_company_details.beneficial_owners_information',
                               'user_company_details.board_of_direction_information',
                               'user_kyc_verifications.status',
                               'user_kyc_verifications.created_at',
                           )
                           ->where('user_kyc_verifications.option','company')
                           ->where('user_kyc_verifications.status',$status);
    }

    public function getUserBankList($status){
        return UserKycVerification::join('users','users.id','user_kyc_verifications.user_id')
                           ->join('user_bank_details','users.id','user_bank_details.user_id')
                           ->join('banks','user_bank_details.bank_id','banks.id')
                           ->select(
                               'user_kyc_verifications.id',
                               'users.unique_code',
                               'users.name',
                               'users.user_name',
                               'users.email',
                               'banks.bank_name',
                               'user_bank_details.account_number',
                               'user_kyc_verifications.status',
                               'user_kyc_verifications.created_at',
                           )
                           ->where('user_kyc_verifications.option','bank')
                           ->where('user_kyc_verifications.status',$status);
    }

    // generate verification key
    private function generate_email_verification_key()
    {
        $key = randomNumber(6);
        return $key;
    }

    // phone verification process
    public function phoneVerify(Request $request)
    {
        $twoFactorService = new TwoFactorService();
        $response = $twoFactorService->verifyUserOtp($request);
        if ($response['success'] === TRUE) {
            User::where('id',Auth::user()->id)->update(['phone_verified'=>STATUS_ACTIVE]);
            KycVerificationUpdate(Auth::user()->id,PHONE_VERIFICATION, STATUS_ACTIVE);
            UserLevelUpdate(Auth::user()->id);
            if (isset($response['verification_id'])){
                $verificationCodeService = new  VerificationCodeService();
                $verificationCodeService->deleteVerificationCode($response['verification_id']);
            }
            return ['success'=>TRUE,'message'=>__('Great! Phone verified successfully.')];
        } else {
            return ['success'=>FALSE,'message'=>__('Wrong otp or your OTP is expired.')];
        }
    }
}
