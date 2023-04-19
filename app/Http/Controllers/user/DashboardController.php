<?php

namespace App\Http\Controllers\user;

use App\Http\Services\CommonService;
use App\Model\BuyCoinHistory;
use App\Model\DepositeTransaction;
use App\Model\Faq;
use App\Model\Notification;
use App\Model\Order;
use App\Model\WithdrawHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function userDashboard(Request $request)
    {
        $data['title'] = __('Dashboard');
        $data['balance'] = getUserBalance(Auth::id());
        $from = Carbon::now()->subMonth(6)->format('Y-m-d h:i:s');
        $to = Carbon::now()->format('Y-m-d h:i:s');
        $data['trade_success_status']  = 0;
        $trade_total = user_trades_count(Auth::id(),'total');
        if ($trade_total > 0) {
            $data['trade_success_status'] = number_format((count_trades(Auth::id()) * 100) / $trade_total,2);
        }
        $common_service = new CommonService();
        $sixmonth_buy= $common_service->authUserTrade($from,$to,BUY);
        $sixmonth_sell = $common_service->authUserTrade($from,$to,SELL);

        ///////////////////////////////////////////   six month data /////////////////////////////
        $data['sixmonth_buy'] = [];
        $data['sixmonth_sell'] = [];
        $months = previousMonthName(5);
        $data['last_six_month'] =  $months;
//        dd($sixmonth_buy,$sixmonth_sell,$months);
////        dd($months);
        foreach ($months as $key => $month){
//            dd($sixmonth_buy[$month]);
            $data['sixmonth_buy'][$key]['country'] = $month;
            $data['sixmonth_buy'][$key]['buy'] = (isset($sixmonth_buy[$month])) ? $sixmonth_buy[$month] : 0;
            $data['sixmonth_sell'][$key]['sell'] = (isset($sixmonth_sell[$month])) ? $sixmonth_sell[$month] : 0;
        }
        $data['six_buys'] = [];
        foreach ($data['sixmonth_buy'] as $buy) {
            array_push($data['six_buys'],$buy['buy']);
        }
        $data['six_sells'] = [];
        foreach ($data['sixmonth_sell'] as $buy) {
            array_push($data['six_sells'],$buy['sell']);
        }

        $data['completed_withdraw']  = WithdrawHistory::join('wallets','wallets.id','withdraw_histories.wallet_id')
            ->where('withdraw_histories.status',STATUS_SUCCESS)
            ->where('wallets.user_id',Auth::id())->sum('withdraw_histories.amount');
        $data['pending_withdraw']  = WithdrawHistory::join('wallets','wallets.id','withdraw_histories.wallet_id')
            ->where('withdraw_histories.status',STATUS_PENDING)
            ->where('wallets.user_id',Auth::id())->sum('withdraw_histories.amount');
        if(($data['completed_withdraw'] + $data['pending_withdraw']) > 0) {
            $data['success_withdrawal_status'] = ($data['completed_withdraw'] * 100)/ ($data['completed_withdraw'] + $data['pending_withdraw']);
        } else {
            $data['success_withdrawal_status'] = 5;
        }



        $data['histories'] = DepositeTransaction::get();
        $data['withdraws'] = WithdrawHistory::get();
        $allMonths = all_months();
        // deposit
        $monthlyDeposits = DepositeTransaction::join('wallets', 'wallets.id', 'deposite_transactions.receiver_wallet_id')
            ->where('wallets.user_id', Auth::id())
            ->select(DB::raw('sum(deposite_transactions.amount) as totalDepo'), DB::raw('MONTH(deposite_transactions.created_at) as months'))
            ->whereYear('deposite_transactions.created_at', Carbon::now()->year)
            ->where('deposite_transactions.status', STATUS_SUCCESS)
            ->groupBy('months')
            ->get();

        if (isset($monthlyDeposits[0])) {
            foreach ($monthlyDeposits as $depsit) {
                $data['deposit'][$depsit->months] = $depsit->totalDepo;
            }
        }
        $allDeposits = [];
        foreach ($allMonths as $month) {
            $allDeposits[] =  isset($data['deposit'][$month]) ? $data['deposit'][$month] : 0;
        }
        $data['monthly_deposit'] = $allDeposits;

        // withdrawal
        $monthlyWithdrawals = WithdrawHistory::join('wallets', 'wallets.id', 'withdraw_histories.wallet_id')
            ->select(DB::raw('sum(withdraw_histories.amount) as totalWithdraw'), DB::raw('MONTH(withdraw_histories.created_at) as months'))
            ->whereYear('withdraw_histories.created_at', Carbon::now()->year)
            ->where('withdraw_histories.status', STATUS_SUCCESS)
            ->groupBy('months')
            ->get();

        if (isset($monthlyWithdrawals[0])) {
            foreach ($monthlyWithdrawals as $withdraw) {
                $data['withdrawal'][$withdraw->months] = $withdraw->totalWithdraw;
            }
        }
        $allWithdrawal = [];
        foreach ($allMonths as $month) {
            $allWithdrawal[] =  isset($data['withdrawal'][$month]) ? $data['withdrawal'][$month] : 0;
        }
        $data['monthly_withdrawal'] = $allWithdrawal;

        // trade
        $monthlyTrades = Order::select(DB::raw('sum(amount) as totalTrade'), DB::raw('MONTH(created_at) as months'))
            ->whereYear('created_at', Carbon::now()->year)
            ->where(['status' => TRADE_STATUS_TRANSFER_DONE, 'is_reported' => STATUS_DEACTIVE])
            ->where(function($query) {
                $query->where('buyer_id', Auth::id())
                    ->orWhere('seller_id', Auth::id());
            })
            ->groupBy('months')
            ->get();

        if (isset($monthlyTrades[0])) {
            foreach ($monthlyTrades as $trade) {
                $data['trade'][$trade->months] = $trade->totalTrade;
            }
        }
        $allTrades = [];
        foreach ($allMonths as $month) {
            $allTrades[] =  isset($data['trade'][$month]) ? $data['trade'][$month] : 0;
        }
        $data['monthly_trade'] = $allTrades;
//        dd($data);

        return view('user.dashboard', $data);
    }

    // user faq list
    public function userFaq()
    {
        $data['title'] = __('FAQ');
        $data['items'] = Faq::where('status',STATUS_ACTIVE)->get();

        return view('user.faq.index', $data);
    }

    // show notification
    public function showNotification(Request $request)
    {
        $notification = Notification::where('id', $request->id)->first();
        $data['title'] = $notification->title;
        $data['notice'] = $notification->notification_body;
        $data['date'] = date('d M y', strtotime($notification->created_at));

        $read = $notification->update(['status' => 1]);
        $notifications = Notification::where(['user_id' => $notification->user_id, 'status'=> STATUS_PENDING])->orderBy('id', 'desc')->get();
        $data['html'] = '';
        $data['notifications'] = $notifications;
        $html = '';
        $html .= View::make('user.notification_item',$data);
        $data['html'] = $html;

        return response()->json(['data' => $data]);
    }


    // get notification
    public function getNotification(Request $request)
    {
        $notifications = Notification::where(['user_id' => $request->user_id, 'status'=> STATUS_PENDING])->orderBy('id', 'desc')->get();
        $html = '';
        $data['notifications'] = $notifications;
        $html .= View::make('user.notification_item',$data);

        return response()->json(['data' => $html]);
    }
}
