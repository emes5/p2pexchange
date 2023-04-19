<?php

namespace App\Http\Controllers\Api\MarketPlace;

use App\Http\Requests\Api\CancelAndReportuserRequest;
use App\Http\Requests\Api\UploadslipRequest;
use App\Http\Requests\PlaceOrderRequest;
use App\Http\Services\CommonService;
use App\Model\Buy;
use App\Model\Coin;
use App\Model\CountryPaymentMethod;
use App\Model\Order;
use App\Model\OrderDispute;
use App\Model\PaymentMethod;
use App\Model\Sell;
use App\Repository\ChatRepository;
use App\Repository\MarketRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;
use Stevebauman\Location\Facades\Location;

class MarketPlaceController extends Controller
{
    public function searchOptions(Request $request)
    {
        try{
            if(isset($request->country) && !empty($request->country)) {
                $data['country'] = $request->country;
            } else {
                $data['country'] = 'any';
                $myIp = Location::get(request()->ip());
                if ($myIp == false) {
                    if (Auth::user()) {
                        if(!empty(Auth::user()->country)) {
                            $data['country'] = strtoupper(Auth::user()->country);
                        } else {
                            $data = ['success' => false, 'data' => [], 'message' => __('Please add your country before trade!')];
                            return response()->json($data);
                        }
                    } else {
                        $data['country'] = 'any';
                    }
                } else {
                    $data['country'] = $myIp->countryCode;
                }
            }
            if(isset($request->coin_type) && !empty($request->coin_type)) {
                $data['coins_type'] = $request->coin_type;
            } else {
                $data['coins_type'] = 'BTC';
            }
            if(isset($request->payment_method) && !empty($request->payment_method)) {
                $data['pmethod'] = $request->payment_method;
            } else {
                $data['pmethod'] = 'any';
            }
            if(isset($request->offer_type) && !empty($request->offer_type)) {
                $data['offer_type'] = $request->offer_type;
            } else {
                $data['offer_type'] = BUY_SELL;
            }
            $data['offer_types'][BUY] = 'BUY';
            $data['offer_types'][SELL] = 'SELL';
            $data['offer_types'][BUY_SELL] = 'BUY/SELL';
            $data['countries'] = countrylist();
            $data['coins'] = Coin::where('status', STATUS_ACTIVE)->orderBy('id', 'ASC')->get();
            if($data['country']=='any'){
                $data['payment_methods'] = PaymentMethod::where('status', STATUS_ACTIVE)->orderBy('id','Desc')->get();
            }else{
                $data['payment_methods'] = CountryPaymentMethod::join('payment_methods', 'payment_methods.id','=', 'country_payment_methods.payment_method_id')
                    ->where('country_payment_methods.country', $data['country'])
                    ->select('*')
                    ->get();
            }
            $response = ['success' => true, 'data' => $data, 'message' => __('Buy or sell offer options')];
        }
        catch (\Exception $e) {
            $response = ['success' => false, 'data' => [], 'message' => __($e->getMessage())];
        }
        return response()->json($response);
    }

