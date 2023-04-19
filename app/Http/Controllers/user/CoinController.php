<?php

namespace App\Http\Controllers\user;

use App\Http\Requests\BuyCoinRequest;
use App\Model\Bank;
use App\Model\BuyCoinHistory;
use App\Model\Coin;
use App\Model\IcoPhase;
use App\Repository\CoinRepository;
use App\Services\CoinPaymentsAPI;
use App\Services\Logger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CoinController extends Controller
{
    private $log;
    public function __construct()
    {
        $this->log = new Logger();
    }
    // buy coin
    public function buyCoinPage()
    {
        try {
            $data['title'] = __('Buy Coin');
            $data['settings'] = allsetting();
            $data['banks'] = Bank::where(['status' => STATUS_ACTIVE])->get();
            if(env('APP_ENV') == 'local') {
                $data['coins'] = Coin::where(['status' => STATUS_ACTIVE])->where('type', '<>', DEFAULT_COIN_TYPE)->get();
            } else {
                $data['coins'] = Coin::where(['status' => STATUS_ACTIVE])->whereNotIn('type', [DEFAULT_COIN_TYPE,COIN_TYPE_LTCT])->get();
            }
            $baseCoin = strtoupper(allsetting('base_coin_type')) ?? 'BTC';
            $url = file_get_contents('https://min-api.cryptocompare.com/data/price?fsym=USD&tsyms='.$baseCoin);
            $data['coin_price'] = settings('coin_price');
            $data['btc_dlr'] = (settings('coin_price') * json_decode($url,true)[$baseCoin]);
            $data['btc_dlr'] = custom_number_format($data['btc_dlr']);

            $activePhases = checkAvailableBuyPhase();

            $data['no_phase'] = false;
            if ($activePhases['status'] == false) {
                $data['no_phase'] = true;
            } else {
                if ($activePhases['futurePhase'] == false) {
                    $phase_info = $activePhases['pahse_info'];
                    if (isset($phase_info)) {
                        $data['coin_price'] =  number_format($phase_info->rate,4);
                        $data['btc_dlr'] = ($data['coin_price'] * json_decode($url,true)[$baseCoin]);
                        $data['btc_dlr'] = custom_number_format($data['btc_dlr']);
                    }
                }
            }
            $data['activePhase'] = $activePhases;

            return view('user.buy_coin.index',$data);
        } catch (\Exception $e) {
            $this->log->log('buyCoinPage', $e->getMessage());
            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }

    }

    public function buyCoinRate(Request $request)
    {
        if ($request->ajax()) {
            $data['amount'] = isset($request->amount) ? $request->amount : 0;

            $data['coin_type'] = isset($request->payment_type) ? check_coin_type($request->payment_type) : strtoupper(allsetting('base_coin_type'));

            $coin_price = settings('coin_price');
            $activePhases = checkAvailableBuyPhase();
            $data['phase_fees'] = 0;
            $data['bonus'] = 0;
            $data['no_phase'] = false;
            if ($activePhases['status'] == false) {
                $data['no_phase'] = true;
            } else {
                if ($activePhases['futurePhase'] == false) {

                    $phase_info = $activePhases['pahse_info'];
                    if (isset($phase_info)) {
                        $coin_price =  customNumberFormat($phase_info->rate);
                        $data['phase_fees'] = calculate_phase_percentage($data['amount'], $phase_info->fees);
                        $affiliation_percentage = 0;
                        $data['bonus'] = calculate_phase_percentage($data['amount'], $phase_info->bonus);


                        // $coin_amount = ($data['amount'] + $data['bonus']) - ($data['phase_fees'] + $affiliation_percentage);
                        $coin_amount = ($data['amount'] - $data['bonus']);
                        $data['amount'] = $coin_amount;
                        $data['phase_fees'] = customNumberFormat($data['phase_fees']);
                    }
                }
            }

            $data['coin_price'] = bcmul($coin_price,$data['amount'],8);
            $data['coin_price'] = customNumberFormat($data['coin_price']);
            if ($request->pay_type == BTC) {
                $coinpayment = new CoinPaymentsAPI();
                $api_rate = $coinpayment->GetRates('');


                $data['btc_dlr'] = converts_currency($data['coin_price'], $data['coin_type'],$api_rate);

            } else {
                $data['coin_type'] = allsetting('base_coin_type');
                $url = file_get_contents('https://min-api.cryptocompare.com/data/price?fsym=USD&tsyms='.$data['coin_type']);
                $data['btc_dlr'] = $data['coin_price'] * (json_decode($url,true)[$data['coin_type']]);
            }

            $data['btc_dlr'] = custom_number_format($data['btc_dlr']);

            return response()->json($data);
        }
    }


    // buy coin process
    public function buyCoin(BuyCoinRequest $request)
    {
        try {
            $baseCoin = strtoupper(allsetting('base_coin_type')) ?? 'BTC';
            $coinRepo = new CoinRepository();
            $url = file_get_contents('https://min-api.cryptocompare.com/data/price?fsym=USD&tsyms='.$baseCoin);

            if (isset(json_decode($url, true)[$baseCoin])) {
                $bonus_percentage = 0;
                $bonus = 0;
                $coin_amount = $request->coin;
                $phase_id = '';

                if (isset($request->phase_id)) {
                    $phase = IcoPhase::where('id',$request->phase_id)->first();
                    if (isset($phase)) {
                        $total_sell = BuyCoinHistory::where('phase_id',$phase->id)->sum('coin');
                        if (($total_sell + $coin_amount) > $phase->amount) {
                            return redirect()->back()->with('dismiss', __('Insufficient phase amount'));
                        }
                        $phase_id = $phase->id;
                        $bonus_percentage = $phase->bonus;
                        $bonus = calculate_phase_percentage($request->coin, $phase->bonus);
                        $coin_amount = $request->coin ;

                        $coin_price_doller = bcmul($coin_amount, $phase->rate,8);
                        $coin_price_btc = bcmul(custom_number_format(json_decode($url, true)[$baseCoin]), $coin_price_doller,8);
                    } else {
                        $coin_price_doller = bcmul($request->coin, settings('coin_price'),8);
                        $coin_price_btc = bcmul(custom_number_format(json_decode($url, true)[$baseCoin]), $coin_price_doller,8);
                    }

                } else {
                    $coin_price_doller = bcmul($request->coin, settings('coin_price'),8);
                    $coin_price_btc = bcmul(custom_number_format(json_decode($url, true)[$baseCoin]), $coin_price_doller,8);
                }

                if ($request->payment_type == BTC) {
                    $buyCoinWithCoinPayment = $coinRepo->buyCoinWithCoinPayment($request, $coin_amount, $coin_price_doller,$phase_id, $bonus, $bonus_percentage);

                    if($buyCoinWithCoinPayment['success'] == true) {
                        return redirect()->route('buyCoinByAddress', $buyCoinWithCoinPayment['data']->address)->with('success', $buyCoinWithCoinPayment['message']);

                    } else {
                        return redirect()->back()->with('dismiss', $buyCoinWithCoinPayment['message']);
                    }

                }  elseif ($request->payment_type == BANK_DEPOSIT) {
                    $buyCoinWithBank = $coinRepo->buyCoinWithBank($request, $coin_amount, $coin_price_doller, $coin_price_btc, $phase_id, $bonus, $bonus_percentage);

                    if($buyCoinWithBank['success'] == true) {
                        return redirect()->back()->with('success', $buyCoinWithBank['message']);

                    } else {
                        return redirect()->back()->with('dismiss', $buyCoinWithBank['message']);
                    }
                } else {
                    return redirect()->back()->with('dismiss', "Something went wrong");
                }
            } else {
                return redirect()->back()->with('dismiss', "Something went wrong");
            }
        } catch (\Exception $e) {
            $this->log->log('buyCoin', $e->getMessage());
            return redirect()->back()->with('dismiss', "Something went wrong");
        }
    }

    //bank details
    public function bankDetails(Request $request)
    {
        try {
            $data = ['success' => false, 'message' => __('Invalid request'), 'data_genetare'=> ''];
            $data_genetare = '';
            if(isset($request->val)) {
                $bank = Bank::where('id', $request->val)->first();
                if (isset($bank)) {
                    $data_genetare = '<div class="cp-user-card-header-area mt-5"><h4 class="text-center">'.__('Bank Details').'</h4></div><table class="table">';
                    $data_genetare .= '<tr><td>'.__("Bank Name").' :</td> <td>'.$bank->bank_name.'</td></tr>';
                    $data_genetare .= '<tr><td>'.__("Account Holder Name").' :</td> <td>'.$bank->account_holder_name.'</td></tr>';
                    $data_genetare .= '<tr><td>'.__("Bank Address").' :</td> <td>'.$bank->bank_address.'</td></tr>';
                    $data_genetare .= '<tr><td>'.__("Country").' :</td> <td>'.countrylist($bank->country).'</td></tr>';
                    $data_genetare .= '<tr><td>'.__("IBAN").' :</td> <td>'.$bank->iban.'</td></tr>';
                    $data_genetare .= '<tr><td>'.__("Swift Code").' :</td> <td>'.$bank->swift_code.'</td></tr>';
                    $data_genetare .= '</table>';
                    $data['data_genetare'] = $data_genetare;
                    $data['success'] = true;
                    $data['message'] = __('Data get successfully.');
                }
            }

            return response()->json($data);
        } catch (\Exception $e) {
            $this->log->log('bankDetails', $e->getMessage());
        }
    }

    // coin payment success page
    public function buyCoinByAddress($address)
    {
        $data['title'] = __('Coin Payment');
        if (is_numeric($address)) {
            $coinAddress = BuyCoinHistory::where(['user_id' => Auth::id(), 'id' => $address, 'status' => STATUS_PENDING])->first();
        } else {
            $coinAddress = BuyCoinHistory::where(['user_id' => Auth::id(), 'address' => $address, 'status' => STATUS_PENDING])->first();
        }
        if (isset($coinAddress)) {
            $data['coinAddress'] = $coinAddress;
            return view('user.buy_coin.payment_success', $data);
        } else {
            return redirect()->back()->with('dismiss', __('Address not found'));
        }
    }

    // buy coin history
    public function buyCoinHistory(Request $request)
    {
        $data['title'] = __('Buy Coin History');
        if ($request->ajax()) {
            $items = BuyCoinHistory::where(['user_id'=>Auth::id()]);
            return datatables($items)
                ->addColumn('type', function ($item) {
                    return byCoinType($item->type);
                })
                ->addColumn('status', function ($item) {
                    return deposit_status($item->status);
                })
                ->make(true);
        }

        return view('user.buy_coin.buy_history', $data);
    }

}
