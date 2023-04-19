<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Services\CommonService;
use App\Http\Services\TransactionService;
use App\Model\ActivityLog;
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

class DashboardController extends Controller
{
    public function activityList(Request $request)
    {
        try {
            $limit = $request->limit ?? 5;
            $lists = ActivityLog::where(['user_id' => Auth::id()])->paginate($limit);
            foreach($lists as $list){
                $list->action=userActivity($list->action);
            }
            $data = ['success' => true, 'data' => $lists, 'message' => __('Data get successfully')];
        } catch (\Exception $e) {
            $this->logger('activityList', $e->getMessage());
            $data = ['success' => false, 'data' => [], 'message' => __('Something went wrong.')];
        }
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * get notification list
     */
    public function notificationList(Request $request)
    {
        $limit = $request->limit ?? 5;
        try {
            $notification_data = Notification::where(['user_id' => Auth::id(), 'status'=> STATUS_PENDING])->orderBy('id', 'desc');
            if($request->type == 'count'){
                $notifications['count'] = $notification_data->count();
            }else{
                $notifications = $notification_data->paginate($limit);
            }
            $data = ['success' => true, 'data' => $notifications, 'message' => __('Notification List')];
        } catch (\Exception $e) {
            $data = ['success' => false, 'data' => [], 'message' => __('Something went wrong.')];
        }
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * get faq list
     */
    public function faqList(Request $request)
    {
        $limit = $request->limit ?? 5;
        try {
            $list = Faq::where(['status' => STATUS_ACTIVE])->paginate($limit);
            $data = ['success' => true, 'data' => $list, 'message' => __('Data get successfully')];
        } catch (\Exception $e) {
            $data = ['success' => false, 'data' => [], 'message' => __('Something went wrong.')];
        }
        return response()->json($data);
    }

    /**
     * @param Request $request
     * set notification
     */
    public function setNotificationStatus(Request $request){
        try{
            $notification = Notification::where(['user_id' => Auth::id(), 'id' => $request->notification_id])->first();
            if($notification){
                Notification::where(['id' => $request->notification_id,'user_id' => Auth::id()])->update(['status'=>STATUS_ACTIVE]);
                $data = ['success' => true, 'data' => [], 'message' => __('Notification seen by user!')];
            }
            else{
                $data = ['success' => false, 'data' => [], 'message' => __('No notification found!')];
            }
        }catch (\Exception $error){
            $data = ['success' => false, 'data' => [], 'message' => $error->getMessage()];
        }
        return response()->json($data);
    }

    public function userDashboardApp(){
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
            ->where('wallets.user_id', Auth::id())
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
        $data = ['success' => true, 'data' => $data, 'message' => __('Dashboard data')];
        return response()->json($data);
    }


    public function depositeOrWithdrawList(Request $request){
        $limit = $request->limit ?? 5;
        $tr = new TransactionService();
        if ($request->type == 'deposit') {
            $histories = $tr->depositTransactionHistories(Auth::id())->paginate($limit);
            $data = ['success' => true, 'data' => $histories, 'message' => __('Deposit List')];
            return response()->json($data);
        } else {
            $histories = $tr->withdrawTransactionHistories(Auth::id())->paginate($limit);
            $data = ['success' => true, 'data' => $histories, 'message' => __('Withdraw List')];
            return response()->json($data);
        }
    }

    public function depositeAndWithdrawList(Request $request){
        $limit = $request->limit ?? 5;
        try {
            $second = DB::table('withdraw_histories')
                ->select('withdraw_histories.address','withdraw_histories.amount','withdraw_histories.transaction_hash','withdraw_histories.status',
                    'withdraw_histories.created_at')
                ->join('wallets','wallets.id','=','withdraw_histories.wallet_id')
                ->where('wallets.user_id','=',Auth::id());
            $histories = DB::table('deposite_transactions')
                ->select('deposite_transactions.address','deposite_transactions.amount','deposite_transactions.transaction_id as transaction_hash',
                    'deposite_transactions.status','deposite_transactions.created_at')
                ->join('wallets as wallet_1','wallet_1.id','=','deposite_transactions.receiver_wallet_id')
                ->where('wallet_1.user_id','=',Auth::id())
                ->union($second)
                ->paginate($limit);
            $data = ['success' => true, 'data' => $histories, 'message' => __('See all list')];
        } catch (\Exception $e) {
            $data = ['success' => false, 'data' => [], 'message' => __('Something went wrong.')];
        }
        return response()->json($data);
    }


}