    public function searchOffers(Request $request)
    {
        try{
            $limit = $request->limit ?? 5;
            if(isset($request->country) && !empty($request->country)) {
                $data['country'] = $request->country;
            } else {
                $data['country'] = 'any';
                $myIp = Location::get(request()->ip());
                if ($myIp == false) {
                    if (Auth::user()) {
                        if(!empty(Auth::user()->country)) {
                            $data['country'] = strtoupper(Auth::user()->country);
                        } else {
                            $data = ['success' => false, 'data' => [], 'message' => __('Please add your country before trade!')];
                            return response()->json($data);
                        }
                    } else {
                        $data['country'] = 'any';
                    }
                } else {
                    $data['country'] = $myIp->countryCode;
                }
            }
            if(isset($request->coin_type) && !empty($request->coin_type)) {
                $data['coins_type'] = $request->coin_type;
            } else {
                $data['coins_type'] = 'BTC';
            }
            if(isset($request->payment_method) && !empty($request->payment_method)) {
                $data['pmethod'] = $request->payment_method;
            } else {
                $data['pmethod'] = 'any';
            }
            if(isset($request->offer_type) && !empty($request->offer_type)) {
                $data['offer_type'] = $request->offer_type;
            } else {
                $data['offer_type'] = BUY_SELL;
            }
            $data['rate_type'][RATE_TYPE_DYNAMIC] = __('Dynamic market price');
            $data['rate_type'][RATE_TYPE_STATIC] = __('Static Rate');
            $data['price_type'][RATE_ABOVE] = __('Above');
            $data['price_type'][RATE_BELOW] = __('Below');
            $data['default_payment_method_image'] = asset('assets/img/payment.svg');
            $data['payment_method_image_url'] = asset(path_image()).'/';
            $data['buys']=(object)[];
            $data['sells']=(object)[];
            $base_tables = [];
            $tables[BUY] = 'sells';
            $tables[SELL] = 'buys';
            $payment_offer[BUY] = SELL;
            $payment_offer[SELL] = BUY;
            if($data['offer_type']==BUY_SELL){
                $base_tables = $tables;
            }else{
                $base_tables[$data['offer_type']] = $tables[$data['offer_type']];
            }
            foreach($base_tables as $key=>$table){
                $query = DB::table($table)->select($table.'.*','users.first_name','users.last_name',
                    DB::raw('group_concat(DISTINCT(payment_methods.name)) as method_names'),
                    DB::raw('group_concat(DISTINCT(payment_methods.image)) as image_names'),
                    DB::raw('count(DISTINCT(orders.id)) as count_trades'));
                $query->join('offer_payment_methods', function ($join) use ($table,$key,$data,$payment_offer) {
                    $join->on('offer_payment_methods.offer_id',$table.'.id');
                    $join->on('offer_payment_methods.offer_type','=',DB::raw($payment_offer[$key]));
                    if($data['pmethod']!='any'){
                        $join->on('offer_payment_methods.payment_method_id', DB::raw($data['pmethod']));
                    }
                });
                $query->join('users', 'users.id', '=', $table.'.user_id');
                $query->join('payment_methods', 'payment_methods.id', '=', 'offer_payment_methods.payment_method_id');
                $query->leftJoin('orders', function($join) use ($table)
                {
                    $join->on('orders.buyer_id', '=' ,$table.'.user_id')
                        ->on('orders.status', '=' ,DB::raw(TRADE_STATUS_TRANSFER_DONE))
                        ->oron('orders.seller_id', '=' ,$table.'.user_id')
                        ->on('orders.status', '=' ,DB::raw(TRADE_STATUS_TRANSFER_DONE));
                });
                if($data['country'] !='any'){
                    $query->where($table.'.country', '=', $data['country']);
                }
                $query->where($table.'.status', '=', STATUS_ACTIVE)
                    ->where($table.'.coin_type', '=', $data['coins_type'])
                    ->orderBy($table.'.id', 'DESC')
                    ->groupBy([$table.'.id']);
                $data[$table] = $query->paginate($limit);
            }
            $response = ['success' => true, 'data' => $data, 'message' => __('Buy or sell offer list')];
        }
        catch (\Exception $e) {
            $response = ['success' => false, 'data' => [], 'message' => __($e->getMessage())];
        }
        return response()->json($response);
    }

