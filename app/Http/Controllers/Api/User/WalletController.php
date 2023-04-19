<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Requests\Api\WalletCreateRequest;
use App\Http\Requests\Api\withDrawApiRequest;
use App\Http\Services\TransactionService;
use App\Jobs\Withdrawal;
use App\Model\Coin;
use App\Model\DepositeTransaction;
use App\Model\Wallet;
use App\Model\WithdrawHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WalletController extends Controller
{
    public function myPocketList(Request $request){
        $limit = $request->limit ?? 5;
        $wallets = Wallet::where(['user_id'=> Auth::id()])->orderBy('id', 'ASC')->paginate($limit);
        $data = ['success' => true, 'data' => $wallets, 'message' => __('Wallet List')];
        return response()->json($data);
    }

    public function pocketCoinList(){
        $lists = Coin::where(['status' => STATUS_ACCEPTED])->select('id','name','type','minimum_withdrawal','maximum_withdrawal','withdrawal_fees')->get();
        $data = ['success' => true, 'data' => $lists, 'message' => __('Coin List')];
        return response()->json($data);
    }

    public function createWallet(WalletCreateRequest $request){
        try {
            $coin = Coin::where('id' ,$request->coin_id)->first();
            $alreadyHave = Wallet::where(['user_id' => Auth::id(), 'coin_id' => $coin->id])->first();
            if (isset($alreadyHave)) {
                $data = ['success' => false, 'data' => [], 'message' => __('You already have this wallet')];
                return response()->json($data);
            }
            DB::beginTransaction();
            $wallet = new Wallet();
            $wallet->user_id = Auth::id();
            $wallet->coin_id = $coin->id;
            $wallet->unique_code = uniqid().date('').time();
            $wallet->name = $request->wallet_name;
            $wallet->coin_type = $coin->type;
            $wallet->save();
            DB::commit();
            $data = ['success' => true, 'data' => $wallet, 'message' => __('Wallet created successfully')];
        } catch (\Exception $e) {
            Log::alert($e->getMessage());
            DB::rollBack();
            $data = ['success' => false, 'data' => [], 'message' => __('Something went wrong.')];
        }
        return response()->json($data);
    }

    public function walletDetailsByid(Request $request)
    {
        if(isset($request->wallet_id)){
            $data['wallet_id'] = $request->wallet_id;
            $data['wallet_details'] = Wallet::select('wallets.*')
                ->where(['wallets.id' => $request->wallet_id, 'wallets.user_id' => Auth::id()])
                ->first();
            return response()->json(['success' => true, 'data' => $data, 'message' => __('Wallet details')]);
        }
        else{
            return response()->json(['success' => false, 'data' => [], 'message' => __('Wallet ID not found!')]);
        }
    }

    public function gotoAddressApp(Request $request)
    {
        try {
            if($request->wallet_id){
                $address = DB::table('wallet_address_histories')->select('wallet_address_histories.address')
                    ->where('wallet_address_histories.wallet_id', '=', $request->wallet_id)
                    ->orderBy('wallet_address_histories.id','DESC')
                    ->first();
            }
            if(isset($address->address)) {
                return response()->json(['success' => true, 'data' => ['address'=>$address->address], 'message' => __('Address found successfully')]);
            } else {
                $myWallet = Wallet::find($request->wallet_id);
                $address = get_coin_payment_address($myWallet->coin_type);
                return response()->json(['success' => true, 'data' => ['address'=>$address], 'message' => __('Address not found')]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => __($e->getMessage())]);
        }
    }

    public function generateNewAddressApp(Request $request)
    {
        try {
            $wallet = new \App\Services\wallet();
            $myWallet = Wallet::find($request->wallet_id);
            $address = get_coin_payment_address($myWallet->coin_type);
            if (!empty($address)) {
                $wallet->AddWalletAddressHistory($request->wallet_id, $address, $myWallet->coin_type);
                return response()->json(['success' => true, 'data' => ['address'=>$address], 'message' => __('Address generated successfully')]);
            } else {
                return response()->json(['success' => true, 'data' => [], 'message' => __('Address not generated')]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => __($e->getMessage())]);
        }
    }

    public function showPassAddress(Request $request){
        try {
            if($request->wallet_id){
                $addresses = DB::table('wallet_address_histories')->select('wallet_address_histories.address')
                    ->where('wallet_address_histories.wallet_id', '=', $request->wallet_id)
                    ->get();
                return response()->json(['success' => true, 'data' => ['addresses'=>$addresses], 'message' => __('Address List')]);
            }
            else{
                return response()->json(['success' => false, 'data' => [], 'message' => __('Wallet Id not found!')]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => __($e->getMessage())]);
        }
    }

    public function depositList(Request $request){
        try {
            $limit = $request->limit ?? 5;
            if($request->wallet_id){
                $histories = DepositeTransaction::where('receiver_wallet_id', $request->wallet_id)->orderBy('id','desc')->paginate($limit);
                return response()->json(['success' => true, 'data' => ['deposites'=>$histories], 'message' => __('Deposite List')]);
            }
            else{
                return response()->json(['success' => false, 'data' => [], 'message' => __('Wallet missing')]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => __($e->getMessage())]);
        }
    }

    public function withdrawList(Request $request){
        try {
            $limit = $request->limit ?? 5;
            if($request->wallet_id){
                $withdraws = WithdrawHistory::where('wallet_id', $request->wallet_id)->orderBy('id','desc')->paginate($limit);
                return response()->json(['success' => true, 'data' => ['withdraws'=>$withdraws], 'message' => __('Withdraw List')]);
            }
            else{
                return response()->json(['success' => false, 'data' => [], 'message' => __('Wallet missing')]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => __($e->getMessage())]);
        }
    }

    public function withdrawalProcess(withDrawApiRequest $request)
    {
        $transactionService = new TransactionService();
        $wallet = Wallet::join('coins', 'coins.id', '=', 'wallets.coin_id')
            ->where(['wallets.id'=>$request->wallet_id, 'wallets.user_id'=>Auth::id()])
            ->select('wallets.*', 'coins.status as coin_status', 'coins.is_withdrawal', 'coins.minimum_withdrawal',
                'coins.maximum_withdrawal', 'coins.withdrawal_fees')
            ->first();
        $user = Auth::user();
        if(empty($wallet)) return response()->json(['success'=>false,'message'=> __('Wallet not found.')]);
        if ($wallet->balance >= $request->amount) {
            $checkValidate = $transactionService->checkWithdrawalValidation( $request, $user, $wallet);
            if ($checkValidate['success'] == false) {
                return response()->json(['success' => $checkValidate['success'], 'message' => $checkValidate['message']]);
            }
        } else {
            return response()->json(['success' => false, 'message' => __('Wallet has no enough balance')]);
        }
        $google2fa = new Google2FA();
        if (empty($request->code)) {
            return response()->json(['success'=>false,'message'=> __('Verify code is required')]);
        }
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->code);
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $request = new Request();
        $request = $request->merge($data);
        if ($valid) {
            try {
                dispatch(new Withdrawal($request->all()))->onQueue('withdrawal');
                return response()->json(['success'=>true,'message'=> __('Withdrawal placed successfully')]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
                return response()->json(['success'=>false,'message'=> __('Something went wrong.')]);
            }
        } else{
            return response()->json(['success'=>false,'message'=> __('Google two factor authentication is invalid')]);
        }
    }

}
