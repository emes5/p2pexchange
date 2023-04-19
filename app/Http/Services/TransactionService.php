<?php

namespace App\Http\Services;

use App\Jobs\MailSend;
use App\Model\DepositeTransaction;
use App\Model\Wallet;
use App\Model\WalletAddressHistory;
use App\Model\WithdrawHistory;
use App\Repository\AffiliateRepository;
use App\Repository\UserRepository;
use App\Services\BitCoinApiService;
use App\Services\CoinPaymentsAPI;
use App\Services\Logger;
use App\Services\MailService;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransactionService
{
    protected $logger;

    public function __construct()
    {
        $this->logger = new Logger();
    }

    private function generate_email_verification_key()
    {
        do {
            $key = Str::random(60);
        } While (User::where('email_verified', $key)->count() > 0);

        return $key;
    }

    // User sms verification
    public function sendSmsVerificationCode()
    {
        $randno = randomNumber(6);
        $smsText = 'Your ' . allsetting()['app_title'] . ' verification code is here ' . $randno;
        app(SmsService::class)->send(Auth::user()->phone, $smsText);
        $update = User::where(['id' => Auth::user()->id])->update(['phone_verification' => $randno]);
        if ( !$update ) {
            return [
                'success' => false,
                'message' => __('Failed to send Sms!'),
            ];
        }

        return [
            'success' => true,
            'message' => __('Sms sent successfully!'),
        ];
    }

    //  create new Wallet
    public function createWallet($request)
    {
        $request->validate(['name' => 'required']);
        $coin = Coin::where(['is_default' => COIN_DEFAULT])->first();
        if ( isset($coin) ) {
            $insert_wallet = ['user_id' => Auth::user()->id, 'name' => $request->name, 'coin_id' => $coin->id, 'is_primary' => 0, 'balance' => 0];
            $wallet_info = MtrWallet::create($insert_wallet);
            if ( isset($wallet_info) ) {
                $wallet_address = WalletAddress::create(['mtr_wallet_id' => $wallet_info->id, 'address' => $this->generate_address()]);
            }
            if ( !$wallet_address ) {
                return ['success' => false, 'message' => __('Failed to create wallet!')];
            }
            return ['success' => true, 'data' => ['wallet_info' => $wallet_info, 'wallet_address' => $wallet_address], 'message' => __('Wallet created successfully!')];
        } else {
            return ['success' => false, 'message' => __('C-Type not found!')];
        }
    }

    // Wallet new address
    public function generate_address()
    {
        $coinCredentials = allsetting();
        $api = new BitCoinApiService($coinCredentials['coin_api_user'], $coinCredentials['coin_api_pass'], $coinCredentials['coin_api_host'], $coinCredentials['coin_api_port']);
        $address = $api->getNewAddress();

        return $address;
    }

    // get Address in Order process
    public function generate_address_by_coin($user, $pass, $host, $port)
    {
        $api = new BitCoinApiService($user, $pass, $host, $port);
        $address = $api->getNewAddress();

        return $address;
    }

    /*Phone verification check*/
    public function phonesecurity($request)
    {
        $sms_ver_code = UserVerificationCode::where(['code' => $request->phone_verification, 'status' => STATUS_PENDING, 'type' => 2])
            ->where('expired_at', '>=', date('Y-m-d'))->first();
        if ( isset($sms_ver_code) ) {
            UserVerificationCode::where('id', $sms_ver_code->id)->update(['status' => STATUS_SUCCESS]);
            User::where(['id' => $sms_ver_code->user_id])->update(['phone_verified' => STATUS_SUCCESS]);
        } else {
            return [
                'success' => false,
                'message' => __("Code doesn't match!"),
            ];
        }

        return [
            'success' => true,
            'message' => __("Phone verified successfully."),
        ];
    }

    /*Email Verification check*/
    public function emailcurity($request)
    {
        $sms_ver_code = UserVerificationCode::where(['code' => $request->email_verification, 'status' => STATUS_PENDING, 'type' => 1])
            ->where('expired_at', '>=', date('Y-m-d'))->first();
        if ( isset($sms_ver_code) ) {
            UserVerificationCode::where('id', $sms_ver_code->id)->update(['status' => STATUS_SUCCESS]);
            User::where(['id' => $sms_ver_code->user_id])->update(['email_verified' => STATUS_SUCCESS]);
        } else {
            return ['success' => false, 'message' => __("Code doesn't match!"),];
        }
        return ['success' => true, 'message' => __("Email verified successfully.")];
    }

    public function save_setting($request)
    {

        if ( !is_null($request->phone) && !is_null($request->phn_tab) ) {
            $rules['phone'] = 'numeric|required|regex:/[0-9]{10}/|phone_number|unique:users,phone,' . Auth::user()->id;
        } else {
            $data = ['success' => false, 'data' => ['is_phone_updated' => false], 'message' => __('Something Went Wrong.')];
            $rules = ['first_name' => 'required|max:256', 'last_name' => 'required|max:256'];
        }

        $validator = Validator::make($request->all(), $rules);
        if ( $validator->fails() ) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $data['success'] = false;
            $data['message'] = $errors;
            //            dd($data);
            return $data;
        }
        $user = User::where(['id' => Auth::user()->id]);

        if ( empty($request->phone) ) {
            $firstName = $request->first_name;
            $lastName = $request->last_name;
            $email = $request->email;
            $update ['first_name'] = $firstName;
            $update ['last_name'] = $lastName;
            if ( !empty($request->email) && Auth::user()->email != $request->email ) {
                if ( User::where('email', $request->email)->count() > 0 ) {
                    $data['success'] = false;
                    $data['message'] = __('Email already exists!');
                    return $data;
                } else {
                    $mail_key = $this->generate_email_verification_key();
                    $user = Auth::user();
                    $emailData['user'] = Auth::user();
                    $emailData['key'] = $mail_key;
                    UserVerificationCode::create(
                        ['user_id' => Auth::user()->id
                            , 'type' => 1
                            , 'code' => $mail_key
                            , 'expired_at' => date('Y-m-d', strtotime('+15 days'))
                            , 'status' => STATUS_PENDING]
                    );

                    UserRepository::createUserActivity(Auth::user()->id, USER_ACTIVITY_UPDATE_EMAIL);
                    $activity = UserActivity::where(['user_id' => $user->id, 'action' => USER_ACTIVITY_UPDATE_EMAIL])
                        ->orderBy('created_at', 'desc')->get()->first();
                    try {
                        DB::beginTransaction();
                        $oldEmail = new OldEmail;
                        $oldEmail->user_id = $user->id;
                        $oldEmail->old_email = $user->email;
                        $oldEmail->new_email = $request->email;
                        $oldEmail->user_activity_id = $activity->id;
                        $oldEmail->save();

                        $update['email'] = $request->email;
                        $update['email_verified'] = 0;
                        $user->update($update);
                        DB::commit();

                        Mail::send('email.mailVerify', $emailData, function ($message) use ($request) {
                            $message->to($request->email, $request->first_name . ' ' . $request->last_name)->from('noreply@mtcore.com', __('MTCore'))->subject('Email confirmation');
                        });

                        $data = [
                            'success' => true,
                            'message' => __('We have just sent a verification link on Email.'),
                            'update_type' => 'email'
                        ];
                        return $data;
                    } catch (\Exception $e) {
                        DB::rollBack();
                        $activity->delete();
                        $data = [
                            'success' => false,
                            'message' => __('We could not update your email address. Please check your email and try again.'),
                        ];
                        return $data;
                    }
                }
            }

            $data['update_type'] = 'profile';
        } else {
            $code = $request->code;
            $phone = $request->phone;
            $phone_marge = $request->code . $request->phone;
            $update ['country_code'] = $code;
            $update ['phone'] = $phone;
            if ( $user->first()->phone != $phone ) {
                if ( !is_null($phone) ) {
                    $randno = randomNumber(6);
                    $smsText = 'Your ' . allsetting()['app_title'] . ' verification code is here ' . $randno;
                    $sendSms = app(SmsService::class)->send($phone_marge, $smsText);
                    if ( !$sendSms ) {
                        $data['success'] = false;
                        $data['data']['is_phone_updated'] = false;
                        $data['message'] = __('Failed to send verification code');
                    }
                    if ( !is_null($request->phone) ) {
                        User::where(['id' => Auth::user()->id])->update(['phone_verified' => STATUS_PENDING]);
                        UserVerificationCode::create(['user_id' => Auth::user()->id, 'type' => 2, 'code' => $randno, 'expired_at' => date('Y-m-d', strtotime('+15 days')), 'status' => STATUS_PENDING]);

                        $data['data']['is_phone_updated'] = true;
                    }
                }
                $update ['phone'] = $phone;
            }
            $data['update_type'] = 'phone';
        }

        if ( $user->update($update) ) {
            $data['success'] = true;
            $data['message'] = __('Information Updated Successfully');
        }

        return $data;
    }

    public function save_login_setting($request)
    {
        $rules = [
            'password' => 'required|min:8|strong_pass|confirmed',
        ];

        $messages = [
            'password.required' => __('Password field can not be empty'),
            'password.min' => __('Password length must be above 8 characters.'),
            'password.strong_pass' => __('Password must be consist of one Uppercase, one Lowercase and one Number!')
        ];

        $request->validate($rules, $messages);
        $password = $request->password;

        $update ['password'] = Hash::make($password);

        $user = User::where(['id' => Auth::user()->id]);

        if ( $user->update($update) ) {
            return [
                'success' => true,
                'message' => 'Information Updated Successfully'
            ];
        }

        return [
            'success' => false,
            'message' => 'Information Update Failed. Try Again!'
        ];
    }

    public function new_address($request)
    {
        $response = array();
        $wallet_id = $request->get('wallet_id');
        if ( MtrWallet::where('id', $wallet_id)->count() > 0 ) {
            $address = WalletAddress::create(array('mtr_wallet_id' => $wallet_id, 'address' => $this->generate_address()));
            $response['success'] = true;
            $response['address'] = $address->address;
            $response['qr'] = $this->getQRCodeGoogleUrl($address->address, $title = null, $params = array());
        } else {
            $response['success'] = false;
            $response['message'] = "Request not allowed.";
        }

        return $response;
    }

    public function getQRCodeGoogleUrl($address, $title = null, $params = array())
    {
        $width = !empty($params['width']) && (int)$params['width'] > 0 ? (int)$params['width'] : 210;
        $height = !empty($params['height']) && (int)$params['height'] > 0 ? (int)$params['height'] : 204;
        $level = !empty($params['level']) && array_search($params['level'], array('L', 'M', 'Q', 'H')) !== false ? $params['level'] : 'M';

        $urlencoded = $address;
        return 'https://chart.googleapis.com/chart?chs=' . $width . 'x' . $height . '&chld=' . $level . '|0&cht=qr&chl=' . $urlencoded . '';
    }

    public function checkWithdrawalValidity($request, $user)
    {
        $data = ['success' => false, 'data' => ['is_phone_verified' => true, 'is_google_auth_enabled' => true, 'has_phone' => true], 'message' => __('Validation Error!')];
        try {
            $id = decrypt($request->wallet_id);
        } catch (\Exception $e) {
            $data['message'] = __('Invalid Wallet!');
            return response()->json($data);
        }
        $wallet = MtrWallet::where(['id' => $id, 'user_id' => $user->id])->first();
        if ( !$wallet ) {
            $data['message'] = __('Wallet not found!');
            return response()->json($data);
        }
        if ( $user->phone == '' ) {
            $data['data']['is_phone_verified'] = false;
            $data['data']['has_phone'] = false;
            $data['message'] = __("Please add your phone from settings before Withdrawal.");
            return response()->json($data);
        }
        if ( $user->phone_verified != STATUS_SUCCESS ) {
            $data['data']['is_phone_verified'] = false;
            $data['message'] = __("Please Verify your phone.");
            return response()->json($data);
        }
        if ( !isset($user->user_settings) || ($user->user_settings->gauth_enabled == STATUS_PENDING) ) {
            $data['data']['is_google_auth_enabled'] = false;
            $data['message'] = __("You need to enable google authenticator to send coin from web.");
            return response()->json($data);

        }
        return $data;
    }

    public function send($wallet, $address, $amount, $is_admin = false, $pendingTransaction = null, $authId = null, $message)
    {
        Log::info('withdrawal start');
        $message = !empty($message) ? $message : 'test message';
        $wallet = Wallet::join('coins', 'coins.id', '=', 'wallets.coin_id')
            ->where(['wallets.id' => $wallet, 'wallets.user_id'=>Auth::id()])
            ->select('wallets.*', 'coins.name as coin_name', 'coins.status as coin_status', 'coins.is_withdrawal', 'coins.minimum_withdrawal',
                'coins.maximum_withdrawal', 'coins.withdrawal_fees', 'coins.max_withdrawal_per_day')
            ->first();
        $user = $wallet->user;

        $mail_info = [];
        $coin_name = strtolower($wallet->coin_name);
        $mail_info['mailTemplate'] = 'email.transaction_mail';
        $sender_wallet_address = WalletAddressHistory::where('wallet_id',$wallet->id)->first()->address;

        try {

            if ( filter_var($address, FILTER_VALIDATE_EMAIL) ) {
                $fees = 0;
                $receiverUser = User::where('email', $address)->first();

                if ( empty($receiverUser) ) {
                    Log::info('Not a valid email address to send amount!');
                    return ['success' => false, 'message' => __('Not a valid email address to send amount!')];
                }
                if ( $user->id == $receiverUser->id ) {
                    Log::info('You can\'t send to your own wallet!');
                    return ['success' => false, 'message' => __('You can not send to your own wallet!')];
                }
                $receiverWallet = Wallet::where(['user_id'=>$receiverUser->id,'is_primary'=> 1])->first();
                $address_type = ADDRESS_TYPE_INTERNAL;

            } else {
                $walletAddress = $this->isInternalAddress($address);

                if ( empty($walletAddress) ) {
                    $receiverWallet = null;
                    $receiverUser = null;
                    $address_type = ADDRESS_TYPE_EXTERNAL;
                    $fees = check_withdrawal_fees($amount, $wallet->withdrawal_fees);

                } else {
                    $fees = 0;
                    $receiverWallet = $walletAddress->wallet;
                    $receiverUser = $walletAddress->wallet->user;
                    $address_type = ADDRESS_TYPE_INTERNAL;

                    if ( $user->id == $receiverUser->id ) {
                        Log::info('You can not send to your own wallet!');
                        return ['success' => false, 'message' => __('You can not send to your own wallet!')];
                    }
                    if ($wallet->coin_type != $walletAddress->wallet->coin_type) {
                        Log::info('You can not make withdrawal, because wallet coin type is mismatched. Your wallet coin type and withdrawal address coin type should be same.');
                        return ['success' => false, 'message' => __('You can not make withdrawal, because wallet coin type is mismatched. Your wallet coin type and withdrawal address coin type should be same.')];
                    }
                }
            }

            if ( ($amount + $fees) > $wallet->balance) {
                Log::info('Insufficient Balance!');
                return ['success' => false, 'message' => 'Insufficient Balance!'];
            }

            $sendAmount = $amount + $fees;
            $trans_id = Str::random(32);// we make this same for deposit and withdrawl

            DB::beginTransaction();
            try {
                $wallet->decrement('balance', $sendAmount);

                $transactionArray = [
                    'unique_code' => $wallet->id.uniqid().date('').time(),
                    'wallet_id' => $wallet->id,
                    'user_id' => $user->id,
                    'address' => $address,
                    'amount' => $amount,
                    'address_type' => $address_type,
                    'fees' => $fees,
                    'coin_id' => $wallet->coin_id,
                    'coin_type' => $wallet->coin_type,
                    'transaction_hash' => $trans_id,
                    'confirmations' => 0,
                    'status' => STATUS_PENDING,
                    'message' => $message,
                    'receiver_wallet_id' => empty($receiverWallet) ? 0 : $receiverWallet->id,
                ];
                $transaction = WithdrawHistory::create($transactionArray);
                Log::info(json_encode($transaction));
                $mail_info['to'] = $user->email;
                $mail_info['name'] = $user->first_name.' '.$user->last_name;
                if($address_type == ADDRESS_TYPE_INTERNAL){
                    $mail_info_address_type = 'Internal';
                }else{
                    $mail_info_address_type = 'External';
                }
                if ($address_type == ADDRESS_TYPE_INTERNAL){
                    $pendingAmount = WithdrawHistory::where(['wallet_id' => $wallet->id, 'status' => STATUS_PENDING])
                        ->where('created_at', '>=', Carbon::now()->subDay())
                        ->sum('amount');
                    if ($pendingAmount < $wallet->max_withdrawal_per_day) {
                        $transaction->status = STATUS_SUCCESS;
                        $transaction->save();
                        $mail_info['subject'] = "TransactionID:<$trans_id> Withdrawal ($amount $coin_name) placed successfully.";
                        $withdraw_status = 'Successful';

                    } else{
                        $mail_info['subject'] = "TransactionID:<$trans_id> Withdrawal ($amount $coin_name) placed successfully. Waiting for admin approval!";
                        $withdraw_status = 'Waiting for admin approval';
                    }
                    $mail_info['email_message']="$amount $coin_name Withdrawal placed successfully from $wallet->name. Transaction Information given below:";
                    $mail_info['email_message_table'] = "<table>
                        <tbody>
                            <tr>
                                <td>Sender Address</td>
                                <td>$sender_wallet_address</td>
                            </tr>
                            <tr>
                                <td>Receiver Address</td>
                                <td>$address</td>
                            </tr>
                            <tr>
                                <td>Address Type</td>
                                <td>$mail_info_address_type</td>
                            </tr>
                            <tr>
                                <td>TransactionID</td>
                                <td>$trans_id</td>
                            </tr>
                            <tr>
                                <td>Amount</td>
                                <td>$amount $coin_name</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>$withdraw_status</td>
                            </tr>
                        </tbody>
                    </table>";
                    dispatch(new MailSend($mail_info))->onQueue('send-mail-withdrawal');
                    if ( !empty($receiverWallet) ) {

                        $mail_info['to'] = $receiverUser->email;
                        $mail_info['name'] = $receiverUser->first_name.' '.$receiverUser->last_name;
                        $mail_info['email_message']="$amount $coin_name deposit placed successfully from $receiverWallet->name. Transaction Information given below:";

                        $transactionArray = [
                            'address' => $address,
                            'address_type' => $address_type,
                            'amount' => $amount,
                            'fees' => $fees,
                            'type' => $wallet->coin_type,
                            'coin_id' => $wallet->coin_id,
                            'transaction_id' => $trans_id,
                            'confirmations' => 0,
                            'status' => STATUS_PENDING,
                            'sender_wallet_id' => $wallet->id,
                            'receiver_wallet_id' => $receiverWallet->id
                        ];
                        $receive_tr =  DepositeTransaction::create($transactionArray);
                        Log::info(json_encode($receive_tr));
                        if ($pendingAmount < $wallet->max_withdrawal_per_day) {
                            $receive_tr->status = STATUS_SUCCESS;
                            $receive_tr->save();
                            $receiverWallet->increment('balance', $amount);
                        }
                    }
                    if ( !empty($pendingTransaction) ) {
                        $pendingTransaction->status = STATUS_SUCCESS;
                        $mail_info['subject'] = "TransactionID:<$trans_id> Deposit ($amount $coin_name) placed successfully.";
                        dispatch(new MailSend($mail_info))->onQueue('send-mail-deposit');
                    }else{
                        $mail_info['subject'] = "TransactionID:<$trans_id> Deposit ($amount $coin_name) placed successfully. Waiting for admin approval!";
                        dispatch(new MailSend($mail_info))->onQueue('send-mail-deposit');
                    }
                } else {
                    $mail_info['subject'] = "TransactionID:<$trans_id> Withdrawal ($amount $coin_name) placed successfully. Waiting for admin approval!";
                    $withdraw_status = 'Waiting for admin approval';
                    $mail_info['email_message']="$amount $coin_name Withdrawal placed successfully from $wallet->name. Transaction Information given below:";
                    $mail_info['email_message_table'] = "<table>
                        <tbody>
                            <tr>
                                <td>Sender Address</td>
                                <td>$sender_wallet_address</td>
                            </tr>
                            <tr>
                                <td>Receiver Address</td>
                                <td>$address</td>
                            </tr>
                            <tr>
                                <td>Address Type</td>
                                <td>$mail_info_address_type</td>
                            </tr>
                            <tr>
                                <td>TransactionID</td>
                                <td>$trans_id</td>
                            </tr>
                            <tr>
                                <td>Amount</td>
                                <td>$amount $coin_name</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>$withdraw_status</td>
                            </tr>
                        </tbody>
                    </table>";
                    dispatch(new MailSend($mail_info))->onQueue('send-mail-withdrawal');
                }
            } catch (\Exception $e) {
                DB::rollBack();
//                $this->_cancelTransaction($user, $wallet, $address, $amount, $pendingTransaction);
                Log::info($e->getMessage());
                return [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
            }
        } catch (\Exception $e) {
            Log::info('coin payment exception '.$e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        DB::commit();

        return [
            'success' => true,
            'message' => __('Transaction successful.')
        ];
    }

    // check internal address
    private function isInternalAddress($address)
    {
        return WalletAddressHistory::where('address', $address)->with('wallet')->first();
    }

    // cancel transaction
    private function _cancelTransaction($user, $wallet, $address, $amount, $pendingTransaction)
    {
        if ( !empty($pendingTransaction) ) {
            $pendingTransaction->status = STATUS_REJECTED;
            $pendingTransaction->update();
        }
        //  $mailService = app(MailService::class);
        $userName = $user->first_name . ' ' . $user->last_name;
        $userEmail = $user->email;
        $companyName = isset($default['company']) && !empty($default['company']) ? $default['company'] : __('Coin Wallet');
        $subject = __(':emailSubject | :companyName', ['emailSubject' => __('Send coin failure'), 'companyName' => $companyName]);
        $data['user'] = $user;
        $data['amount'] = $amount;
        $data['address'] = $address;
        $data['wallet'] = $wallet;
        //  $mailService->send('email.send_coin_failure', $data, $userEmail, $userName, $subject);
    }

    // external transfer
    public function external_transfer($address, $amount, $authId, $isAdmin, $user_id)
    {

        $coinPayment = new CoinPaymentsAPI();

        $api = $coinPayment->CreateWithdrawal($amount,'LTCT',$address);

        if ( isset($api->error) && ($api->error == 'ok') ) {
            return [
                'status' => true,
                'message' => __('Transfer successfully!'),
                'transaction_id' => $api->result['id']
            ];
        }
        return [
            'status' => false,
            'message' => __('Failed to send coin!'),
            'nodeMessage' => $api
        ];
    }


    public function isPhoneVerified($user)
    {
        if ( empty($user->phone) || $user->phone_verified == PHONE_IS_NOT_VERIFIED ) {
            return ['success' => false, 'phone_verify' => false, 'message' => __('Please Verify your phone.')];
        } else {
            return ['success' => true, 'phone_verify' => true, 'message' => __('Verified phone.')];
        }
    }

    public function createWithdrawalSecurityCode($transaction)
    {
        $withdrawalSecurityData = [
            'sender_transaction_id' => $transaction->id,
            'mtr_wallet_id' => $transaction->wallet_id,
            'security_code' => 'W-' . $transaction->wallet_id . '-' . time()
        ];

        WithdrawalSecurityCode::create($withdrawalSecurityData);

    }


    public function checkSuspicious($balance = 0, $deposits = 0, $withdrawals = 0, $suspend = null)
    {
        $extra_balance = bcsub(bcadd($deposits, $withdrawals), $balance);
        if ( $extra_balance < 0 ) {
            if ( !empty($suspend) ) {
                User::where('id', Auth::id())->update([
                    'active_status' => STATUS_SUSPENDED // Force closed for suspicious balance.
                ]);
            }

            return [
                'suspended' => true,
                'extra_balance' => $extra_balance
            ];
        }

        return [
            'suspended' => false,
            'extra_balance' => $extra_balance
        ];
    }

    public function sendVerificationMail($user, $mail_key, $mailTemplate = 'email.mailVerify')
    {
        $data['user'] = $user;
        $data['key'] = $mail_key;
        Mail::send($mailTemplate, $data, function ($message) use ($user) {
            $message->to($user->email, $user->first_name . ' ' . $user->last_name)->from('noreply@mtcore.com', __('MTCore'))->subject('Email confirmation');
        });
    }

    public function sendPasswordResetMail($user, $token, $mailTemplate = 'email.password_reset')
    {
        $data['user'] = $user;
        $data['token'] = $token;
        Mail::send($mailTemplate, $data, function ($message) use ($user) {
            $message->to($user->email, $user->first_name . ' ' . $user->last_name)->from('noreply@mtcore.com', __('MTCore'))->subject('Forget Password');
        });
    }

    public function send_validation_check($wallet, $address, $amount)
    {
        $wallet->load('user');
        $user = $wallet->user;
        if ( isset($wallet) && $wallet->balance <= 0 ) {
            return [
                'success' => false,
                'phone_verify' => false,
                'message' => "Your Wallet Don't have enough balance to withdrawal! "
            ];
        }
        if ( isset($wallet) && $wallet->balance < $amount ) {
            return [
                'success' => false,
                'phone_verify' => false,
                'message' => "Your Wallet Don't have enough balance to withdrawal! "
            ];
        }

        if ( empty($user->phone) || $user->phone_verified = PHONE_IS_NOT_VERIFIED ) {
            return [
                'success' => false,
                'phone_verify' => false,
                'message' => "Please Verify your phone."
            ];
        }

        if ( $user->user_settings->gauth_enabled != GOOGLE_AUTH_ENABLED ) {
            return [
                'success' => false,
                'google_auth_verify' => false,
                'message' => "You need to enable google authenticator to send coin from web."
            ];
        }
        //        dd($address,filter_var($address, FILTER_VALIDATE_EMAIL));
        if ( filter_var($address, FILTER_VALIDATE_EMAIL) ) {
            $fees = 0;
            $receiverUser = User::where('email', $address)->first();
            if ( empty($receiverUser) ) {
                return [
                    'success' => false,
                    'message' => __('Not a valid email address to send amount!')
                ];
            }

            if ( $user->id == $receiverUser->id ) {
                return [
                    'success' => false,
                    'message' => __('You can\'t send to your own wallet!')
                ];
            }
        } else {
            $walletAddress = $this->isInternalAddress($address);

            if ( empty($walletAddress) ) {
                $api = new BitCoinApiService(settings('coin_api_user'),settings('coin_api_pass'),settings('coin_api_host'),settings('coin_api_port'));
                $response = $api->verifyAddress($address);
                if ( !$response ) {
                    return [
                        'success' => false,
                        'message' => __('Not a valid address!')];
                }
                $receiverUser = null;
                $fees = $this->calculate_fees($amount);

            } else {
                $fees = 0;
                $receiverUser = $walletAddress->wallet->user;

                if ( $user->id == $receiverUser->id ) {
                    return [
                        'success' => false,
                        'message' => __('You can\'t send to your own wallet!')
                    ];
                }
            }
        }

        return [
            'success' => true
        ];
    }

    private function calculate_fees($amount)
    {
        return $amount;
    }

    public function user_details($email)
    {
        $user = User::where('email', $email)->first();
        return $user;
    }

    public function transaction_history($email)
    {
        // $transaction = DB::select("SELECT * FROM transactions WHERE wallet_id IN (SELECT id FROM wallet WHERE user_id = (SELECT id FROM users WHERE email = '$email')) or receiver_wallet_id IN (SELECT id FROM wallet WHERE user_id = (SELECT id FROM users WHERE email = '$email'))");
        $transaction = Transaction::whereHas('receiverWallet', function ($query) use ($email) {
            $query->whereHas('user', function ($where) use ($email) {
                $where->where('email', '=', $email)
                    ->orWhere(['transaction_id' => $email]);
            });
        })->orwhereHas('wallet', function ($query) use ($email) {
            $query->whereHas('user', function ($where) use ($email) {
                $where->where('email', '=', $email)
                    ->orWhere(['transaction_id' => $email]);
            });
        })->get();
        return $transaction;
    }

    public function pending_transaction($email)
    {
        $pending_transaction = PendingTransaction::whereHas('receiverWallet', function ($query) use ($email) {
            $query->whereHas('user', function ($where) use ($email) {
                $where->where('email', '=', $email);
            });
        })->orwhereHas('wallet', function ($query) use ($email) {
            $query->whereHas('user', function ($where) use ($email) {
                $where->where('email', '=', $email);
            });
        })->get();
        return $pending_transaction;
    }

    public function wallet_address($email)
    {
        $wallet_address = WalletAddress::whereHas('wallet', function ($query) use ($email) {
            $query->whereHas('user', function ($where) use ($email) {
                $where->where('email', '=', $email);
            });
        })->get();
        return $wallet_address;
    }

    public function tolerence_balance($email)
    {
        $tolerence_balance = WalletToleranceBalance::whereHas('wallet', function ($query) use ($email) {
            $query->whereHas('user', function ($where) use ($email) {
                $where->where('email', '=', $email);
            });
        })->get();

        return $tolerence_balance;
    }

    private function sendTransactionMail($sender_user, $mailTemplet, $receiver_user, $amount, $emailSubject)
    {
        $mailService = app(MailService::class);
        $userName = $sender_user->first_name . ' ' . $sender_user->last_name;
        $userEmail = $sender_user->email;
        $companyName = isset($default['company']) && !empty($default['company']) ? $default['company'] : __('Coin Wallet');
        $subject = __(':emailSubject | :companyName', ['emailSubject' => $emailSubject, 'companyName' => $companyName]);
        $data['data'] = $sender_user;
        $data['anotherUser'] = $receiver_user;
        $data['amount'] = $amount;
        $mailService->send($mailTemplet, $data, $userEmail, $userName, $subject);
    }

    private function sendExternalTransactionMail($sender_user, $mailTemplet, $address, $amount, $emailSubject)
    {
        $mailService = app(MailService::class);
        $userName = $sender_user->first_name . ' ' . $sender_user->last_name;
        $userEmail = $sender_user->email;
        $companyName = isset($default['company']) && !empty($default['company']) ? $default['company'] : __('Coin Wallet');
        $subject = __(':emailSubject | :companyName', ['emailSubject' => $emailSubject, 'companyName' => $companyName]);
        $data['data'] = $sender_user;
        $data['address'] = $address;
        $data['amount'] = $amount;
        $mailService->send($mailTemplet, $data, $userEmail, $userName, $subject);
    }

    private function sendVerificationSms($phone, $randno)
    {
        $smsText = 'Your ' . allsetting()['app_title'] . ' verification code is here ' . $randno;
        app(SmsService::class)->send($phone, $smsText);
    }

    /**
     * @param $req
     * @return array|string
     */
//    public function getReturnDoman($req)
//    {
//        $reqUrl = $req->fullUrl();
//        $referer = explode('?', $reqUrl);
//
//        if ( count($referer) > 1 ) {
//            $referer = explode('=', $referer[1]);
//            $returnDomain = $referer[0];
//        } else {
//            $returnDomain = explode('/', $referer[0]);
//            $returnDomain = $returnDomain[2];
//            $returnDomain = explode('.', $returnDomain);
//            $returnDomain = $returnDomain[0];
//        }
//
//        if ( $returnDomain == 'tab' ) {
//            $returnDomain = 'mtr-wallet';
//        }
//
//        return $returnDomain;
//    }


    // user deposit history
    public function depositTransactionHistories($user_id = null, $status = null, $wallet_id = null, $address_type = null, $transaction_id = null)
    {
        $histories = DepositeTransaction::join('wallets', 'wallets.id', 'deposite_transactions.receiver_wallet_id')
         ->select('wallets.*','deposite_transactions.*');
        if ( !empty($status) )
            $histories = $histories->where('deposite_transactions.status', $status);
        if ( !empty($wallet_id) )
            $histories = $histories->where('wallets.id', $wallet_id);
        if ( !empty($address_type) )
            $histories = $histories->where('deposite_transactions.address_type', $address_type);
        if ( !empty($transaction_id) )
            $histories = $histories->where('deposite_transactions.transaction_id', $transaction_id);
        if ( !empty($user_id) )
            $histories = $histories->where('wallets.user_id', $user_id);

        return $histories;
    }

    // user withdrawal history
    public function withdrawTransactionHistories($user_id = null, $status = null, $wallet_id = null, $address_type = null, $transaction_id = null)
    {
        $histories = WithdrawHistory::join('wallets', 'wallets.id', 'withdraw_histories.wallet_id')
            ->select('wallets.*','withdraw_histories.*');
        if ( !empty($status) )
            $histories = $histories->where('withdraw_histories.status', $status);
        if ( !empty($wallet_id) )
            $histories = $histories->where('wallets.id', $wallet_id);
        if ( !empty($address_type) )
            $histories = $histories->where('withdraw_histories.address_type', $address_type);
        if ( !empty($transaction_id) )
            $histories = $histories->where('withdraw_histories.transaction_id', $transaction_id);
        if ( !empty($user_id) )
            $histories = $histories->where('wallets.user_id', $user_id);

        return $histories;
    }

    // check withdrawal validation
    public function checkWithdrawalValidation($request, $user, $wallet)
    {
        $data = [
            'data' => [],
            'success' => true,
            'message' => ''
        ];

        $checkCoinStatus = check_coin_status($wallet, CHECK_STATUS, $request->amount, 0);
        $checkWithdrawalStatus = check_coin_status($wallet, CHECK_WITHDRAWAL_STATUS, $request->amount, 0);

        if ($checkCoinStatus['success'] == true) {
            $data = [
                'data' => [],
                'success' => false,
                'message' => $checkCoinStatus['message']
            ];
            return $data;
        }
        if ($checkWithdrawalStatus['success'] == true) {
            $data = [
                'data' => [],
                'success' => false,
                'message' => $checkWithdrawalStatus['message']
            ];
            return $data;
        }

        $address = $request->address;
        if (filter_var($address, FILTER_VALIDATE_EMAIL)) {
            $receiverUser = User::where('email', $address)->first();
            if (empty($receiverUser)) {
                $data = [
                    'data' => [],
                    'success' => false,
                    'message' => __('Not a valid email address to send amount!')
                ];
                return $data;
            }
            if ($user->id == $receiverUser->id) {
                $data = [
                    'data' => [],
                    'success' => false,
                    'message' => __('You can not send to your own wallet!')
                ];
                return $data;
            }
            $fees = 0;

        } else {
            $walletAddress = $this->isInternalAddress($address);
            if ($walletAddress) {
                $receiverUser = $walletAddress->wallet->user;
                if ($user->id == $receiverUser->id) {
                    $data = [
                        'data' => [],
                        'success' => false,
                        'message' => __('You can not send to your own wallet!')
                    ];
                    return $data;
                }
                if ($wallet->coin_type != $walletAddress->wallet->coin_type) {
                    $data = [
                        'data' => [],
                        'success' => false,
                        'message' => __('You can not make withdrawal, because wallet coin type is mismatched. Your wallet coin type and withdrawal address coin type should be same.')
                    ];
                    return $data;
                }
                $fees = 0;
            } else {
                $fees = check_withdrawal_fees($request->amount, $wallet->withdrawal_fees);
            }
        }

        $checkMinimumWithdrawal = check_coin_status($wallet, CHECK_MINIMUM_WITHDRAWAL, $request->amount, $fees);
        $checkMaximumWithdrawal = check_coin_status($wallet, CHECK_MAXIMUM_WITHDRAWAL, $request->amount, $fees);
        $checkAvailableBalance = check_coin_status($wallet, CHECK_WITHDRAWAL_FEES, $request->amount, $fees);

        if ($checkMinimumWithdrawal['success'] == true) {
            $data = [
                'data' => [],
                'success' => false,
                'message' => $checkMinimumWithdrawal['message']
            ];
            return $data;
        }
        if ($checkMaximumWithdrawal['success'] == true) {
            $data = [
                'data' => [],
                'success' => false,
                'message' => $checkMaximumWithdrawal['message']
            ];
            return $data;
        }
        if ($checkAvailableBalance['success'] == true) {
            $data = [
                'data' => [],
                'success' => false,
                'message' => $checkAvailableBalance['message']
            ];
            return $data;
        }

        return $data;
    }

    // ether chain transaction
    public function sendChainExternal($wallet, $address, $amount)
    {
        $this->logger->log('sendChainExternal','withdrawal start');
        $message = !empty($message) ? $message : 'test message';
        $wallet = Wallet::join('coins', 'coins.id', '=', 'wallets.coin_id')
            ->where(['wallets.id' => $wallet, 'wallets.user_id'=>Auth::id()])
            ->select('wallets.*','coins.status as coin_status', 'coins.is_withdrawal', 'coins.minimum_withdrawal',
                'coins.maximum_withdrawal', 'coins.withdrawal_fees')
            ->first();
        $user = $wallet->user;
        DB::beginTransaction();
        try {
            $walletAddress = $this->isInternalAddress($address);
            if (empty($walletAddress)) {
                $receiverWallet = null;
                $receiverUser = null;
                $address_type = ADDRESS_TYPE_EXTERNAL;
                $fees = check_withdrawal_fees($amount, $wallet->withdrawal_fees);
            } else {
                $fees = check_withdrawal_fees($amount, $wallet->withdrawal_fees);
                $receiverWallet = $walletAddress->wallet;
                $receiverUser = $walletAddress->wallet->user;
                $address_type = ADDRESS_TYPE_INTERNAL;

                if ($user->id == $receiverUser->id) {
                    Log::info('You can\'t send to your own wallet!');
                    return ['success' => false, 'message' => __('You can\'t send to your own wallet!')];
                }
                if ($wallet->coin_type != $walletAddress->wallet->coin_type) {
                    Log::info('You can\'t make withdrawal, because wallet coin type is mismatched. Your wallet coin type and withdrawal address coin type should be same.');
                    return ['success' => false, 'message' => __('You can\'t make withdrawal, because wallet coin type is mismatched. Your wallet coin type and withdrawal address coin type should be same.')];
                }
            }
            $sendAmount = $amount + $fees;
            $trans_id = Str::random(32);// we make this same for deposit and withdrawl

            $transactionArray = [
                'unique_code' => $wallet->id.uniqid().date('').time(),
                'wallet_id' => $wallet->id,
                'coin_id' => $wallet->coin_id,
                'address' => $address,
                'amount' => $amount,
                'address_type' => $address_type,
                'fees' => $fees,
                'coin_type' => $wallet->coin_type,
                'doller' => 0,
                'btc' => 0,
                'transaction_hash' => $trans_id,
                'confirmations' => 0,
                'status' => STATUS_PENDING,
                'message' => $message,
                'receiver_wallet_id' => empty($receiverWallet) ? 0 : $receiverWallet->id,
                'user_id' => $user->id
            ];

            $transaction = WithdrawHistory::create($transactionArray);
            if ($transaction->amount > 0) {
                DB::commit();
                return ['success' => true,'temp'=>$transaction->id, 'message' => __("Withdrawal is now in progress. Please don't reload or leave this page until complete the process")];
            } else {
                DB::rollBack();
                return ['success' => false, 'message' => __('Error, Something went wrong')];
            }

        } catch (\Exception $exception) {
            $this->logger->log('sendChainExternal ex',$exception->getMessage());
            DB::rollBack();
            return ['success' => false, 'message' => __('Error, Something went wrong')];
        }
    }

    // kyc validation check
    public function kycValidationCheck($userId)
    {
        $response = [
            'success' => true,
            'message' => __('success ')
        ];
        if (settings('kyc_enable_for_withdrawal') == STATUS_ACTIVE) {
            if (settings('kyc_nid_enable_for_withdrawal') == STATUS_ACTIVE) {
                $checkNid = checkUserKyc($userId, KYC_NID_REQUIRED, __('withdrawal '));
                if ($checkNid['success'] == false) {
                    $response = [
                        'success' => false,
                        'message' => $checkNid['message']
                    ];
                    return $response;
                } else {
                    $response = [
                        'success' => true,
                        'message' => __('success ')
                    ];
                }
            }
            if(settings('kyc_passport_enable_for_withdrawal') ==  STATUS_ACTIVE) {
                $checkPass = checkUserKyc($userId, KYC_PASSPORT_REQUIRED, __('withdrawal '));
                if ($checkPass['success'] == false) {
                    $response = [
                        'success' => false,
                        'message' => $checkPass['message']
                    ];
                    return $response;
                } else {
                    $response = [
                        'success' => true,
                        'message' => __('success ')
                    ];
                }
            }
            if(settings('kyc_driving_enable_for_withdrawal') ==  STATUS_ACTIVE) {
                $checkDrive = checkUserKyc($userId, KYC_DRIVING_REQUIRED, __('withdrawal '));
                if ($checkDrive['success'] == false) {
                    $response = [
                        'success' => false,
                        'message' => $checkDrive['message']
                    ];
                    return $response;
                } else {
                    $response = [
                        'success' => true,
                        'message' => __('success ')
                    ];
                }
            }
        } else {
            $response = [
                'success' => true,
                'message' => __('success ')
            ];
        }

        return $response;
    }

}
