<?php
namespace App\Repository;
use App\Http\Services\CommonService;
use App\Model\Admin\Bank;
use App\Model\Buy;
use App\Model\Chat;
use App\Model\Coin;
use App\Model\Escrow;
use App\Model\MembershipBonusDistributionHistory;
use App\Model\MembershipClub;
use App\Model\MembershipPlan;
use App\Model\MembershipTransactionHistory;
use App\Model\OfferPaymentMethod;
use App\Model\Order;
use App\Model\OrderCancelReason;
use App\Model\OrderDispute;
use App\Model\Sell;
use App\Model\Wallet;
use App\Services\CoinPaymentsAPI;
use App\Services\Logger;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use phpDocumentor\Reflection\Types\Null_;
use Pusher\Pusher;

class MarketRepository
{
    private $commonService;
    private $logger;
    public function __construct()
    {
        $this->commonService = new CommonService();
        $this->logger = new Logger();
    }

    // save order details buy and sell
    public function saveOrder($request)
    {
        $response = [
            'success' => false,
            'message' => __('Something went wrong')
        ];
        Log::info('place order data :');
        Log::info(json_encode($request->all()));

        if($request->type == 'buy') {
            $type = BUY;
            $offer = Sell::find($request->offer_id);
            if (isset($offer)) {
                $buyer_id = Auth::id();
                $seller_id = $offer->user_id;
                $buyer_wallet_id = get_primary_wallet(Auth::id(), $offer->coin_type)->id;
                $seller_wallet_id = get_primary_wallet($offer->user_id, $offer->coin_type)->id;
                $sell_id = $offer->id;
                $buy_id = null;

            } else {
                $response = [
                    'success' => false,
                    'message' => __('Offer not found')
                ];

                return $response;
            }

        } elseif ($request->type == 'sell') {
            $type = SELL;
            $offer = Buy::find($request->offer_id);
            if (isset($offer)) {
                $buyer_id = $offer->user_id;
                $seller_id = Auth::id();
                $seller_wallet_id = get_primary_wallet(Auth::id(), $offer->coin_type)->id;
                $buyer_wallet_id = get_primary_wallet($offer->user_id, $offer->coin_type)->id;
                $sell_id = null;
                $buy_id = $offer->id;
            } else {
                $response = [
                    'success' => false,
                    'message' => __('Offer not found')
                ];

                return $response;
            }
        } else {
            $response = [
                'success' => false,
                'message' => __('Offer not found')
            ];

            return $response;
        }
        Log::info('offer rate type = '.$offer->rate_type );
        if ($offer->rate_type == RATE_TYPE_STATIC) {
            $rate = $offer->coin_rate;
        } else {
//            $rate = convert_currency(1,$offer->currency,$offer->coin_type);
            $rate = $offer->coin_rate;
        }
        Log::info("calculated rate = ". $rate);
        $amount = get_offer_rate($request->price,$offer->currency,$offer->coin_type,$offer,'reverse');
        Log::info('Calculated amount = '. $amount);

        $coin = Coin::find($offer->coin_id);
        if (empty($coin)) {
            $response = [
                'success' => false,
                'message' => __('Coin not found')
            ];

            return $response;
        }
        $validation  = $this->order_validation($offer, $request, $amount, $coin);
        if ($validation['success'] == false) {
            $response = [
                'success' => $validation['success'],
                'message' => $validation['message']
            ];

            return $response;
        }

        if ($request->type == 'sell') {
            $balance_check = $this->check_seller_wallet_balance(Auth::id(),$seller_wallet_id,$amount, $coin);
            if ($balance_check ['success'] == false) {
                $response = [
                    'success' => $balance_check['success'],
                    'message' => $balance_check['message']
                ];

                return $response;
            }
        }

        DB::beginTransaction();
        try {
            $data = [
                'unique_code'=>uniqid().date('').time(),
                'buyer_id' => $buyer_id,
                'seller_id' => $seller_id,
                'buyer_wallet_id' => $buyer_wallet_id,
                'seller_wallet_id' => $seller_wallet_id,
                'buy_id' => $buy_id,
                'sell_id' => $sell_id,
                'coin_type' => $offer->coin_type,
                'currency' => $offer->currency,
                'rate' => $rate,
                'amount' => $amount,
                'price' => $request->price,
                'fees' => trade_fees($amount, $coin),
                'type' => $type,
                'payment_id' => $request->payment_id,
                'order_id' => $buyer_id.$seller_id.uniqid().time(),
                'fees_percentage' => $coin->trade_fees,
            ];

            $order = Order::create($data);
            if ($order) {
                $this->save_message(Auth::id(), $offer->user_id,$request->text_message, $order->id);

                $notification_heading = Auth::user()->first_name." ".Auth::user()->last_name.__(' wants to trade with you');
                $notification_msg = Auth::user()->first_name." ".Auth::user()->last_name.__(' wants to trade with you . The order id is '.$order->order_id);
                $this->commonService->sendNotificationToUser($offer->user_id,$notification_heading,$notification_msg);

                $response = [
                    'success' => true,
                    'message' => __('Order request submitted successfully'),
                    'order' => $order
                ];
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }


    // check order validation
    public function order_validation($offer, $request, $amount, $coin)
    {
        if ($offer->user_id == Auth::id()) {
            $response = [
                'success' => false,
                'message' => __('You can not trade with own account')
            ];
            return $response;
        }
        if ($request->price < $offer->minimum_trade_size) {
            $response = [
                'success' => false,
                'message' => __('The trade amount is below the lister minimum.')
            ];
            return $response;
        }
        if ($request->price > $offer->maximum_trade_size) {
            $response = [
                'success' => false,
                'message' => __('The trade amount is above the lister maximum.')
            ];
            return $response;
        }
        if ($request->type == 'sell') {
            $trade_fees = trade_fees($amount, $coin);
            $wallet = get_primary_wallet(Auth::id(), $offer->coin_type);
            Log::info('Trade fees = '.$trade_fees);
            if ($wallet->balance < ($amount + $trade_fees)) {
                $response = [
                    'success' => false,
                    'message' => __('Please deposit enough ').$wallet->coin_type .__(' into your wallet first.')
                ];
                return $response;
            }
        }

        $response = [
            'success' => true,
        ];
        return $response;
    }

    // save message when create order
    public function save_message($sender_id, $receiver_id,$message, $order_id)
    {
        $chat = Chat::create([
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message' => $message,
            'order_id' => $order_id,
        ]);
    }
    // create offer payment method
    public function create_offer_payment_method($payment_methods,$offer_id,$offer_type)
    {
        $offers = OfferPaymentMethod::where('offer_id', $offer_id)->get();
        if (isset($offers[0])) {
            OfferPaymentMethod::where('offer_id', $offer_id)->delete();
        }

        foreach ($payment_methods as $key => $method) {
            OfferPaymentMethod::create([
                'offer_id' => $offer_id,
                'payment_method_id' => $method,
                'offer_type' => $offer_type,
            ]);
        }

    }

    // escrow fund process
    public function escrowFundProcess($order_id)
    {
        $response = [
            'success' => false,
            'message' => __('Something went wrong')
        ];
        $order = Order::where(['id'=> $order_id, 'seller_id' => Auth::id(), 'status' => TRADE_STATUS_INTERESTED])->first();

        $coin =  Coin::where('type', $order->coin_type)->first();
        if (isset($order)) {
            $check_balance = $this->check_wallet_balance_for_escrow(Auth::id(),$order, $coin);
            if ($check_balance['success'] == false) {
                $response = [
                    'success' => false,
                    'message' => $check_balance['message']
                ];

                return $response;
            }

            $wallet = $check_balance['wallet'];

        } else {
            $response = [
                'success' => false,
                'message' => __('Order not found')
            ];

            return $response;
        }
        DB::beginTransaction();
        try {
            $already_escrow =  Escrow::where(['user_id' => Auth::id(), 'order_id' => $order->id])->first();
            if (isset($already_escrow)) {
                $response = [
                    'success' => false,
                    'message' => __('Sorry ! fund already moved to escrow')
                ];

                return $response;
            }
            Log::info('fund escrow start');

            Log::info(json_encode($wallet));
            Log::info(json_encode($order));
            $data = [
                'user_id' => Auth::id(),
                'wallet_id' => $wallet->id,
                'order_id' => $order->id,
                'amount' => $order->amount,
                'fees' => escrow_fees($order->amount, $coin),
                'fees_percentage' => $coin->escrow_fees
            ];
            $escrowed = Escrow::create($data);
            if ($escrowed) {
                Log::info(json_encode($escrowed));

                $wallet->decrement('balance', ($escrowed->amount + $escrowed->fees));
                $order->update(['status' => TRADE_STATUS_ESCROW]);
                Log::info('fund escrow successfully');

                $notification_heading = Auth::user()->first_name." ".Auth::user()->last_name.__(' moved fund to escrow account');
                $notification_msg = Auth::user()->first_name." ".Auth::user()->last_name.__(' moved fund to escrow account . The order id is '.$order->order_id);
                $this->commonService->sendNotificationToUser($order->buyer_id,$notification_heading,$notification_msg);
                $this->sendPageNotificationWhenStatusChange($order,$order->buyer_id);
            }

            $response = [
                'success' => true,
                'message' => __('Coin moved to escrow successfully')
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return $response;
        }

        DB::commit();
        return $response;
    }

    // escrow release process
    public function escrowReleasedProcess($order_id)
    {
        $response = [
            'success' => false,
            'message' => __('Something went wrong')
        ];
        $id = $this->commonService->checkValidId($order_id);
        if (is_array($id)) {
            $response = [
                'success' => false,
                'message' => __('Data not found')
            ];

            return $response;
        }
        $order = Order::where(['id'=> $id, 'seller_id' => Auth::id(), 'status' => TRADE_STATUS_PAYMENT_DONE])->first();
        if (empty($order)) {
            $response = [
                'success' => false,
                'message' => __('Order not found')
            ];

            return $response;

        }
        DB::beginTransaction();
        try {
            $escrow =  Escrow::where(['user_id' => Auth::id(), 'order_id' => $order->id, 'status'=> ESCROW_STATUS_PENDING])->first();
            if (empty($escrow)) {
                $response = [
                    'success' => false,
                    'message' => __('Escrow not found')
                ];

                return $response;
            }
            $buyer_wallet = Wallet::where(['id' => $order->buyer_wallet_id, 'user_id' => $order->buyer_id])->first();
            if (empty($buyer_wallet)) {
                $response = [
                    'success' => false,
                    'message' => __('Buyer wallet not found')
                ];

                return $response;
            }
            Log::info('release escrow start');
            Log::info('order ----');

            Log::info(json_encode($order));
            Log::info('buyer wallet ----');
            Log::info(json_encode($buyer_wallet));
            Log::info('escrow ----');
            Log::info(json_encode($escrow));

            $buyer_wallet->increment('balance', ($order->amount - $order->fees));
            $buyer_wallet->updated_at=date('Y-m-d h:i:s');
            $buyer_wallet->save();
            $escrow->update(['status' => ESCROW_STATUS_SUCCESS]);
            $order->update([
                'status' => TRADE_STATUS_TRANSFER_DONE,
                'transaction_id' => $order->buyer_id.$order->seller_id.$order->buyer_wallet_id.$order->seller_wallet_id.$order->coin_type.$order->currency.uniqid().time(),
                ]);
            Log::info('Escrow released successfully');

            $notification_heading = Auth::user()->first_name." ".Auth::user()->last_name.__(' has released the fund. transaction success');
            $notification_msg = Auth::user()->first_name." ".Auth::user()->last_name.__(' has released the fund. transaction success, please check your wallet . The order id is '.$order->order_id);
            $this->commonService->sendNotificationToUser($order->buyer_id,$notification_heading,$notification_msg);
            $this->sendPageNotificationWhenStatusChange($order,$order->buyer_id);
            $response = [
                'success' => true,
                'message' => __('Escrow released successfully. So transaction successful')
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return $response;
        }

        DB::commit();
        return $response;
    }

    // check wallet balance
    public function check_wallet_balance_for_escrow($user_id,$order, $coin)
    {
        $wallet = Wallet::where(['id' => $order->seller_wallet_id ,'user_id' => $user_id])->first();
        if (isset($wallet)) {
            if (($order->amount + escrow_fees($order->amount, $coin)) > $wallet->balance) {
                $response = [
                    'success' => false,
                    'message' => __('You do not have enough coin to escrow. Please Deposit enough to your wallet first. ')
                ];
            } else {
                $response = [
                    'success' => true,
                    'message' => __('Enough balance to escrow'),
                    'wallet' => $wallet
                ];
            }

        } else {
            $response = [
                'success' => false,
                'message' => __('Wallet not found')
            ];
        }

        return $response;
    }


    // check seller wallet balance
    public function check_seller_wallet_balance($user_id,$seller_wallet_id,$amount, $coin)
    {
        $wallet = Wallet::where(['id' => $seller_wallet_id ,'user_id' => $user_id])->first();
        if (isset($wallet)) {
            Log::info('Check wallet balance ');
            Log::info('amount = '. $amount);
            Log::info('escrow_fees = '. escrow_fees($amount, $coin));
            Log::info('wallet balance = '. $wallet->balance);
            if (($amount + escrow_fees($amount, $coin)) > $wallet->balance) {
                $response = [
                    'success' => false,
                    'message' => __('You do not have enough coin to place order. Please Deposit enough to your wallet first. ')
                ];
            } else {
                $response = [
                    'success' => true,
                    'message' => __('Enough balance to place order'),
                    'wallet' => $wallet
                ];
            }

        } else {
            $response = [
                'success' => false,
                'message' => __('Wallet not found')
            ];
        }

        return $response;
    }


    // upload Payment Sleep Process
    public function uploadPaymentSleepProcess($request)
    {
        $response = [
            'success' => false,
            'message' => __('Invalid request')
        ];

        DB::beginTransaction();
        try {
            $id = $this->commonService->checkValidId($request->order_id);
            $order = Order::where(['id' => $id, 'buyer_id' => Auth::id()])->first();
            if (isset($order)) {
                if($order->status != TRADE_STATUS_ESCROW) {
                    $response = [
                        'success' => false,
                        'message' => __('Before the sellers escrow you should not make payment')
                    ];
                    return $response;
                }
                if ($order->status == TRADE_STATUS_ESCROW) {
                    $order->update([
                        'payment_sleep' => uploadFile($request->payment_sleep,IMG_PATH,''),
                        'status' => TRADE_STATUS_PAYMENT_DONE,
                        'payment_status' => STATUS_SUCCESS
                    ]);

                    $notification_heading = Auth::user()->first_name." ".Auth::user()->last_name.__(' has done the payment');
                    $notification_msg = Auth::user()->first_name." ".Auth::user()->last_name.__(' has done the payment . The order id is '.$order->order_id);
                    $this->commonService->sendNotificationToUser($order->seller_id,$notification_heading,$notification_msg);
                    $this->sendPageNotificationWhenStatusChange($order,$order->seller_id);
                    $response = [
                        'success' => true,
                        'message' => __('Payment slip uploaded successfully')
                    ];
                }

            } else {
                $response = [
                    'success' => false,
                    'message' => __('Order not found')
                ];
            }
        } catch (\Exception $e) {
            Log::info('uploadPaymentSleepProcess : '.$e->getMessage());
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

    // trade cancel Process
    public function cancelTrade($request)
    {
        $response = [
            'success' => false,
            'message' => __('Invalid request')
        ];

        DB::beginTransaction();
        try {
            $id = $this->commonService->checkValidId($request->order_id);
            if ($request->type == SELLER) {
                $order = Order::where(['id' => $id, 'seller_id' => Auth::id()])->first();
            } elseif ($request->type == BUYER) {
                $order = Order::where(['id' => $id, 'buyer_id' => Auth::id()])->first();
            } else {
                $response = [
                    'success' => false,
                    'message' => __('Order not found')
                ];
                return $response;
            }

            if (isset($order)) {
                if ($order->buyer_id == Auth::id()) {
                    $partner_id = $order->seller_id;
                    $reason_heading = $order->buyer->first_name.' '.$order->buyer->last_name.__(' (Buyer) cancel this (orderId= ').($order->order_id).__(') order');
                } else {
                    $partner_id = $order->buyer_id;
                    $reason_heading = $order->seller->first_name.' '.$order->seller->last_name.__(' (Seller) cancel this (orderId= ').($order->order_id).__(') order');
                }
                if ($request->type == SELLER) {
                    if($order->status != TRADE_STATUS_INTERESTED || $order->status != TRADE_STATUS_ESCROW) {
                        $response = [
                            'success' => false,
                            'message' => __('You can not cancel this order.')
                        ];
                        return $response;
                    }
                }
                if ($request->type == BUYER) {
                    if($order->status != TRADE_STATUS_INTERESTED) {
                        $response = [
                            'success' => false,
                            'message' => __('You can not cancel this order.')
                        ];
                        return $response;
                    }
                }

                $cancel = OrderCancelReason::create([
                    'order_id' => $order->id,
                    'type' => $request->type,
                    'details' => $request->reason,
                    'user_id' => Auth::id(),
                    'partner_id' => $partner_id,
                    'reason_heading' => $reason_heading,
                ]);
                if ($cancel) {
                    $order->update([
                        'status' => TRADE_STATUS_CANCEL,
                    ]);
                    Log::info('Order canceled');
                    Log::info(json_encode($order));
                    $escrow = Escrow::where(['order_id'=> $order->id, 'user_id'=> Auth::id(), 'status' => ESCROW_STATUS_PENDING])->first();
                    if(isset($escrow)) {
                        Log::info(json_encode($escrow));
                        Log::info('Escrow found when user cancel a order');
                        $wallet = Wallet::where(['id' => $escrow->wallet_id, 'user_id' => Auth::id()])->first();
                        Log::info(json_encode($wallet));
                        if(isset($wallet)) {
                            $wallet->increment('balance',$escrow->amount);
                        }
                        Log::info(json_encode($wallet));
                        $escrow->update(['amount' => 0, 'status' => ESCROW_STATUS_RETURN]);
                    }
                    $this->commonService->sendNotificationToUser($partner_id,$reason_heading,$request->reason);
                    $this->sendPageNotificationWhenStatusChange($order,$partner_id);
                    $response = [
                        'success' => true,
                        'message' => __('Order cancelled successfully')
                    ];
                }

            } else {
                $response = [
                    'success' => false,
                    'message' => __('Order not found')
                ];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info('cancelTrade exception ->'. $e->getMessage());
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }

        DB::commit();
        return $response;
    }


    // report user Process
    public function reportToUserOrder($request)
    {
        $response = [
            'success' => false,
            'message' => __('Invalid request')
        ];

        DB::beginTransaction();
        try {
            $id = $this->commonService->checkValidId($request->order_id);
            if ($request->type == SELLER) {
                $order = Order::where(['id' => $id, 'seller_id' => Auth::id()])->first();
            } elseif ($request->type == BUYER) {
                $order = Order::where(['id' => $id, 'buyer_id' => Auth::id()])->first();
            } else {
                $response = [
                    'success' => false,
                    'message' => __('Order not found')
                ];
                return $response;
            }

            if (isset($order)) {
                if ($order->buyer_id == Auth::id()) {
                    $partner_id = $order->seller_id;
                    $reason_heading = $order->buyer->first_name.' '.$order->buyer->last_name.__(' (Buyer) report this (orderId= ').($order->order_id).__(') order ');
                } else {
                    $partner_id = $order->buyer_id;
                    $reason_heading = $order->seller->first_name.' '.$order->seller->last_name.__(' (Seller) report this (orderId= ').($order->order_id).__(') order');
                }

                if($order->status == TRADE_STATUS_TRANSFER_DONE) {
                    $response = [
                        'success' => false,
                        'message' => __('You can not report this order.')
                    ];
                    return $response;
                }

                $report = OrderDispute::create([
                    'order_id' => $order->id,
                    'type' => $request->type,
                    'details' => $request->reason,
                    'reported_user' => Auth::id(),
                    'user_id' => $partner_id,
                    'reason_heading' => $reason_heading,
                    'image' => isset($request->attach_file) ? uploadFile($request->attach_file,IMG_PATH,'') : ''
                ]);
                if ($report) {
                    $order->update([
                        'is_reported' => STATUS_ACTIVE,
                    ]);
                    $this->commonService->sendNotificationToUser($partner_id,$reason_heading,$request->reason);
                    $this->sendPageNotificationWhenStatusChange($order,$partner_id);
                    $response = [
                        'success' => true,
                        'message' => __('Report created against order')
                    ];
                }

            } else {
                $response = [
                    'success' => false,
                    'message' => __('Order not found')
                ];
            }
        } catch (\Exception $e) {
            Log::info('reportToUserOrder exception ->'. $e->getMessage());
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

    // admin escrow release process
    public function adminReleaseEscrowProcess($order_id)
    {
        $response = [
            'success' => false,
            'message' => __('Something went wrong')
        ];
        $id = $this->commonService->checkValidId($order_id);
        if (is_array($id)) {
            $response = [
                'success' => false,
                'message' => __('Data not found')
            ];

            return $response;
        }
        $order = Order::where(['id'=> $id, 'status' => TRADE_STATUS_PAYMENT_DONE, 'is_reported' => STATUS_ACTIVE])->first();
        if (empty($order)) {
            $response = [
                'success' => false,
                'message' => __('Order not found')
            ];

            return $response;
        }
        if (!empty($order->transaction)) {
            $response = [
                'success' => false,
                'message' => __('Order transaction already found')
            ];

            return $response;
        }
        DB::beginTransaction();
        try {
            $escrow =  Escrow::where(['order_id' => $order->id, 'status'=> ESCROW_STATUS_PENDING])->first();
            if (empty($escrow)) {
                $response = [
                    'success' => false,
                    'message' => __('Escrow not found')
                ];

                return $response;
            }
            $buyer_wallet = Wallet::where(['id' => $order->buyer_wallet_id, 'user_id' => $order->buyer_id])->first();
            if (empty($buyer_wallet)) {
                $response = [
                    'success' => false,
                    'message' => __('Buyer wallet not found')
                ];

                return $response;
            }
            Log::info('admin release escrow start');
            Log::info('order ----');

            Log::info(json_encode($order));
            Log::info('buyer wallet ----');
            Log::info(json_encode($buyer_wallet));
            Log::info('escrow ----');
            Log::info(json_encode($escrow));

            $buyer_wallet->increment('balance', ($order->amount - $order->fees));
            $escrow->update(['status' => ESCROW_STATUS_SUCCESS]);
            $order->update([
                'status' => TRADE_STATUS_TRANSFER_DONE,
                'transaction_id' => "This orders escrow released by admin",
            ]);
            Log::info('Escrow released successfully');

            $response = [
                'success' => true,
                'message' => __('Escrow released successfully by admin.')
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::info('adminReleaseEscrowProcess exception -> '.$e->getMessage());
            $response = [
                'success' => false,
                'message' => __("Something went wrong")
            ];
            return $response;
        }

        DB::commit();
        return $response;
    }

    // admin escrow refund process
    public function adminRefundEscrowProcess($order_id)
    {
        $response = [
            'success' => false,
            'message' => __('Something went wrong')
        ];
        $id = $this->commonService->checkValidId($order_id);
        if (is_array($id)) {
            $response = [
                'success' => false,
                'message' => __('Data not found')
            ];

            return $response;
        }
        $order = Order::where(['id'=> $id, 'is_reported' => STATUS_ACTIVE])->where('status','>',TRADE_STATUS_INTERESTED)->first();
        if (empty($order)) {
            $response = [
                'success' => false,
                'message' => __('Order not found')
            ];

            return $response;
        }

        DB::beginTransaction();
        try {
            $escrow =  Escrow::where(['order_id' => $order->id, 'status'=> ESCROW_STATUS_PENDING])->first();
            if (empty($escrow)) {
                $response = [
                    'success' => false,
                    'message' => __('Escrow not found')
                ];

                return $response;
            }
            $seller_wallet = Wallet::where(['id' => $order->seller_wallet_id, 'user_id' => $order->seller_id])->first();
            if (empty($seller_wallet)) {
                $response = [
                    'success' => false,
                    'message' => __('Seller wallet not found')
                ];

                return $response;
            }
            Log::info('admin escrow refund start');
            Log::info('order ----');

            Log::info(json_encode($order));
            Log::info('seller wallet ----');
            Log::info(json_encode($seller_wallet));
            Log::info('escrow ----');
            Log::info(json_encode($escrow));

            $seller_wallet->increment('balance', ($escrow->amount + $escrow->fees));
            $escrow->update(['status' => ESCROW_STATUS_SUCCESS]);
            $order->update([
                'status' => TRADE_STATUS_CANCELLED_ADMIN,
                'transaction_id' => "This orders escrow refunded by admin",
            ]);
            Log::info('Escrow refunded successfully by admin');

            $response = [
                'success' => true,
                'message' => __('Escrow released successfully by admin.')
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::info('adminReleaseEscrowProcess exception -> '.$e->getMessage());
            $response = [
                'success' => false,
                'message' => __("Something went wrong")
            ];
            return $response;
        }

        DB::commit();
        return $response;
    }

    // kyc validation check for trade
    public function kycValidationCheckTrade($userId)
    {
        $response = [
            'success' => true,
            'message' => __('success ')
        ];
        if (settings('kyc_enable_for_trade') == STATUS_ACTIVE) {
            if (settings('kyc_nid_enable_for_trade') == STATUS_ACTIVE) {
                $checkNid = checkUserKyc($userId, KYC_NID_REQUIRED, __('trade '));
                if ($checkNid['success'] == false) {
                    $response = [
                        'success' => false,
                        'message' => $checkNid['message']
                    ];
                    return $response;
                } else {
                    $response = [
                        'success' => true,
                        'message' => __('success ')
                    ];
                }
            }
            if(settings('kyc_passport_enable_for_trade') ==  STATUS_ACTIVE) {
                $checkPass = checkUserKyc($userId, KYC_PASSPORT_REQUIRED, __('trade '));
                if ($checkPass['success'] == false) {
                    $response = [
                        'success' => false,
                        'message' => $checkPass['message']
                    ];
                    return $response;
                } else {
                    $response = [
                        'success' => true,
                        'message' => __('success ')
                    ];
                }
            }
            if(settings('kyc_driving_enable_for_trade') ==  STATUS_ACTIVE) {
                $checkDrive = checkUserKyc($userId, KYC_DRIVING_REQUIRED, __('trade '));
                if ($checkDrive['success'] == false) {
                    $response = [
                        'success' => false,
                        'message' => $checkDrive['message']
                    ];
                    return $response;
                } else {
                    $response = [
                        'success' => true,
                        'message' => __('success ')
                    ];
                }
            }
        } else {
            $response = [
                'success' => true,
                'message' => __('success ')
            ];
        }

        return $response;
    }

    // update order feedback
    public function orderFeedbackUpdate($request,$user_id)
    {
        $response = [
            'success' => false,
            'message' => __('failed ')
        ];
        try {
            if($request->type == 'buyer') {
                $order = Order::where(['id' => $request->order_id, 'buyer_id' => $user_id])->first();
                $data = [
                    'buyer_feedback' => isset($request->buyer_feedback) ? $request->buyer_feedback : Null,
                ];
            } else {
                $order = Order::where(['id' => $request->order_id, 'seller_id' => $user_id])->first();
                $data = [
                    'seller_feedback' => isset($request->seller_feedback) ? $request->seller_feedback : Null,
                ];
            }
            if ($order) {
                $order->update($data);
                if ($order->buyer_id == $user_id) {
                    $partner_id = $order->seller_id;
                } else {
                    $partner_id = $order->buyer_id;
                }
                $this->sendPageNotificationWhenStatusChange($order,$partner_id);
                $response = [
                    'success' => true,
                    'message' => __('Feedback updated successfully ')
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => __('Order not found ')
                ];
            }
        } catch (\Exception $e) {
            $this->logger->log('orderFeedbackUpdate', $e->getMessage());
            $response = [
                'success' => false,
                'message' => __('Something went wrong ')
            ];
        }
        return $response;
    }


    // send push status
    public function sendPageNotificationWhenStatusChange($order,$user_id)
    {
        try {
            $channel = 'sendorderstatus_'.$user_id.'_'.$order->id;
            $config = config('broadcasting.connections.pusher');
            $pusher = new Pusher($config['key'], $config['secret'], $config['app_id'], $config['options']);
            $data['html'] = $this->testGetDetails($order);
            $test =  $pusher->trigger($channel , 'receive_order_status', $data);
        } catch (\Exception $exception) {}
    }

    public function testGetDetails($order)
    {
        $data = [];
        $id = $order->id;
        $coin = Coin::where('type', $order->coin_type)->first();
        if($order->buyer_id == Auth::id()) {
            $sender_id = $order->seller_id;
            $data['type'] = 'seller';
            $data['title'] = __('Sell ').check_default_coin_type($order->coin_type).__(' to '). $order->buyer->first_name.' '.$order->buyer->last_name ;
            $data['type_text'] = __('Sell ').check_default_coin_type($order->coin_type).__(' to ');
            $data['check_balance'] = $this->check_wallet_balance_for_escrow(Auth::id(),$order, $coin);
        }else{
            $sender_id = $order->buyer_id;
            $data['type'] = 'buyer';
            $data['title'] = __('Buy ').check_default_coin_type($order->coin_type).__(' from '). $order->seller->first_name.' '.$order->seller->last_name ;
            $data['type_text'] = __('Buy ').check_default_coin_type($order->coin_type).__(' from ');
        }
        $data['item'] = $order;
        if($order->is_reported == STATUS_ACTIVE) {
            $data['report'] = OrderDispute::where('order_id', $order->id)->first();
        }
        $data['selected_user'] = User::find($sender_id);
        $html = '';
        $html .= View::make('user.marketplace.market.order.rightside',$data);
        return $html;
    }

}
