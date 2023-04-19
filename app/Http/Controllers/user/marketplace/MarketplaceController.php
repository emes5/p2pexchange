<?php

namespace App\Http\Controllers\user\marketplace;

use App\Http\Requests\PlaceOrderRequest;
use App\Http\Requests\ReportUserRequest;
use App\Http\Requests\TradeCancelRequest;
use App\Http\Requests\UploadSleepRequest;
use App\Http\Services\CommonService;
use App\Http\Services\OfferService;
use App\Http\Services\TradeService;
use App\Model\Buy;
use App\Model\Coin;
use App\Model\Order;
use App\Model\OrderDispute;
use App\Model\PaymentMethod;
use App\Model\Sell;
use App\Repository\ChatRepository;
use App\Repository\MarketRepository;
use App\Repository\OfferRepository;
use App\Services\Logger;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;
use Stevebauman\Location\Facades\Location;

class MarketplaceController extends Controller
{

    /**
     * Initialize market service
     *
     * MarketController constructor.
     */
    public $logger;
    public $marketRepo;
    public $offerRepo;
    public $service;
    public $tradeService;
    public $chatService;

    public function __construct()
    {
        $this->logger = new Logger();
        $this->marketRepo = new MarketRepository;
        $this->offerRepo = new OfferRepository();
        $this->service = new OfferService();
        $this->tradeService = new TradeService();
        $this->chatService = new ChatRepository();
    }


