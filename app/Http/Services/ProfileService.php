<?php
/**
 * Created by PhpStorm.
 * User: bacchu
 * Date: 9/12/19
 * Time: 12:56 PM
 */

namespace App\Http\Services;

use App\Model\AffiliationCode;
use App\Model\Coin;
use App\Model\UserVerificationCode;
use App\Model\Wallet;
use App\Repository\AffiliateRepository;
use App\Services\Logger;
use App\Services\MailService;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileService
{

    public $logger;
    function __construct()
    {
        $this->logger = new Logger();
    }

    /**
     * @param $request
     * @return array
     */
    public function userProfileUpdate($request)
    {
        $response = ['success' => false, 'message' => __('Something went wrong')];
        try {
            if (strpos($request->phone, '+') !== false) {
                return ['success' => false, 'message' => __("Don't put plus sign with phone number")];
            }
            if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'message' => __("Invalid email address")];
            }
            $user = (!empty($request->id)) ? User::find(decrypt($request->id)) : Auth::user();
            $userData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'country' => $request->country,
                'phone' => $request->phone,
                'gender' => $request->gender,
            ];

            if ($user->email != $request->email) {
                $userData['email'] = $request->email;
                if ($user->role == USER_ROLE_USER) {
                    $userData['is_verified'] = STATUS_PENDING;
                }
            }
            if ($user->phone != $request->phone) {
                $userData['phone'] = $request->phone;
                if ($user->role == USER_ROLE_USER) {
                    $userData['phone_verified'] = STATUS_PENDING;
                }
            }
            $user->update($userData);

            $response =  ['success' => true, 'message' => __('Profile updated successfully')];
        } catch (\Exception $exception) {
            $this->logger->log('userProfileUpdate', $exception->getMessage());
            $response = ['success' => false, 'message' => __('Something went wrong')];
        }
        return $response;
    }


}
