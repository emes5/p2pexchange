<?php

namespace App\Http\Controllers\user;

use App\Http\Services\TransactionService;
use App\Model\DepositeTransaction;
use App\Model\Wallet;
use App\Model\WithdrawHistory;
use App\Repository\WalletRepository;
use App\Services\Logger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepositController extends Controller
{
    private $logger;
    public function __construct()
    {
        $this->logger = new Logger();
    }

    // when deposit will complete this function should be called
    public function defaultDepositCallback(Request $request)
    {
        $this->logger->log('call deposit wallet');
        $data = ['success'=>false,'message'=>'something went wrong'];

        DB::beginTransaction();
        try {
            $request = (object)$request;
            Log::info(json_encode($request));

            $walletAddress = DepositeTransaction::where('transaction_id', $request->transactionHash)->first();
            $wallet = Wallet::where("user_id",Auth::id())->where("coin_type", DEFAULT_COIN_TYPE)->first();

            if (empty($walletAddress) && !empty($wallet)) {

                //    $wallet =  $walletAddress->wallet;
                $data['user_id'] = $wallet->user_id;
                if (!empty($wallet)){
                    $checkDeposit = DepositeTransaction::where('transaction_id', $request->transactionHash)->first();
                    if (isset($checkDeposit)) {
                        $data = ['success'=>false,'message'=>'Transaction id already exists in deposit'];
                        Log::info('Transaction id already exists in deposit');
                        return $data;
                    }
                    $depositData = [
                        'address' => $request->from,
                        'address_type' => ADDRESS_TYPE_EXTERNAL,
                        'amount' => $request->value,
                        'fees' => 0,
                        'doller' => $request->transactionIndex * settings('coin_price'),
                        'btc' => 0,
                        'type' => $wallet->coin_type,
                        'transaction_id' => $request->transactionHash,
                        'confirmations' => $request->blockNumber,
                        'status' => STATUS_SUCCESS,
                        'receiver_wallet_id' => $wallet->id
                    ];

                    $depositCreate = DepositeTransaction::create($depositData);
                    Log::info(json_encode($depositCreate));

                    if (($depositCreate)) {
                        Log::info('Balance before deposit '.$wallet->balance);
                        $wallet->increment('balance', $depositCreate->amount);

                        Log::info('Balance after deposit '.$wallet->balance);
                        $data['message'] = 'Deposited successfully';
                        $data['hash'] = $request->transactionHash;
                        $data['success'] = true;
                    } else {
                        Log::info('Deposit not created ');
                        $data['message'] = 'Deposit not created';
                        $data['success'] = false;
                    }

                } else {
                    $data = ['success'=>false,'message'=>'No wallet found'];
                    Log::info('No wallet found');
                }
            }

            DB::commit();
            return $data;
        } catch (\Exception $e) {
            $data['message'] = $e->getMessage().' '.$e->getLine();
            Log::info($data['message']);
            DB::rollback();

            return $data;
        }
    }

    // when withdrawal will complete then it should be called
    public function defaultCallback(Request $request)
    {
        try {
            $temp = WithdrawHistory::find($request->temp);
            $temp->status = STATUS_ACCEPTED;
            $temp->transaction_hash = $request->hash;
            $temp->save();

            $wallet = Wallet::find($temp->wallet_id);
            $deductAmount = $temp->amount + $temp->fees;
            $wallet->decrement('balance', $deductAmount);

            $data['success'] = true;
            $data['message'] = __('Withdrawal is now completed');
            $data['hash'] = $request->hash;
        }catch (\Exception $exception){
            $data['success'] = false;
            $data['message'] = __('Something went wrong');
        }
        return response()->json($data);

    }

    // when withdrawal failed then it should be called
    public function withdrawalCancelCallback(Request $request)
    {
        DB::beginTransaction();
        try {
            $temp = WithdrawHistory::find($request->temp_id);
            if ($temp) {
                $temp->delete();

                DB::commit();
                $data['success'] = true;
                $data['message'] = __('Withdrawal cancelled');
            } else {
                $this->logger->log('withdrawalCancelCallback','temp withdrawal not found '.$request->temp_id);
                $data['success'] = false;
                $data['message'] = __('Temp withdrawal not found');
            }
        } catch (\Exception $exception) {
            $this->logger->log('withdrawalCancelCallback',$exception->getMessage());
            DB::rollBack();
            $data['success'] = false;
            $data['message'] = __('Something went wrong');
        }
        return response()->json($data);
    }

    // default coin balance check at withdrawal process
    public function checkDefaultBalance($balance,Request $request)
    {
        Log::info('withdrawal balance '. $balance);
        Log::info($request->all());
        $transactionService = new TransactionService();
        $wallet = Wallet::join('coins', 'coins.id', '=', 'wallets.coin_id')
            ->where(['wallets.user_id' => Auth::id(), 'wallets.coin_type' => DEFAULT_COIN_TYPE])
            ->select('wallets.*', 'coins.status as coin_status', 'coins.is_withdrawal', 'coins.minimum_withdrawal',
                'coins.maximum_withdrawal', 'coins.withdrawal_fees')
            ->first();
        $user = Auth::user();
        if ($wallet) {
            $data['success'] = $balance < $wallet->balance;
            Log::info('with bl '. $balance);
            Log::info('wallet bl '. $wallet->balance);
            if ($data['success']){
                $checkKyc = $transactionService->kycValidationCheck($user->id);
                if ($checkKyc['success'] == false) {
                    return response()->json(['success' => $checkKyc['success'], 'message' => $checkKyc['message']]);
                }
                $checkValidate = $transactionService->checkWithdrawalValidation( $request, $user, $wallet);
                Log::info(json_encode($checkValidate));
                if ($checkValidate['success'] == false) {
                    return response()->json(['success' => $checkValidate['success'], 'message' => $checkValidate['message']]);
                } else {
                    $result = $transactionService->sendChainExternal($wallet->id,$request->address,$request->amount);
                    Log::info('withdrawal result '.json_encode($result));
                    if ($result['success']){
                        $data['cl'] = allsetting('chain_link');
                        $data['ca'] = allsetting('contract_address');
                        $data['wa'] = allsetting('wallet_address');
                        $data['pk'] = allsetting('private_key');
                        $data['chain_link'] = allsetting('chain_link');
                        $data['success'] = true;
                        $data['message'] = $result['message'];
                        $data['temp'] = $result['temp'];
                        Log::info('chain '.json_encode($data));
                        return $data;
                    } else {
                        return response()->json($result);
                    }
                }
            }else{
                $data['message'] = __("Amount can't be more then available balance");
                $data['success'] = false;
                Log::info($data);
                return response()->json($data);
            }
        } else {
            $data['message'] = __("Wallet not found");
            $data['success'] = false;
            Log::info($data);
            return response()->json($data);
        }
    }

    // default coin withdrawal page
    public function withdrawalDefaultCoin()
    {
        $data['wallet'] = Wallet::join('coins', 'coins.id', '=', 'wallets.coin_id')
            ->where(['wallets.user_id' => Auth::id(), 'wallets.coin_type' => DEFAULT_COIN_TYPE])
            ->select('wallets.*', 'coins.status as coin_status', 'coins.is_withdrawal', 'coins.minimum_withdrawal',
                'coins.maximum_withdrawal', 'coins.withdrawal_fees')
            ->first();
        if ($data['wallet']) {
            $repo = new WalletRepository();
            $repo->generateTokenAddress($data['wallet']->id);
            $data['wallet_id'] = $data['wallet']->id;
            $data['active'] = 'withdraw';
            $data['title'] = __('Withdraw coin');

            return view('user.pocket.default_wallet_details', $data);
        } else {
            return redirect()->back()->with('dismiss', __('Wallet not found'));
        }
    }
}