    public function openTradeApp(Request $request)
    {
        $img = asset('assets/common/img/avater.png');
        $type = $request->offer_type;
        $offer_id = $request->offer_id;
        $myIp = Location::get(request()->ip());
        if ($myIp == false) {
            if(!empty(Auth::user()->country)) {
                $data['country'] = strtoupper(Auth::user()->country);
            } else {
                $response = ['success' => false, 'data' => [], 'message' => __('Please add your country before trade')];
                return response()->json($response);
            }
        } else {
            $data['country'] = $myIp->countryCode;
        }
        if($type == 'buy') {
            $offer = Sell::find($offer_id);
            if (isset($offer)) {
                $temp=[];
                foreach ($offer->payment($offer->id) as $payment_method){
                    if(is_accept_payment_method($payment_method['payment_method_id'],$data['country'])){
                        $temp['id'] = $payment_method['payment_method_id'];
                        $temp['name'] = $payment_method->payment_method->name;
                        $temp['image'] = $payment_method->payment_method->image;
                        $data['payment_methods'] [] = $temp;
                    }
                }
                if (!empty($offer->user->photo)) {
                    $img = asset(IMG_USER_PATH.$offer->user->photo);
                }
                $offer->user->photo = $img;
                $offer->coin_type = check_default_coin_type($offer->coin_type);
                $data['title'] = __('Buy ').$offer->coin_type.__(' from '). $offer->user->first_name.' '.$offer->user->last_name ;
                $data['offer'] = $offer;
                $data['type'] = $type;
                $data['count_trades'] = count_trades($offer->user_id);
                $data['type_text'] = __('Buy ').$offer->coin_type.__(' from ');
                $response = ['success' => true, 'data' => $data, 'message' => __('Open Buy Offer')];
            } else {
                $response = ['success' => false, 'data' => [], 'message' => __('Offer not found')];
                return response()->json($response);
            }
        } elseif($type == 'sell') {
            $offer = Buy::find($offer_id);
            if (isset($offer)) {
                $temp=[];
                foreach ($offer->payment($offer->id) as $payment_method){
                    if(is_accept_payment_method($payment_method['payment_method_id'],$data['country'])){
                        $temp['id'] = $payment_method['payment_method_id'];
                        $temp['name'] = $payment_method->payment_method->name;
                        $temp['image'] = $payment_method->payment_method->image;
                        $data['payment_methods'] [] = $temp;
                    }
                }
                if (!empty($offer->user->photo)) {
                    $img = asset(IMG_USER_PATH.$offer->user->photo);
                }
                $offer->user->photo = $img;
                $offer->coin_type = check_default_coin_type($offer->coin_type);
                $data['title'] = __('Sell ').$offer->coin_type.__(' to '). $offer->user->first_name.' '.$offer->user->last_name ;
                $data['offer'] = $offer;
                $data['type'] = $type;
                $data['count_trades'] = count_trades($offer->user_id);
                $data['type_text'] = __('Sell ').$offer->coin_type.__(' to ');
                $response = ['success' => true, 'data' => $data, 'message' => __('Open Sell Offer')];
            } else {
                $response = ['success' => false, 'data' => [], 'message' => __('Offer not found')];
                return response()->json($response);
            }
        } else {
            $response = ['success' => false, 'data' => [], 'message' => __('Offer not found')];
            return response()->json($response);
        }
        return response()->json($response);
    }

    public function getTradeCoinRateApp(Request $request)
    {
        if ($request->order_type == 'sell') {
            $offer = Buy::where('id', $request->offer_id)->first();
        } else {
            $offer = Sell::where('id', $request->offer_id)->first();
        }
        $data['offer'] = $offer;
        $data['offer_type'] = $request->order_type;
        Log::info(json_encode($offer));
        if ($request->type == 'reverse') {
            $data['type'] = $request->type;
            $amount = get_offer_rate($request->amount,$offer->currency,$offer->coin_type,$offer,'reverse');
            $data['amount'] = $amount;
            $data['price'] = $request->amount;

        } else {
            $data['type'] = $request->type;
            $amount = get_offer_rate($request->amount,$offer->currency,$offer->coin_type,$offer,'same');
            $data['price'] = $amount;
            $data['amount'] = $request->amount;
        }
        $response = ['success' => true, 'data' => $data, 'message' => __('Get coin rate!')];
        return response()->json($response);

    }

    public function saveOrder(PlaceOrderRequest $request)
    {
        $marketRepo = new MarketRepository;
        $response = $marketRepo->saveOrder($request);
        return response()->json($response);
    }

    // my trade  list
    public function tradeList(Request $request)
    {
        $limit = $request->limit ?? 5;
        $status_array[TRADE_STATUS_INTERESTED] = __('Waiting for escrow');
        $status_array[TRADE_STATUS_ESCROW] = __('Waiting for payment');
        $status_array[TRADE_STATUS_PAYMENT_DONE] = __('Waiting for releasing escrow');
        $status_array[TRADE_STATUS_TRANSFER_DONE] = __('Transaction Successful');
        $status_array[TRADE_STATUS_CANCEL] = __('Cancelled');
        $status_array[TRADE_STATUS_REPORT] = __('Order reported');
        $status_array[TRADE_STATUS_CANCELLED_ADMIN] = __('Cancelled By Admin');
        $data = Order::where(['buyer_id' => Auth::id()])->orWhere(['seller_id' => Auth::id()])->orderBy('id', 'DESC')->paginate($limit);
        foreach($data as $resp){
            $resp->amount .= ' '.check_default_coin_type($resp->coin_type);
            $resp->fees .= ' '.check_default_coin_type($resp->coin_type);
            $resp->seller_name .= $resp->seller->first_name.' '.$resp->seller->last_name;
            $resp->buyer_name .= $resp->buyer->first_name.' '.$resp->seller->last_name;
            $resp->status_in_text = $status_array[$resp->status];
            unset($resp->buyer);
            unset($resp->seller);
        }

        $response = ['success' => true, 'data' => $data, 'message' => __('Trade list')];
        return response()->json($response);
    }