    // user trade profile
    public function userTradeProfile($user_id)
    {
        $country = Auth::user()->country ?? 'any';
        $response = $this->service->userTradeProfile($user_id,$country);
        if($response['success'] == true) {
            return view('user.marketplace.user.profile', $response['data']);
        } else {
            return redirect()->back()->with('dismiss', $response['message']);
        }
    }
    // offer list
    public function marketPlace(Request $request)
    {
        $offset = 0;
        $limit =  2 ;
        $data['settings'] = allsetting();
        if($request->country) {
            $data['country'] = $request->country;
        } else {
            $data['country'] = 'any';
            $myIp = Location::get(request()->ip());
            if ($myIp == false) {
                if (Auth::user()) {
                    if(!empty(Auth::user()->country)) {
                        $data['country'] = strtoupper(Auth::user()->country);
                    } else {
                        return redirect()->route('userProfile',['qr'=>'eProfile-tab'])->with('dismiss',__('Please add your country before trade'));
                    }
                } else {
                    $data['country'] = 'any';
                }
            } else {
                $data['country'] = $myIp->countryCode;
            }
        }
        if($request->coin_type) {
            $data['coins_type'] = $request->coin_type;
        } else {
            $data['coins_type'] = 'BTC';
        }
        if($request->payment_method) {
            $data['pmethod'] = $request->payment_method;
        } else {
            $data['pmethod'] = 'any';
        }

        if($request->offer_type) {
            $data['offer_type'] = $request->offer_type;
        }

        $data['title'] = __('Buy and Sell');

        $data['countries'] = countrylist();
        $data['coins'] = Coin::where('status', STATUS_ACTIVE)->orderBy('id', 'ASC')->get();
        $data['payment_methods'] = PaymentMethod::where('status', STATUS_ACTIVE)->orderBy('id','Desc')->get();

        if(empty($request->offer_type)) {
            if($data['country'] == 'any') {
                $data['buys'] = Buy::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type']])->orderBy('id', 'DESC');
                $data['buys_total_count'] = $data['buys']->count();
                $data['buys'] = $data['buys']->offset($offset)->limit($limit)->get();
                $data['sells'] = Sell::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type']])->orderBy('id', 'DESC');
                $data['sells_total_count'] = $data['sells']->count();
                $data['sells'] = $data['sells']->offset($offset)->limit($limit)->get();
            } else {
                $data['buys'] = Buy::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type'], 'country' => $data['country']])->orderBy('id', 'DESC');
                $data['buys_total_count'] = $data['buys']->count();
                $data['buys'] = $data['buys']->offset($offset)->limit($limit)->get();
                $data['sells'] = Sell::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type'], 'country' => $data['country']])->orderBy('id', 'DESC');
                $data['sells_total_count'] = $data['sells']->count();
                $data['sells'] = $data['sells']->offset($offset)->limit($limit)->get();
            }
        }

        if(isset($request->offer_type) && ($request->offer_type == BUY_SELL || $request->offer_type == SELL)) {
            if($request->country == 'any') {
                if($request->payment_method == 'any') {
                    $data['buys'] = Buy::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type']])->orderBy('id', 'DESC');
                    $data['buys_total_count'] = $data['buys']->count();
                    $data['buys'] = $data['buys']->offset($offset)->limit($limit)->get();
                } else {
                    $data['buys'] = Buy::join('offer_payment_methods', 'offer_payment_methods.offer_id', '=', 'buys.id')
                        ->where(['offer_payment_methods.offer_type' => BUY, 'offer_payment_methods.payment_method_id' => $request->payment_method])
                        ->where(['buys.status' => STATUS_ACTIVE, 'buys.coin_type' => $data['coins_type']])
                        ->orderBy('buys.id', 'DESC')
                        ->select('buys.*');
                    $data['buys_total_count'] = $data['buys']->count();
                    $data['buys'] = $data['buys']->offset($offset)->limit($limit)->get();
                }
            } else {
                if($request->payment_method == 'any') {
                    $data['buys'] = Buy::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type'], 'country' => $data['country']])->orderBy('id', 'DESC');
                    $data['buys_total_count'] = $data['buys']->count();
                    $data['buys'] = $data['buys']->offset($offset)->limit($limit)->get();
                } else {
                    $data['buys'] = Buy::join('offer_payment_methods', 'offer_payment_methods.offer_id', '=', 'buys.id')
                        ->where(['offer_payment_methods.offer_type' => BUY, 'offer_payment_methods.payment_method_id' => $request->payment_method])
                        ->where(['buys.status' => STATUS_ACTIVE, 'buys.coin_type' => $data['coins_type'],'buys.country' => $data['country']])
                        ->orderBy('buys.id', 'DESC')
                        ->select('buys.*');
                    $data['buys_total_count'] = $data['buys']->count();
                    $data['buys'] = $data['buys']->offset($offset)->limit($limit)->get();
                }
            }
        }

        if(isset($request->offer_type) && ($request->offer_type == BUY_SELL || $request->offer_type == BUY)) {
            if($request->country == 'any') {
                if($request->payment_method == 'any') {
                    $data['sells'] = Sell::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type']])->orderBy('id', 'DESC');
                    $data['sells_total_count'] = $data['sells']->count();
                    $data['sells'] = $data['sells']->offset($offset)->limit($limit)->get();
                } else {
                    $data['sells'] = Sell::join('offer_payment_methods', 'offer_payment_methods.offer_id', '=', 'sells.id')
                        ->where(['offer_payment_methods.offer_type' => SELL, 'offer_payment_methods.payment_method_id' => $request->payment_method])
                        ->where(['sells.status' => STATUS_ACTIVE, 'sells.coin_type' => $data['coins_type']])
                        ->orderBy('sells.id', 'DESC')
                        ->select('sells.*');
                    $data['sells_total_count'] = $data['sells']->count();
                    $data['sells'] = $data['sells']->offset($offset)->limit($limit)->get();
                }
            } else {
                if($request->payment_method == 'any') {
                    $data['sells'] = Sell::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type'], 'country' => $data['country']])->orderBy('id', 'DESC');
                    $data['sells_total_count'] = $data['sells']->count();
                    $data['sells'] = $data['sells']->offset($offset)->limit($limit)->get();
                } else {
                    $data['sells'] = Sell::join('offer_payment_methods', 'offer_payment_methods.offer_id', '=', 'sells.id')
                        ->where(['offer_payment_methods.offer_type' => SELL, 'offer_payment_methods.payment_method_id' => $request->payment_method])
                        ->where(['sells.status' => STATUS_ACTIVE, 'sells.coin_type' => $data['coins_type']])
                        ->orderBy('sells.id', 'DESC')
                        ->select('sells.*');
                    $data['sells_total_count'] = $data['sells']->count();
                    $data['sells'] = $data['sells']->offset($offset)->limit($limit)->get();
                }
            }
        }
        //dd($data['sells_total_count'],$data['sells'],$data['buys_total_count'],$data['buys']);
        return view('user.marketplace.market.marketplace', $data);
    }

