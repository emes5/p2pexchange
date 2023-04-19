<?php
/**
 * Created by PhpStorm.
 * User: bacchu
 * Date: 9/12/19
 * Time: 12:56 PM
 */

namespace App\Http\Services;

use App\Model\AffiliationCode;
use App\Model\Buy;
use App\Model\Coin;
use App\Model\Order;
use App\Model\OrderDispute;
use App\Model\Sell;
use App\Model\UserVerificationCode;
use App\Model\Wallet;
use App\Repository\AffiliateRepository;
use App\Repository\ChatRepository;
use App\Repository\MarketRepository;
use App\Repository\OfferRepository;
use App\Services\Logger;
use App\Services\MailService;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TradeService
{

    public $logger;
    public $marketRepo;
    public $offerRepo;
    public $chatRepo;
    function __construct()
    {
        $this->logger = new Logger();
        $this->marketRepo = new MarketRepository();
        $this->offerRepo = new OfferRepository();
        $this->chatRepo = new ChatRepository();
    }

    /**
     * @param $request
     * @return array
     */
    public function userTradeDetails($order_id,$userId)
    {
        $response = ['success' => false, 'message' => __('Something went wrong')];
        try {
            $data['title'] = __('Order Details');
            $id = $order_id;
            $order = Order::where(['order_id' => $id])->first();
            $coin = Coin::where('type', $order->coin_type)->first();
            if (isset($order) && ($order->buyer_id == $userId)) {
                $sender_id = $order->seller_id;
                $data['type'] = 'buyer';
                $data['title'] = __('Buy ').check_default_coin_type($order->coin_type).__(' from '). $order->seller->username;
                $data['type_text'] = __('Buy ').check_default_coin_type($order->coin_type).__(' from ');

            } elseif (isset($order) && ($order->seller_id == $userId)) {
                $sender_id = $order->buyer_id;
                $data['type'] = 'seller';
                $data['title'] = __('Sell ').check_default_coin_type($order->coin_type).__(' to '). $order->buyer->username ;
                $data['type_text'] = __('Sell ').check_default_coin_type($order->coin_type).__(' to ');
                $data['check_balance'] = $this->marketRepo->check_wallet_balance_for_escrow(Auth::id(),$order, $coin);

            } else {
                return ['success' => false, 'message' => __('Order not found'),'data' => []];
            }

            $data['item'] = $this->userOrderDataDetails($order);

            if($order->is_reported == STATUS_ACTIVE) {
                $data['report'] = OrderDispute::where('order_id', $order->id)->first();
            }
            if(isset($data['report'])) {
                $data['dispute_status'] = STATUS_ACTIVE;
            } else {
                $data['dispute_status'] = STATUS_DEACTIVE;
            }
            $chartData = $this->chatData($sender_id,$order);
            $data['chat_list'] = $chartData['chat_list'];
            $data['selected_user'] = $chartData['selected_user'];

            $data['feedback_array'] = feedback_status_api();
            $data['feedback'] = $data['type'] == 'seller' ?
                get_user_feedback_rate($data['item']->buyer_id) :
                get_user_feedback_rate($data['item']->seller_id);


            $response = ['success' => true, 'message' => __('Trade details'),'data' => $data];
        } catch (\Exception $exception) {
            $this->logger->log('userTradeDetails', $exception->getMessage());
            $response = ['success' => false, 'message' => __('Something went wrong'),'data' => []];
        }
        return $response;
    }

    // user open offer
    public function userOrderDataDetails($order)
    {
        $order->payment_method_name = $order->payment_method->name;
        $order->payment_method_image = $order->payment_method->image;
        $order->status_text = $order->payment_method->image;
        $order->encrypted_id = encrypt($order->id);
        $order->count_buyer_trades = count_trades($order->buyer_id);
        $order->count_seller_trades = count_trades($order->seller_id);
        $order->payment_sleep_path = asset(path_image().$order->payment_sleep);
        $order->buyer_username = $order->buyer->username;
        $order->buyer_user_code = $order->buyer->unique_code;
        $order->seller_username = $order->seller->username;
        $order->seller_user_code = $order->seller->unique_code;
        $order->seller_registered = date('M Y', strtotime($order->seller->created_at));
        $order->buyer_registered = date('M Y', strtotime($order->buyer->created_at));

        return $order;
    }

    // chat related thing
    public function chatData($sender_id,$order)
    {
        $data['chat_list'] = $this->chatRepo->messageList($sender_id, $order->id)['chat_list'];
        $data['selected_user'] = User::find($sender_id);
        $data['selected_user']->encrypted_receiver_id = encrypt($data['selected_user']->id);
        if(!empty($data['selected_user']->photo)){
            $img = asset(IMG_USER_PATH.$data['selected_user']->photo);
        }
        if(Cache::has('is_online' . $data['selected_user']->id)) {
            $data['selected_user']->online_status = 'online';
        } else {
            $data['selected_user']->online_status = 'offline';
        }
        if($data['selected_user']->last_seen != null) {
            $data['selected_user']->last_seen = Carbon::parse($data['selected_user']->last_seen)->diffForHumans();
        } else {
            $data['selected_user']->last_seen = __('No data');
        }
        $data['selected_user']->encrypted_receiver_id = encrypt($data['selected_user']->id);
        $data['selected_user']->photo = $img ?? asset('assets/common/img/avater.png');

        return $data;
    }
}