    public function tradeDetailsApp($order_id){
        $id = $order_id;
        $marketRepo = new MarketRepository;
        $order = Order::where(['order_id' => $id])->first();
        $coin = Coin::where('type', $order->coin_type)->first();
        if (isset($order) && ($order->buyer_id == Auth::id())) {
            $sender_id = $order->seller_id;
            $data['type'] = 'buyer';
            $data['title'] = __('Buy ').check_default_coin_type($order->coin_type).__(' from '). $order->seller->first_name.' '.$order->seller->last_name ;
            $data['type_text'] = __('Buy ').check_default_coin_type($order->coin_type).__(' from ');

        } elseif (isset($order) && ($order->seller_id == Auth::id())) {
            $sender_id = $order->buyer_id;
            $data['type'] = 'seller';
            $data['title'] = __('Sell ').check_default_coin_type($order->coin_type).__(' to '). $order->buyer->first_name.' '.$order->buyer->last_name ;
            $data['type_text'] = __('Sell ').check_default_coin_type($order->coin_type).__(' to ');
            $data['check_balance'] = $marketRepo->check_wallet_balance_for_escrow(Auth::id(),$order, $coin);
        } else {
            $response = ['success' => false, 'data' => [], 'message' => __('Order not found')];
            return response()->json($response);
        }
        $data['item'] = $order;
        $data['item']->coin_type = check_default_coin_type($order->coin_type);
        $data['item']->payment_method_image = $order->payment_method->image;
        $data['item']->encrypted_id = encrypt($order->id);
        $data['item']->count_buyer_trades = count_trades($order->buyer_id);
        $data['item']->count_seller_trades = count_trades($order->seller_id);
        $data['item']->payment_sleep_path = asset(path_image().$order->payment_sleep);
        if(!empty($order->buy_id)){
            $data['item']->headline = $order->buy_data->headline;
            $data['item']->terms = $order->buy_data->terms;
            $data['item']->instruction = $order->buy_data->instruction;
        }else{
            $data['item']->headline = $order->sell_data->headline;
            $data['item']->terms = $order->sell_data->terms;
            $data['item']->instruction = $order->sell_data->instruction;
        }
        if($order->is_reported == STATUS_ACTIVE) {
            $data['report'] = OrderDispute::where('order_id', $order->id)->first();
        }
        $temp_chat=[];
        $chats = app(ChatRepository::class)->messageList($sender_id, $order->id)['chat_list'];
        foreach ($chats as $key=>$item){
            $temp_chat[$key]['id'] = $item->id;
            $temp_chat[$key]['sender_id'] = $item->sender_id;
            $temp_chat[$key]['receiver_id'] = $item->receiver_id;
            $temp_chat[$key]['order_id'] = $item->order_id;
            $temp_chat[$key]['message'] = $item->message;
            $temp_chat[$key]['file'] = $item->file;
            $temp_chat[$key]['status'] = $item->status;
            $temp_chat[$key]['seen'] = $item->seen;
            $temp_chat[$key]['created_at'] = $item->created_at;
            $temp_chat[$key]['updated_at'] = $item->created_at;
            $temp_chat[$key]['receiver_image_path'] = show_image($item->receiver_id,'user');
            $temp_chat[$key]['sender_image_path'] = show_image($item->sender_id,'user');
        }
        $data['chat_list'] = array_reverse($temp_chat);
        $data['selected_user'] = User::find($sender_id);
        $data['selected_user']->encrypted_receiver_id = encrypt($data['selected_user']->id);
        if(!empty($data['selected_user']->photo)){
            $img = asset(IMG_USER_PATH.$data['selected_user']->photo);
        }
        $data['selected_user']->photo = $img ?? asset('assets/common/img/avater.png');
        $data['all_trade_status'][TRADE_STATUS_INTERESTED] = __('Waiting for escrow');
        $data['all_trade_status'][TRADE_STATUS_ESCROW] = __('Waiting for payment');
        $data['all_trade_status'][TRADE_STATUS_PAYMENT_DONE] = __('Waiting for releasing escrow');
        $data['all_trade_status'][TRADE_STATUS_TRANSFER_DONE] = __('Transaction Successful');
        $data['all_trade_status'][TRADE_STATUS_CANCEL] = __('Cancelled');
        $data['all_trade_status'][TRADE_STATUS_REPORT] = __('Order reported');
        $data['all_trade_status'][TRADE_STATUS_CANCELLED_ADMIN] = __('Cancelled By Admin');
        $response = ['success' => true, 'data' => $data, 'message' => __('Trade Details')];
        return response()->json($response);
    }