    // offer details
    public function openTrade($type, $offer_id)
    {
        $myIp = Location::get(request()->ip());
        if ($myIp == false) {
            if(!empty(Auth::user()->country)) {
                $data['country'] = strtoupper(Auth::user()->country);
            } else {
                return redirect()->route('userProfile',['qr'=>'eProfile-tab'])->with('dismiss',__('Please add your country before trade'));
            }
        } else {
            $data['country'] = $myIp->countryCode;
        }
        $response = $this->service->userOpenOffer($type,$offer_id,$data['country']);

        if ($response['success']) {
            return view('user.marketplace.market.open_trade', $response['data']);
        } else {
            return redirect()->back()->with('dismiss', $response['message']);
        }
    }

    // place order
    public function placeOrder(PlaceOrderRequest $request)
    {
        $response = $this->marketRepo->saveOrder($request);
        if ($response['success'] == true) {
            return redirect()->route('tradeDetails', $response['order']->order_id)->with('success', $response['message']);
        }

        return redirect()->back()->withInput()->with('dismiss', $response['message']);
    }

    // my trade  list
    public function myTradeList(Request $request)
    {
        $data['title'] = __('My Trade List');
        $data['items'] = Order::where(['buyer_id' => Auth::id()])->orWhere(['seller_id' => Auth::id()])->orderBy('id', 'DESC')->paginate(20);


        return view('user.marketplace.market.trade_list', $data);
    }

    // trade details
    public function tradeDetails($order_id)
    {
        $response = $this->tradeService->userTradeDetails($order_id,Auth::id());

        if ($response['success']) {
            return view('user.marketplace.market.order_details', $response['data']);
        } else {
            return redirect()->back()->with('dismiss', $response['message']);
        }
    }

    // cancel trade
    public function tradeCancel(TradeCancelRequest $request)
    {
        $response = $this->marketRepo->cancelTrade($request);
        if ($response['success'] == true) {
            return redirect()->back()->with('success', $response['message']);
        }

        return redirect()->back()->withInput()->with('dismiss', $response['message']);
    }

    // report user for order
    public function reportUserOrder(ReportUserRequest $request)
    {
        $response = $this->marketRepo->reportToUserOrder($request);
        if ($response['success'] == true) {
            return redirect()->back()->with('success', $response['message']);
        }

        return redirect()->back()->withInput()->with('dismiss', $response['message']);
    }

    // fund escrow process
    public function fundEscrow($order_id)
    {
        $id = app(CommonService::class)->checkValidId($order_id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Data not found.')]);
        }
        $response = $this->marketRepo->escrowFundProcess($id);
        if ($response['success'] == true) {
            return redirect()->back()->with('success', $response['message']);
        }

        return redirect()->back()->withInput()->with('dismiss', $response['message']);
    }

    // fund escrow release process
    public function releasedEscrow($order_id)
    {
        $response = $this->marketRepo->escrowReleasedProcess($order_id);
        if ($response['success'] == true) {
            return redirect()->back()->with('success', $response['message']);
        }

        return redirect()->back()->withInput()->with('dismiss', $response['message']);
    }

