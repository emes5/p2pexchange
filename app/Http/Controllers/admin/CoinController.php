<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\Admin\GiveCoinRequest;
use App\Model\AdminGiveCoinHistory;
use App\Model\BuyCoinHistory;
use App\Model\Coin;
use App\Model\Wallet;
use App\Repository\AffiliateRepository;
use App\Services\CoinPaymentsAPI;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CoinController extends Controller
{
    // all coin list
    public function adminCoinList(Request $request)
    {
        try {
            $data['title'] = __('Coin List');
            if (isset($request->update) && $request->update == "coinPayment") {
                $coinpayment = new CoinPaymentsAPI();

                $api_rate = $coinpayment->GetRates('');
                if ( ($api_rate['error'] == "ok") ) {
                    $active_coins = [];
                    foreach($api_rate['result'] as $key => $result) {
                        if ($result['accepted'] == 1) {
                            $active_coins[$key] = [
                                'coin_type' => $key,
                                'name' => $result['name'],
                                'accepted' => $result['accepted']
                            ];
                        }
                    }
                    if (isset($active_coins)) {
                        foreach($active_coins as $key => $active) {
                            Coin::updateOrCreate(['type' => $active['coin_type']], ['name' => $active['name'], 'type' => $active['coin_type'], 'status' => STATUS_ACTIVE,'unique_code'=>uniqid().date('').time(),]);
                        }
                    } else {
                        Coin::updateOrCreate(['type' => 'BTC'], ['name' => 'Bitcoin', 'type' => 'BTC', 'status' => STATUS_ACTIVE, 'unique_code'=>uniqid().date('').time(),]);
                    }
                    $dbCoins = Coin::where('status', '<>', STATUS_DELETED)->orderBy('id','asc')->get();
                    $db_coins =[];
                    foreach ($dbCoins as $dbc) {
                        $db_coins[$dbc->type] = [
                            'coin_type' => $dbc->type,
                            'name' => $dbc->name,
                            'accepted' => $dbc->status
                        ];
                    }
                    if (isset($active_coins) && isset($db_coins)) {
                        $inactive_coins = array_diff_key($db_coins, $active_coins);
                    }
                    if (isset($inactive_coins)) {
                        foreach ($inactive_coins as $key => $value) {
                            if ($key == DEFAULT_COIN_TYPE || $key == COIN_TYPE_LTCT) {

                            } else {
                                Coin::where('type', $key)->update(['status' => STATUS_DELETED]);
                            }
                        }
                    }

                    $data['coins'] = Coin::where('status', '<>', STATUS_DELETED)->orderBy('id','asc')->get();

                    return view('admin.coin-order.coin', $data);
                } else {
                    $data['coins'] = Coin::where('status', '<>', STATUS_DELETED)->orderBy('id','asc')->get();
                    return view('admin.coin-order.coin', $data);
                }
            }

            $data['coins'] = Coin::where('status', '<>', STATUS_DELETED)->orderBy('id','asc')->get();
            return view('admin.coin-order.coin', $data);

        } catch (\Exception $e) {
            return redirect()->back()->with('dismiss', $e->getMessage());
        }
    }

    // admin coin edit
    public function adminCoinEdit($id)
    {
        $data['item'] = Coin::where('unique_code', $id)->first();
        if (isset($data['item'])) {
            $data['title'] = __('Update Coin');
            $data['button_title'] = __('Update');

            return view('admin.coin-order.edit_coin', $data);
        }

        return redirect()->back()->with('dismiss', __('Coin not found'));
    }

    // change coin status
    public function adminCoinStatus(Request $request)
    {
        $coin = Coin::find($request->active_id);
        if ($coin) {
            if ($coin->status == STATUS_ACTIVE) {
               $coin->update(['status' => STATUS_DEACTIVE]);
            } else {
                $coin->update(['status' => STATUS_ACTIVE]);
            }
            return response()->json(['message'=>__('Status changed successfully')]);
        } else {
            return response()->json(['message'=>__('Coin not found')]);
        }
    }

    public function adminCoinUpdate(Request $request)
    {
        try {
            $coin = Coin::find(decrypt($request->coin_id));
            if (empty($coin)) {
                return redirect()->back()->with('dismiss', __('Coin not found'));
            }

            $input['name'] = $request->name;
            $input['details'] = $request->details;
            $input['is_deposit'] = isset($request->is_deposit) ? 1 : 0;
            $input['is_withdrawal'] = isset($request->is_withdrawal) ? 1 : 0;
            $input['status'] = isset($request->status) ? 1 : 0;
            $input['is_sell'] = isset($request->is_sell) ? 1 : 0;
            $input['is_buy'] = isset($request->is_buy) ? 1 : 0;
            $input['withdrawal_fees'] = isset($request->withdrawal_fees) ? $request->withdrawal_fees : 0;
            $input['trade_fees'] = isset($request->trade_fees) ? $request->trade_fees : 0;
            $input['escrow_fees'] = isset($request->escrow_fees) ? $request->escrow_fees : 0;
            $input['max_withdrawal_per_day'] = isset($request->max_withdrawal_per_day) ? $request->max_withdrawal_per_day : 0;
            $input['minimum_trade_size'] = isset($request->minimum_trade_size) ? $request->minimum_trade_size : 0;
            $input['maximum_trade_size'] = isset($request->maximum_trade_size) ? $request->maximum_trade_size : 0;
            $input['minimum_withdrawal'] = isset($request->minimum_withdrawal) ? $request->minimum_withdrawal : 0;
            $input['maximum_withdrawal'] = isset($request->maximum_withdrawal) ? $request->maximum_withdrawal : 0;
            if ($request->has('coin_icon')){
                $image = uploadFile($request->coin_icon, IMG_PATH, isset($coin->image) ? $coin->image : '');
                $input['image']= $image;
            }
            $coin->update($input);

            return redirect()->back()->with('success', __('Coin details updated successfully!'));

        } catch(\Exception $e) {
            return redirect()->back()->with('dismiss', $e->getMessage());
        }
    }

    // admin pending order
    public function adminPendingCoinOrder(Request $request)
    {
        $data['title'] = __('Buy Coin Order List');
        if ($request->ajax()) {
            $deposit = BuyCoinHistory::select('*')->where(['status' => STATUS_PENDING]);

            return datatables()->of($deposit)
                ->addColumn('payment_type', function ($dpst) {
                    $html  = '';
                    if ($dpst->type == BANK_DEPOSIT) {
                        $html .= receipt_view_html(imageSrc($dpst->bank_sleep,IMG_SLEEP_VIEW_PATH));
                    } else {
                        $html .= byCoinType($dpst->type);
                    }

                    return $html;
                })
                ->addColumn('email', function ($dpst) {
                    return isset($dpst->user()->first()->email) ? $dpst->user()->first()->email : '';
                })
                ->addColumn('btc', function ($dpst) {
                    return $dpst->btc.' '.find_coin_type($dpst->coin_type);
                })
                ->addColumn('action', function ($wdrl) {
                    $action = '<ul>';
                    $action .= accept_html('adminAcceptPendingBuyCoin',encrypt($wdrl->id));
                    $action .= reject_html('adminRejectPendingBuyCoin',encrypt($wdrl->id));
                    $action .= '<ul>';
                    return $action;
                })
                ->rawColumns(['payment_type','action'])
                ->make(true);
        }

        return view('admin.coin-order.pending_list', $data);
    }

    // admin approved order
    public function adminApprovedOrder(Request $request)
    {
        if ($request->ajax()) {
            $deposit = BuyCoinHistory::select('*')->where(['status' => STATUS_ACTIVE]);

            return datatables()->of($deposit)
                ->addColumn('payment_type', function ($dpst) {
                    $html  = '';
                    if ($dpst->type == BANK_DEPOSIT) {
                        $html .= receipt_view_html(imageSrc($dpst->bank_sleep,IMG_SLEEP_VIEW_PATH));
                    } else {
                        $html .= byCoinType($dpst->type);
                    }

                    return $html;
                })
                ->addColumn('email', function ($dpst) {
                    return $dpst->user()->first()->email;
                })
                ->addColumn('btc', function ($dpst) {
                    return $dpst->btc.' '.find_coin_type($dpst->coin_type);
                })
                ->rawColumns(['payment_type'])
                ->make(true);
        }

        return view('admin.coin-order.pending_list');
    }

    // admin rejected order
    public function adminRejectedOrder(Request $request)
    {
        if ($request->ajax()) {
            $deposit = BuyCoinHistory::select('*')->where(['status' => STATUS_REJECTED]);

            return datatables()->of($deposit)
                ->addColumn('payment_type', function ($dpst) {
                    $html  = '';
                    if ($dpst->type == BANK_DEPOSIT) {
                        $html .= receipt_view_html(imageSrc($dpst->bank_sleep,IMG_SLEEP_VIEW_PATH));
                    } else {
                        $html .= byCoinType($dpst->type);
                    }

                    return $html;
                })
                ->addColumn('email', function ($dpst) {
                    return $dpst->user()->first()->email;
                })
                ->addColumn('btc', function ($dpst) {
                    return $dpst->btc.' '.find_coin_type($dpst->coin_type);
                })
                ->editColumn('created_at', function ($dpst) {
                    return $dpst->created_at;
                })

                ->rawColumns(['payment_type'])
                ->make(true);
        }

        return view('admin.coin-order.pending_list');
    }

    // pending coin accept process
    public function adminAcceptPendingBuyCoin($id)
    {
        if (isset($id)) {
            try {
                $wdrl_id = decrypt($id);
            } catch (\Exception $e) {
                return redirect()->back();
            }
            DB::beginTransaction();
            try {
                $affiliate_servcice = new AffiliateRepository();
                $transaction = BuyCoinHistory::where(['id' => $wdrl_id, 'status' => STATUS_PENDING])->firstOrFail();

                $primary = get_primary_wallet($transaction->user_id, DEFAULT_COIN_TYPE);
                $coinAmount = bcadd($transaction->coin,$transaction->bonus,8);
                $primary->increment('balance', $coinAmount);
                $transaction->status = STATUS_SUCCESS;
                $transaction->save();

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('dismiss', 'Something went wrong');
            }

            DB::commit();
            return redirect()->back()->with('success', 'Request accepted successfully');
        }
    }

    // pending coin reject process
    public function adminRejectPendingBuyCoin($id)
    {
        if (isset($id)) {
            try {
                $wdrl_id = decrypt($id);
            } catch (\Exception $e) {
                return redirect()->back();
            }
            $transaction = BuyCoinHistory::where(['id' => $wdrl_id, 'status' => STATUS_PENDING])->firstOrFail();
            $transaction->status = STATUS_REJECTED;
            $transaction->update();

            return redirect()->back()->with('success', 'Request cancelled successfully');
        }
    }
}
