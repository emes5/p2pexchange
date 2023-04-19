<?php
namespace App\Repository;
use App\Model\Admin\Bank;
use App\Model\AdminSetting;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SettingRepository
{

    // save landing setting
    public function saveAdminSetting($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            foreach ($request->except('_token') as $key => $value) {

                if ($request->hasFile($key)) {
                    $image = uploadFile($request->$key, IMG_PATH, isset(allsetting()[$key]) ? allsetting()[$key] : '');
                    AdminSetting::updateOrCreate(['slug' => $key],['slug' => $key, 'value' => $image]);
                } else {
                    AdminSetting::updateOrCreate(['slug' => $key],['slug' => $key, 'value' => $value]);
                }
            }

            $response = [
                'success' => true,
                'message' => __('Setting updated successfully')
            ];
        } catch (\Exception $e) {
            Log::info('saveAdminSetting --> '. $e->getMessage());
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }


    // save general setting
    public function saveCommonSetting($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            if (isset($request->lang)) {
                AdminSetting::where('slug', 'lang')->update(['value' => $request->lang]);
            }
            if (isset($request->coin_price)) {
                AdminSetting::where('slug', 'coin_price')->update(['value' => $request->coin_price]);
            }
            if (isset($request->coin_name)) {
                AdminSetting::where('slug', 'coin_name')->update(['value' => $request->coin_name]);
            }
            if (isset($request->logo)) {

                AdminSetting::where('slug', 'logo')->update(['value' => uploadFile($request->logo,IMG_PATH,allsetting()['logo'])]);
            }
            if (isset($request->favicon)) {
                AdminSetting::where('slug', 'favicon')->update(['value' => uploadFile($request->favicon,IMG_PATH,allsetting()['favicon'])]);
            }
            if (isset($request->login_logo)) {
                AdminSetting::where('slug', 'login_logo')->update(['value' => uploadFile($request->login_logo,IMG_PATH,allsetting()['login_logo'])]);
            }
            if (isset($request->company_name)) {
                AdminSetting::where('slug', 'company_name')->update(['value' => $request->company_name]);
                AdminSetting::where('slug', 'app_title')->update(['value' => $request->company_name]);
            }
            if (isset($request->copyright_text)) {
                AdminSetting::where('slug', 'copyright_text')->update(['value' => $request->copyright_text]);
            }
            if (isset($request->primary_email)) {
                AdminSetting::where('slug', 'primary_email')->update(['value' => $request->primary_email]);
            }
            if (isset($request->mail_from)) {
                AdminSetting::where('slug', 'mail_from')->update(['value' => $request->mail_from]);
            }
            if (isset($request->twilo_id)) {
                AdminSetting::where('slug', 'twilo_id')->update(['value' => $request->twilo_id]);
            }
            if (isset($request->twilo_token)) {
                AdminSetting::where('slug', 'twilo_token')->update(['value' => $request->twilo_token]);
            }
            if (isset($request->sender_phone_no)) {
                AdminSetting::where('slug', 'sender_phone_no')->update(['value' => $request->sender_phone_no]);
            }
            if (isset($request->ssl_verify)) {
                AdminSetting::where('slug', 'ssl_verify')->update(['value' => $request->ssl_verify]);
            }

            if (isset($request->maintenance_mode)) {
                AdminSetting::where('slug', 'maintenance_mode')->update(['value' => $request->maintenance_mode]);
            }
            if (isset($request->admin_coin_address)) {
                AdminSetting::updateOrCreate(['slug' => 'admin_coin_address'], ['value' => $request->admin_coin_address]);
            }
            if (isset($request->base_coin_type)) {
                AdminSetting::updateOrCreate(['slug' => 'base_coin_type'], ['value' => $request->base_coin_type]);
            }
            if (isset($request->admin_usdt_account_no)) {
                AdminSetting::updateOrCreate(['slug' => 'admin_usdt_account_no'], ['value' => $request->admin_usdt_account_no]);
            }
            if (isset($request->number_of_confirmation)) {
                AdminSetting::updateOrCreate(['slug' => 'number_of_confirmation'], ['value' => $request->number_of_confirmation]);
            }
            if (isset($request->company_address)) {
                AdminSetting::updateOrCreate(['slug' => 'company_address'], ['value' => $request->company_address]);
            }
            if (isset($request->company_mobile_no)) {
                AdminSetting::updateOrCreate(['slug' => 'company_mobile_no'], ['value' => $request->company_mobile_no]);
            }
            if (isset($request->company_email_address)) {
                AdminSetting::updateOrCreate(['slug' => 'company_email_address'], ['value' => $request->company_email_address]);
            }
            if (isset($request->escrow_fees)) {
                AdminSetting::updateOrCreate(['slug' => 'escrow_fees'], ['value' => $request->escrow_fees]);
            }
            if (isset($request->trade_fees)) {
                AdminSetting::updateOrCreate(['slug' => 'trade_fees'], ['value' => $request->trade_fees]);
            }
            if (isset($request->buy_coin_feature)) {
                AdminSetting::updateOrCreate(['slug' => 'buy_coin_feature'], ['value' => $request->buy_coin_feature]);
            }
            if (isset($request->host_chart)) {
                AdminSetting::updateOrCreate(['slug' => 'host_chart'], ['value' => $request->host_chart]);
            }
            if (isset($request->key_chart)) {
                AdminSetting::updateOrCreate(['slug' => 'key_chart'], ['value' => $request->key_chart]);
            }
            if (isset($request->NOCAPTCHA_SECRET)) {
                AdminSetting::updateOrCreate(['slug' => 'NOCAPTCHA_SECRET'], ['value' => $request->NOCAPTCHA_SECRET]);
            }
            if (isset($request->NOCAPTCHA_SITEKEY)) {
                AdminSetting::updateOrCreate(['slug' => 'NOCAPTCHA_SITEKEY'], ['value' => $request->NOCAPTCHA_SITEKEY]);
            }
            if (isset($request->google_recapcha)) {
                AdminSetting::updateOrCreate(['slug' => 'google_recapcha'], ['value' => $request->google_recapcha]);
            }
            else{
                AdminSetting::updateOrCreate(['slug' => 'google_recapcha'], ['value' => STATUS_DEACTIVE]);
            }
            if (isset($request->font_file_path)) {
                AdminSetting::updateOrCreate(['slug' => 'font_file_path'], ['value' => $request->font_file_path]);
            }
            if (isset($request->font_file_name)) {
                AdminSetting::updateOrCreate(['slug' => 'font_file_name'], ['value' => $request->font_file_name]);
            }
            if (isset($request->font_enable)) {
                AdminSetting::updateOrCreate(['slug' => 'font_enable'], ['value' => STATUS_SUCCESS]);
            }
            else{
                AdminSetting::updateOrCreate(['slug' => 'font_enable'], ['value' => STATUS_DEACTIVE]);
            }

            $response = [
                'success' => true,
                'message' => __('General setting updated successfully')
            ];
        } catch (\Exception $e) {
            Log::info('saveCommonSetting --> '. $e->getMessage());
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }

    // save email setting
    public function saveEmailSetting($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {

            if (isset($request->mail_host)) {
                AdminSetting::updateOrCreate(['slug' => 'mail_host'], ['value' => $request->mail_host]);
            }
            if (isset($request->mail_port)) {
                AdminSetting::updateOrCreate(['slug' => 'mail_port'], ['value' => $request->mail_port]);
            }
            if (isset($request->mail_username)) {
                AdminSetting::updateOrCreate(['slug' => 'mail_username'], ['value' => $request->mail_username]);
            }
            if (isset($request->mail_password)) {
                AdminSetting::updateOrCreate(['slug' => 'mail_password'], ['value' => $request->mail_password]);
            }
            if (isset($request->mail_encryption)) {
                AdminSetting::updateOrCreate(['slug' => 'mail_encryption'], ['value' => $request->mail_encryption]);
            }
            if (isset($request->mail_from_address)) {
                AdminSetting::updateOrCreate(['slug' => 'mail_from_address'], ['value' => $request->mail_from_address]);
            }
            $response = [
                'success' => true,
                'message' => __('Email setting updated successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }

    // save email setting
    public function saveTwilloSetting($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {

            if (isset($request->twillo_secret_key)) {
                AdminSetting::updateOrCreate(['slug' => 'twillo_secret_key'], ['value' => $request->twillo_secret_key]);
            }
            if (isset($request->twillo_auth_token)) {
                AdminSetting::updateOrCreate(['slug' => 'twillo_auth_token'], ['value' => $request->twillo_auth_token]);
            }
            if (isset($request->twillo_number)) {
                AdminSetting::updateOrCreate(['slug' => 'twillo_number'], ['value' => $request->twillo_number]);
            }

            $response = [
                'success' => true,
                'message' => __('Twillo setting updated successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }


    // save payment setting
    public function savePaymentSetting($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {

            if (isset($request->COMPARE_WEBSITE)) {
                AdminSetting::updateOrCreate(['slug' => 'COMPARE_WEBSITE'], ['value' => $request->COMPARE_WEBSITE]);
            }
            if (isset($request->COIN_PAYMENT_PUBLIC_KEY)) {
                AdminSetting::updateOrCreate(['slug' => 'COIN_PAYMENT_PUBLIC_KEY'], ['value' => $request->COIN_PAYMENT_PUBLIC_KEY]);
            }
            if (isset($request->COIN_PAYMENT_PRIVATE_KEY)) {
                AdminSetting::updateOrCreate(['slug' => 'COIN_PAYMENT_PRIVATE_KEY'], ['value' => $request->COIN_PAYMENT_PRIVATE_KEY]);
            }
            if (isset($request->COINPAYMENT_CURRENCY)) {
                AdminSetting::updateOrCreate(['slug' => 'COINPAYMENT_CURRENCY'], ['value' => $request->COINPAYMENT_CURRENCY]);
            }
            if (isset($request->base_coin_type)) {
                AdminSetting::updateOrCreate(['slug' => 'base_coin_type'], ['value' => $request->base_coin_type]);
            }
            if (isset($request->base_coin_type)) {
                AdminSetting::updateOrCreate(['slug' => 'base_coin_type'], ['value' => $request->base_coin_type]);
            }
            if (isset($request->ipn_merchant_id)) {
                AdminSetting::updateOrCreate(['slug' => 'ipn_merchant_id'], ['value' => $request->ipn_merchant_id]);
            }
            if (isset($request->ipn_secret)) {
                AdminSetting::updateOrCreate(['slug' => 'ipn_secret'], ['value' => $request->ipn_secret]);
            }

            $response = [
                'success' => true,
                'message' => __('Payment setting updated successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }

    // save withdraw setting
    public function saveWithdrawSetting($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            AdminSetting::updateOrCreate(['slug' => 'minimum_withdrawal_amount'], ['value' => $request->minimum_withdrawal_amount]);
            AdminSetting::updateOrCreate(['slug' => 'maximum_withdrawal_amount'], ['value' => $request->maximum_withdrawal_amount]);
            AdminSetting::updateOrCreate(['slug' => 'max_send_limit'], ['value' => $request->max_send_limit]);
            AdminSetting::updateOrCreate(['slug' => 'send_fees_type'], ['value' => $request->send_fees_type]);
            AdminSetting::updateOrCreate(['slug' => 'send_fees_fixed'], ['value' => $request->send_fees_type]);
            AdminSetting::updateOrCreate(['slug' => 'send_fees_percentage'], ['value' => $request->send_fees_percentage]);

            $response = [
                'success' => true,
                'message' => __('Withdrawal setting updated successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }


    // save referral setting
    public function saveReferralSetting($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            if (isset($request->referral_signup_reward)) {
                AdminSetting::updateOrCreate(['slug' => 'referral_signup_reward'], ['value' => $request->referral_signup_reward]);
            }
            if (isset($request->max_affiliation_level)) {
                AdminSetting::updateOrCreate(['slug' => 'max_affiliation_level'], ['value' => $request->max_affiliation_level]);
            }
            if (isset($request->fees_level1)) {
                AdminSetting::updateOrCreate(['slug' => 'fees_level1'], ['value' => $request->fees_level1]);
            }
            if (isset($request->fees_level2)) {
                AdminSetting::updateOrCreate(['slug' => 'fees_level2'], ['value' => $request->fees_level2]);
            }
            if (isset($request->fees_level3)) {
                AdminSetting::updateOrCreate(['slug' => 'fees_level3'], ['value' => $request->fees_level3]);
            }
            if (isset($request->fees_level4)) {
                AdminSetting::updateOrCreate(['slug' => 'fees_level4'], ['value' => $request->fees_level4]);
            }
            if (isset($request->fees_level5)) {
                AdminSetting::updateOrCreate(['slug' => 'fees_level5'], ['value' => $request->fees_level5]);
            }
            if (isset($request->fees_level6)) {
                AdminSetting::updateOrCreate(['slug' => 'fees_level6'], ['value' => $request->fees_level6]);
            }
            if (isset($request->fees_level7)) {
                AdminSetting::updateOrCreate(['slug' => 'fees_level7'], ['value' => $request->fees_level7]);
            }
            if (isset($request->fees_level8)) {
                AdminSetting::updateOrCreate(['slug' => 'fees_level8'], ['value' => $request->fees_level8]);
            }
            if (isset($request->fees_level9)) {
                AdminSetting::updateOrCreate(['slug' => 'fees_level9'], ['value' => $request->fees_level9]);
            }
            if (isset($request->fees_level10)) {
                AdminSetting::updateOrCreate(['slug' => 'fees_level10'], ['value' => $request->fees_level10]);
            }
            $response = [
                'success' => true,
                'message' => __('Referral setting updated successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }

    // save default coin setting
    public function defaultCoinSettingUpdate($request)
    {
        try {
            if (isset($request->chain_id)) {
                AdminSetting::updateOrCreate(['slug' => 'chain_id'], ['value' => $request->chain_id]);
            }
            if (isset($request->chain_link)) {
                AdminSetting::updateOrCreate(['slug' => 'chain_link'], ['value' => $request->chain_link]);
            }
            if (isset($request->contract_address)) {
                AdminSetting::updateOrCreate(['slug' => 'contract_address'], ['value' => $request->contract_address]);
            }
            if (isset($request->wallet_address)) {
                AdminSetting::updateOrCreate(['slug' => 'wallet_address'], ['value' => $request->wallet_address]);
            }
            if (isset($request->private_key)) {
                AdminSetting::updateOrCreate(['slug' => 'private_key'], ['value' => $request->private_key]);
            }
            if (isset($request->contract_decimal)) {
                AdminSetting::updateOrCreate(['slug' => 'contract_decimal'], ['value' => $request->contract_decimal]);
            }
            if (isset($request->gas_limit)) {
                AdminSetting::updateOrCreate(['slug' => 'gas_limit'], ['value' => $request->gas_limit]);
            }
            if (isset($request->contract_coin_name)) {
                AdminSetting::updateOrCreate(['slug' => 'contract_coin_name'], ['value' => $request->contract_coin_name]);
                AdminSetting::where('slug', 'contract_coin_name')->update(['value' => $request->contract_coin_name]);
            }
            if (isset($request->coin_name)) {
                AdminSetting::updateOrCreate(['slug' => 'coin_name'], ['value' => $request->coin_name]);
            }
            if (isset($request->coin_price)) {
                AdminSetting::updateOrCreate(['slug' => 'coin_price'], ['value' => $request->coin_price]);
            }
            $response = [
                'success' => true,
                'message' => __('Coin setting updated successfully')
            ];
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
        return $response;
    }

}