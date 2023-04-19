<?php

namespace App\Http\Controllers\user;

use App\Http\Requests\WalletCreateRequest;
use App\Http\Requests\withDrawRequest;
use App\Http\Services\TransactionService;
use App\Http\Services\WalletService;
use App\Jobs\Withdrawal;
use App\Model\Coin;
use App\Model\DepositeTransaction;
use App\Model\Wallet;
use App\Model\WalletAddressHistory;
use App\Model\WithdrawHistory;
use App\Repository\WalletRepository;
use App\Services\BitCoinApiService;
use App\Services\CoinPaymentsAPI;
use App\Services\Logger;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PragmaRX\Google2FA\Google2FA;


class WalletController extends Controller
{
    public $logger;
    public $service;
    public function __construct()
    {
        $this->logger = new Logger();
        $this->service = new WalletService();
    }

    // my pocket
    public function myPocket()
    {
        $response = $this->service->myWalletList(Auth::id());
        if ($response['success'] == true) {
            return view('user.pocket.index',$response['data']);
        } else {
            return redirect()->back()->with('success',$response['message']);
        }
    }

    // make default account
    public function makeDefaultAccount($account_id, $coin_type)
    {
        Wallet::where(['user_id' => Auth::id(), 'coin_type' => $coin_type])->update(['is_primary'=>0]);
        Wallet::updateOrCreate(['id'=>$account_id],['is_primary'=>1]);

        return redirect()->back()->with('success',__('Default set successfully'));
    }

    // create new wallet
    public function createWallet(WalletCreateRequest $request)
    {
        $coin = Coin::where('type' ,$request->coin_type)->first();
        $alreadyHave = Wallet::where(['user_id' => Auth::id(), 'coin_id' => $coin->id])->first();
        if (isset($alreadyHave)) {
            return redirect()->back()->with('dismiss',__("You already have this wallet"));
        }
        if (isset($coin)) {
            $wallet = new Wallet();
            $wallet->user_id = Auth::id();
            $wallet->coin_id = $coin->id;
            $wallet->unique_code = uniqid().date('').time();
            $wallet->name = $request->wallet_name;
            $wallet->coin_type = $coin->type;
            $wallet->save();

            return redirect()->back()->with('success',__("Wallet created successfully"));
        }
        return redirect()->back()->with('dismiss',__("Coin not found"));
    }

    // wallet details
    public function walletDetails(Request $request,$id)
    {
        $data['wallet_id'] = $id;
        $data['wallet'] = Wallet::join('coins', 'coins.id', '=', 'wallets.coin_id')
            ->where(['wallets.user_id' => Auth::id(), 'coins.status' => STATUS_ACTIVE, 'wallets.id' => $id])
            ->select('wallets.*', 'coins.status as coin_status', 'coins.is_withdrawal', 'coins.minimum_withdrawal',
                'coins.maximum_withdrawal', 'coins.withdrawal_fees')
            ->first();
        if ($data['wallet']) {
            $data['histories'] = DepositeTransaction::where('receiver_wallet_id',$id)->get();
            $data['withdraws'] = WithdrawHistory::where('wallet_id',$id)->get();
            $data['active'] = $request->q;
            $data['title'] = $request->q;
            if ($data['wallet']->coin_type == DEFAULT_COIN_TYPE) {
                $repo = new WalletRepository();
                $repo->generateTokenAddress($data['wallet']->id);
                $data['wallet_address'] = WalletAddressHistory::where('wallet_id',$id)->orderBy('created_at','desc')->first();
                return view('user.pocket.default_wallet_details', $data);
            } else {
                $exists = WalletAddressHistory::where('wallet_id',$id)->orderBy('created_at','desc')->first();
                $data['address'] = (!empty($exists)) ? $exists->address : get_coin_payment_address($data['wallet']->coin_type);

                if (!empty($data['address'])) {
                    if (empty($exists)) {
                        $history = new \App\Services\wallet();
                        $history->AddWalletAddressHistory($id, $data['address'],$data['wallet']->coin_type);
                    }
                    $data['address_histories'] = WalletAddressHistory::where('wallet_id',$id)->paginate(10);

                    return view('user.pocket.wallet_details', $data);
                }
                return redirect()->back()->with('dismiss', __('Wallet address not generated.'));
            }
        } else {
            return redirect()->back()->with('dismiss', __('Wallet not found.'));
        }
    }