    public function sendOrderMessageApp(Request $request) {
        $response = app(ChatRepository::class)->sendOrderMessage($request);
        $response['data']['sender_user']->image = show_image($response['data']['sender_id'],'user');
        $response['data']['my_image'] =show_image(Auth::id(),'user');
        try {
            $channel = 'userordermessage_'.$response['data']->receiver_id.'_'.$request->order_id;
            $config = config('broadcasting.connections.pusher');
            $pusher = new Pusher($config['key'], $config['secret'], $config['app_id'], $config['options']);
            $test =  $pusher->trigger($channel , 'receive_message', $response);
        } catch (\Exception $exception) {}
        return response()->json($response);
    }

    public function tradeCancelApp(CancelAndReportuserRequest $request){
        $marketRepo = new MarketRepository;
        $response = $marketRepo->cancelTrade($request);
        $response['data'] = [];
        return response()->json($response);
    }

    public function reportUserOrderApp(CancelAndReportuserRequest $request){
        $marketRepo = new MarketRepository;
        $response = $marketRepo->reportToUserOrder($request);
        $response['data'] = [];
        return response()->json($response);
    }

    public function fundEscrowApp($order_id){
        $id = app(CommonService::class)->checkValidId($order_id);
        $marketRepo = new MarketRepository;
        if (is_array($id)) {
            $response = ['success' => false, 'data' => [], 'message' => __('Data not found!')];
            return response()->json($response);
        }
        $response = $marketRepo->escrowFundProcess($id);
        $response['data'] = [];
        return response()->json($response);
    }

    public function releasedEscrowApp($order_id){
        $marketRepo = new MarketRepository;
        $response = $marketRepo->escrowReleasedProcess($order_id);
        $response['data'] = [];
        return response()->json($response);
    }

    public function uploadPaymentSleepApp(UploadslipRequest $request){
        $id = app(CommonService::class)->checkValidId($request->order_id);
        if (is_array($id)) {
            $response = ['success' => false, 'data' => [], 'message' => __('Data not found!')];
            return response()->json($response);
        }
        $marketRepo = new MarketRepository;
        $response = $marketRepo->uploadPaymentSleepProcess($request);
        $response['data'] = [];
        return response()->json($response);
    }

    public function tradeProfile($user_id){
        $img = asset('assets/common/img/avater.png');
        $data['user'] = User::find($user_id);
        if (!empty($data['user']->photo)) {
            $img = asset(IMG_USER_PATH.$data['user']->photo);
        }
        $data['user']->photo = $img;
        $data['total_trades'] = user_trades_count($user_id,'total');
        $data['successful_trades'] = user_trades_count($user_id, TRADE_STATUS_TRANSFER_DONE);
        $data['ongoing_trades'] = $data['total_trades']-($data['successful_trades']+user_trades_count($user_id, TRADE_STATUS_CANCEL));
        $data['cancelled_trades'] = user_trades_count($user_id, TRADE_STATUS_CANCEL);
        $data['disputed_trades'] = user_disputed_trades($user_id);
        $response = ['success' => true, 'data' => $data, 'message' => __('User trade profile data!')];
        return response()->json($response);
    }

}