    // upload payment sleep
    public function uploadPaymentSleep(UploadSleepRequest $request)
    {
        $id = app(CommonService::class)->checkValidId($request->order_id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Order not found.')]);
        }
        $response = $this->marketRepo->uploadPaymentSleepProcess($request);
        if ($response['success'] == true) {
            return redirect()->back()->with('success', $response['message']);
        }

        return redirect()->back()->withInput()->with('dismiss', $response['message']);
    }

    // get trade coin rate
    public function getTradeCoinRate(Request $request)
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

        return response()->json($data);

    }


    /**
     * sendUserMessage
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function sendOrderMessage(Request $request) {

        $response = $this->chatService->sendOrderMessage($request);
        if ($response['success'] == false) {
            return response()->json(['data' => $response]);
        }
        $response['data']['sender_user']->image = show_image($response['data']['sender_id'],'user');
        $response['data']['my_image'] =show_image(Auth::id(),'user');
        try {
            $channel = 'userordermessage_'.$response['data']->receiver_id.'_'.$request->order_id;
            $config = config('broadcasting.connections.pusher');
            $pusher = new Pusher($config['key'], $config['secret'], $config['app_id'], $config['options']);

            $test =  $pusher->trigger($channel , 'receive_message', $response);
        } catch (\Exception $exception) {

        }

        return response()->json(['data' => $response]);

    }

    // save user agreement
    public function saveUserAgreement(Request $request)
    {
        try {
            if(isset($request->agree_terms)) {
                User::where('id',Auth::id())->update(['agree_terms' => $request->agree_terms]);
                return redirect()->back();
            } else {
                return redirect()->back()->with('dismiss', __('Your answer is required to continue.'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }

    }

    // update feedback
    public function updateFeedback(Request $request)
    {
        try {
            $response = $this->marketRepo->orderFeedbackUpdate($request,Auth::id());
            if ($response['success'] == true) {
                return redirect()->back()->with('success', $response['message']);
            } else {
                return redirect()->back()->with('dismiss', $response['message']);
            }
        } catch (\Exception $e) {
            $this->logger->log('updateFeedback', $e->getMessage());
            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }
    }


    // Sell offer list
    public function sellOfferList(Request $request)
    {
        $offset = $request->query_offset;
        $limit = $request->query_limit;
        $data['settings'] = allsetting();
        if($request->country) {
            $data['country'] = $request->country;
        } else {
            $data['country'] = 'any';
            $myIp = Location::get(request()->ip());
            if ($myIp == false) {
                if (Auth::user()) {
                    if(!empty(Auth::user()->country)) {
                        $data['country'] = strtoupper(Auth::user()->country);
                    } else {
                        return redirect()->route('userProfile',['qr'=>'eProfile-tab'])->with('dismiss',__('Please add your country before trade'));
                    }
                } else {
                    $data['country'] = 'any';
                }
            } else {
                $data['country'] = $myIp->countryCode;
            }
        }
        if($request->coin_type) {
            $data['coins_type'] = $request->coin_type;
        } else {
            $data['coins_type'] = 'BTC';
        }
        if($request->payment_method) {
            $data['pmethod'] = $request->payment_method;
        } else {
            $data['pmethod'] = 'any';
        }

        if($request->offer_type) {
            $data['offer_type'] = $request->offer_type;
        }

        $data['title'] = __('Buy and Sell');

        $data['countries'] = countrylist();
        $data['coins'] = Coin::where('status', STATUS_ACTIVE)->orderBy('id', 'ASC')->get();
        $data['payment_methods'] = PaymentMethod::where('status', STATUS_ACTIVE)->orderBy('id','Desc')->get();

        if(empty($request->offer_type)) {
            if($data['country'] == 'any') {
                $data['buys'] = Buy::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type']])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
                $data['sells'] = Sell::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type']])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
            } else {
                $data['buys'] = Buy::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type'], 'country' => $data['country']])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
                $data['sells'] = Sell::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type'], 'country' => $data['country']])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
            }
        }

        if(isset($request->offer_type) && ($request->offer_type == BUY_SELL || $request->offer_type == SELL)) {
            if($request->country == 'any') {
                if($request->payment_method == 'any') {
                    $data['buys'] = Buy::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type']])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
                } else {
                    $data['buys'] = Buy::join('offer_payment_methods', 'offer_payment_methods.offer_id', '=', 'buys.id')
                        ->where(['offer_payment_methods.offer_type' => BUY, 'offer_payment_methods.payment_method_id' => $request->payment_method])
                        ->where(['buys.status' => STATUS_ACTIVE, 'buys.coin_type' => $data['coins_type']])
                        ->orderBy('buys.id', 'DESC')
                        ->select('buys.*')
                        ->offset($offset)->limit($limit)->get();
                }
            } else {
                if($request->payment_method == 'any') {
                    $data['buys'] = Buy::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type'], 'country' => $data['country']])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
                } else {
                    $data['buys'] = Buy::join('offer_payment_methods', 'offer_payment_methods.offer_id', '=', 'buys.id')
                        ->where(['offer_payment_methods.offer_type' => BUY, 'offer_payment_methods.payment_method_id' => $request->payment_method])
                        ->where(['buys.status' => STATUS_ACTIVE, 'buys.coin_type' => $data['coins_type'],'buys.country' => $data['country']])
                        ->orderBy('buys.id', 'DESC')
                        ->select('buys.*')
                        ->offset($offset)->limit($limit)->get();
                }
            }
        }

        if(isset($request->offer_type) && ($request->offer_type == BUY_SELL || $request->offer_type == BUY)) {
            if($request->country == 'any') {
                if($request->payment_method == 'any') {
                    $data['sells'] = Sell::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type']])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
                } else {
                    $data['sells'] = Sell::join('offer_payment_methods', 'offer_payment_methods.offer_id', '=', 'sells.id')
                        ->where(['offer_payment_methods.offer_type' => SELL, 'offer_payment_methods.payment_method_id' => $request->payment_method])
                        ->where(['sells.status' => STATUS_ACTIVE, 'sells.coin_type' => $data['coins_type']])
                        ->orderBy('sells.id', 'DESC')
                        ->select('sells.*')
                        ->offset($offset)->limit($limit)->get();
                }
            } else {
                if($request->payment_method == 'any') {
                    $data['sells'] = Sell::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type'], 'country' => $data['country']])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
                } else {
                    $data['sells'] = Sell::join('offer_payment_methods', 'offer_payment_methods.offer_id', '=', 'sells.id')
                        ->where(['offer_payment_methods.offer_type' => SELL, 'offer_payment_methods.payment_method_id' => $request->payment_method])
                        ->where(['sells.status' => STATUS_ACTIVE, 'sells.coin_type' => $data['coins_type']])
                        ->orderBy('sells.id', 'DESC')
                        ->select('sells.*')
                        ->offset($offset)->limit($limit)->get();
                }
            }
        }
        return view('user.marketplace.market.sellOfferList', $data);
    }

    // Sell offer list
    public function buyOfferList(Request $request)
    {
        $offset = $request->query_offset;
        $limit = $request->query_limit;
        $data['settings'] = allsetting();
        if($request->country) {
            $data['country'] = $request->country;
        } else {
            $data['country'] = 'any';
            $myIp = Location::get(request()->ip());
            if ($myIp == false) {
                if (Auth::user()) {
                    if(!empty(Auth::user()->country)) {
                        $data['country'] = strtoupper(Auth::user()->country);
                    } else {
                        return redirect()->route('userProfile',['qr'=>'eProfile-tab'])->with('dismiss',__('Please add your country before trade'));
                    }
                } else {
                    $data['country'] = 'any';
                }
            } else {
                $data['country'] = $myIp->countryCode;
            }
        }
        if($request->coin_type) {
            $data['coins_type'] = $request->coin_type;
        } else {
            $data['coins_type'] = 'BTC';
        }
        if($request->payment_method) {
            $data['pmethod'] = $request->payment_method;
        } else {
            $data['pmethod'] = 'any';
        }

        if($request->offer_type) {
            $data['offer_type'] = $request->offer_type;
        }

        $data['title'] = __('Buy and Sell');

        $data['countries'] = countrylist();
        $data['coins'] = Coin::where('status', STATUS_ACTIVE)->orderBy('id', 'ASC')->get();
        $data['payment_methods'] = PaymentMethod::where('status', STATUS_ACTIVE)->orderBy('id','Desc')->get();

        if(empty($request->offer_type)) {
            if($data['country'] == 'any') {
                $data['buys'] = Buy::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type']])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
                $data['sells'] = Sell::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type']])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
            } else {
                $data['buys'] = Buy::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type'], 'country' => $data['country']])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
                $data['sells'] = Sell::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type'], 'country' => $data['country']])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
            }
        }

        if(isset($request->offer_type) && ($request->offer_type == BUY_SELL || $request->offer_type == SELL)) {
            if($request->country == 'any') {
                if($request->payment_method == 'any') {
                    $data['buys'] = Buy::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type']])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
                } else {
                    $data['buys'] = Buy::join('offer_payment_methods', 'offer_payment_methods.offer_id', '=', 'buys.id')
                        ->where(['offer_payment_methods.offer_type' => BUY, 'offer_payment_methods.payment_method_id' => $request->payment_method])
                        ->where(['buys.status' => STATUS_ACTIVE, 'buys.coin_type' => $data['coins_type']])
                        ->orderBy('buys.id', 'DESC')
                        ->select('buys.*')
                        ->offset($offset)->limit($limit)->get();
                }
            } else {
                if($request->payment_method == 'any') {
                    $data['buys'] = Buy::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type'], 'country' => $data['country']])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
                } else {
                    $data['buys'] = Buy::join('offer_payment_methods', 'offer_payment_methods.offer_id', '=', 'buys.id')
                        ->where(['offer_payment_methods.offer_type' => BUY, 'offer_payment_methods.payment_method_id' => $request->payment_method])
                        ->where(['buys.status' => STATUS_ACTIVE, 'buys.coin_type' => $data['coins_type'],'buys.country' => $data['country']])
                        ->orderBy('buys.id', 'DESC')
                        ->select('buys.*')
                        ->offset($offset)->limit($limit)->get();
                }
            }
        }

        if(isset($request->offer_type) && ($request->offer_type == BUY_SELL || $request->offer_type == BUY)) {
            if($request->country == 'any') {
                if($request->payment_method == 'any') {
                    $data['sells'] = Sell::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type']])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
                } else {
                    $data['sells'] = Sell::join('offer_payment_methods', 'offer_payment_methods.offer_id', '=', 'sells.id')
                        ->where(['offer_payment_methods.offer_type' => SELL, 'offer_payment_methods.payment_method_id' => $request->payment_method])
                        ->where(['sells.status' => STATUS_ACTIVE, 'sells.coin_type' => $data['coins_type']])
                        ->orderBy('sells.id', 'DESC')
                        ->select('sells.*')
                        ->offset($offset)->limit($limit)->get();
                }
            } else {
                if($request->payment_method == 'any') {
                    $data['sells'] = Sell::where(['status' => STATUS_ACTIVE, 'coin_type' => $data['coins_type'], 'country' => $data['country']])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
                } else {
                    $data['sells'] = Sell::join('offer_payment_methods', 'offer_payment_methods.offer_id', '=', 'sells.id')
                        ->where(['offer_payment_methods.offer_type' => SELL, 'offer_payment_methods.payment_method_id' => $request->payment_method])
                        ->where(['sells.status' => STATUS_ACTIVE, 'sells.coin_type' => $data['coins_type']])
                        ->orderBy('sells.id', 'DESC')
                        ->select('sells.*')
                        ->offset($offset)->limit($limit)->get();
                }
            }
        }
        return view('user.marketplace.market.buyOfferList', $data);
    }

}