    // generate new wallet address
    public function generateNewAddress(Request $request)
    {
        try {
            $wallet = new \App\Services\wallet();
            $myWallet = Wallet::where(['id' => $request->wallet_id, 'user_id' => Auth::id()])->first();
            if ($myWallet) {
                if ($myWallet->coin_type == DEFAULT_COIN_TYPE) {
                    $repo = new WalletRepository();
                    $response = $repo->generateTokenAddress($myWallet->id);
                    if ($response['success'] == true) {
                        return redirect()->back()->with('success', $response['message']);
                    } else {
                        return redirect()->back()->with('dismiss', $response['message']);
                    }
                } else {
                    $address = get_coin_payment_address($myWallet->coin_type);

                    if (!empty($address)) {
                        $wallet->AddWalletAddressHistory($request->wallet_id,$address,$myWallet->coin_type);
                        return redirect()->back()->with(['success'=>__('Address generated successfully')]);
                    } else {
                        return redirect()->back()->with(['dismiss'=>__('Address not generated ')]);
                    }
                }
            } else {
                return redirect()->back()->with(['dismiss'=>__('Wallet not found')]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('dismiss', $e->getMessage());
        }

    }

    // generate qr code
    public function qrCodeGenerate(Request $request)
    {
        $image = QRCode::text($request->address)->png();
        return response($image)->header('Content-type','image/png');
    }

    // withdraw balance
    public function WithdrawBalance(withDrawRequest $request)
    {
        $transactionService = new TransactionService();

        $wallet = Wallet::join('coins', 'coins.id', '=', 'wallets.coin_id')
            ->where(['wallets.id'=>$request->wallet_id, 'wallets.user_id'=>Auth::id()])
            ->select('wallets.*', 'coins.status as coin_status', 'coins.is_withdrawal', 'coins.minimum_withdrawal',
                'coins.maximum_withdrawal', 'coins.withdrawal_fees')
            ->first();

        $user = Auth::user();
        if ($request->ajax()) {
            if(empty($wallet)) return response()->json(['success'=>false,'message'=> __('Wallet not found.')]);
            if ($wallet->balance >= $request->amount) {
                $checkValidate = $transactionService->checkWithdrawalValidation( $request, $user, $wallet);

                if ($checkValidate['success'] == false) {
                    return response()->json(['success' => $checkValidate['success'], 'message' => $checkValidate['message']]);
                }
                $checkKyc = $transactionService->kycValidationCheck($user->id);

                if ($checkKyc['success'] == false) {
                    return response()->json(['success' => $checkKyc['success'], 'message' => $checkKyc['message']]);
                }
                return response()->json(['success' => true]);

            } else {
                return response()->json(['success' => false, 'message' => __('Wallet has no enough balance')]);
            }

        } else {
            if(empty($wallet)) return redirect()->back()->with('dismiss', __('Wallet not found.'));
            $checkValidate = $transactionService->checkWithdrawalValidation( $request, $user, $wallet);

            if ($checkValidate['success'] == false) {
                return redirect()->back()->with('dismiss', $checkValidate['message']);
            }
            $checkKyc = $transactionService->kycValidationCheck($user->id);
            if ($checkKyc['success'] == false) {
                return redirect()->back()->with('dismiss', $checkKyc['message']);
            }

            $google2fa = new Google2FA();
            if (empty($request->code)) {
                return redirect()->back()->with('dismiss', __('Verify code is required'));
            }
            $valid = $google2fa->verifyKey($user->google2fa_secret, $request->code);

            $data = $request->all();
            $data['user_id'] = Auth::id();
            $request = new Request();
            $request = $request->merge($data);

            if ($valid) {
                if ($wallet->balance >= $request->amount) {
                    try {
//                        $request =$request->all();
//                        $response = $transactionService->send($request['wallet_id'],$request['address'],$request['amount'],'','',$request['user_id'],$request['message']);
//                        return $response;

                        dispatch(new Withdrawal($request->all()))->onQueue('withdrawal');
                        return redirect()->back()->with('success', __('Withdrawal placed successfully'));

                    } catch (\Exception $e) {
                        Log::error($e->getMessage());
                        return redirect()->back()->with('dismiss', __('Something went wrong.'));
                    }
                } else
                    return redirect()->back()->with('dismiss', __('Wallet has no enough balance'));
            } else
                return redirect()->back()->with('dismiss', __('Google two factor authentication is invalid'));
        }
    }

    //check internal address
    private function isInternalAddress($address)
    {
        return WalletAddressHistory::where('address', $address)->with('wallet')->first();
    }

    // transaction history
    public function transactionHistories(Request $request)
    {
        if ($request->ajax()){
            $tr = new TransactionService();
            if ($request->type == 'deposit') {
                $histories = $tr->depositTransactionHistories(Auth::id())->get();
            } else {
                $histories = $tr->withdrawTransactionHistories(Auth::id())->get();
            }
            return datatables( $histories)
                ->addColumn('address', function ($item) {
                    return $item->address;
                })
                ->addColumn('amount', function ($item) {
                    return $item->amount;
                })
                ->addColumn('hashKey', function ($item) use ($request){
                    if ($request->type == 'deposit')
                        return (!empty($item)) ? $item->transaction_id : '';
                    else
                        return (!empty($item)) ? $item->transaction_hash : '';
                })
                ->addColumn('status', function ($item) {
                    return statusAction($item->status);
                })
                ->rawColumns(['user'])
                ->make(true);
        }
    }

    // withdraw rate
    public function withdrawCoinRate(Request $request)
    {
        if ($request->ajax()) {
            $data['amount'] = isset($request->amount) ? $request->amount : 0;
            $wallet = Wallet::find($request->wallet_id);
            $data['coin_type'] = $wallet->coin_type;

            $data['coin_price'] = bcmul(settings('coin_price'),$request->amount,8);
            $coinpayment = new CoinPaymentsAPI();
            $api_rate = $coinpayment->GetRates('');

            $data['btc_dlr'] = converts_currency($data['coin_price'], $data['coin_type'],$api_rate);
            $data['btc_dlr'] = custom_number_format($data['btc_dlr']);

            return response()->json($data);
        }
    }

}
