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
use App\Model\Sell;
use App\Model\UserVerificationCode;
use App\Model\Wallet;
use App\Repository\AffiliateRepository;
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

class OfferService
{

    public $logger;
    public $marketRepo;
    public $offerRepo;
    function __construct()
    {
        $this->logger = new Logger();
        $this->marketRepo = new MarketRepository();
        $this->offerRepo = new OfferRepository();
    }

    /**
     * @param $request
     * @return array
     */
    // marketplace data
    public function marketplaceData()
    {

    }

    // user trade profile
    public function userTradeProfile($userCode,$country,$paginate=10)
    {
        $response = ['success' => false, 'message' => __('Something went wrong')];
        try {
            $img = asset('assets/common/img/avater.png');
            $user = User::where(['unique_code' => $userCode])->first();
            if ($user) {
                if (!empty($user->photo)) {
                    $img = asset(IMG_USER_PATH.$user->photo);
                }
                $data['user'] = $user;
                $data['user']->online_status = check_online_status($user)['online_status'];
                $data['user']->last_seen = check_online_status($user)['last_seen'];
                $data['user']->photo = $img;
                $data['user_trading_info'] =$this->userTradingInfo($user);

                $buys = Buy::where(['status' => STATUS_ACTIVE, 'user_id' => $user->id])->orderBy('id', 'DESC')->paginate($paginate);
                $data['buys'] = $this->offerList($buys,$country);
                $sells = Sell::where(['status' => STATUS_ACTIVE, 'user_id' => $user->id])->orderBy('id', 'DESC')->paginate($paginate);
                $data['sells'] = $this->offerList($sells,$country);

                $response =  ['success' => true, 'message' => __('Data get successfully'), 'data' => $data];
            } else {
                $response = ['success' => false, 'message' => __('User not found'),'data' => []];
            }

        } catch (\Exception $exception) {
            $this->logger->log('userTradeProfile', $exception->getMessage());
            $response = ['success' => false, 'message' => __('Something went wrong'),'data' => []];
        }
        return $response;
    }

    // user open offer
    public function userOpenOffer($type, $offer_id, $country)
    {
        try {
            $checkKyc = $this->marketRepo->kycValidationCheckTrade(Auth::id());
            if ($checkKyc['success'] == false) {
                return ['success' => false, 'message' => $checkKyc['message'],'data' => []];
            }
            $this->offerRepo->checkOfferWithDynamicRate($type,$offer_id);

            if($type == 'buy') {
                $offer = Sell::where(['unique_code' => $offer_id])->first();
                if (isset($offer)) {
                    $data['title'] = __('Buy ').$offer->coin_type.__(' from '). $offer->user->first_name.' '.$offer->user->last_name ;
                    $data['offer'] = $this->offerDetailsData($offer,$country);
                    $data['type'] = $type;
                    $data['type_text'] = __('Buy ').$offer->coin_type.__(' from ');
                } else {
                    return ['success' => false, 'message' => __('Offer not found'),'data' => []];
                }
            } elseif($type == 'sell') {
                $offer = Buy::where(['unique_code' => $offer_id])->first();
                if (isset($offer)) {
                    $data['title'] = __('Sell ').$offer->coin_type.__(' to '). $offer->user->first_name.' '.$offer->user->last_name ;
                    $data['offer'] = $this->offerDetailsData($offer,$country);
                    $data['type'] = $type;
                    $data['type_text'] = __('Sell ').$offer->coin_type.__(' to ');
                } else {
                    return ['success' => false, 'message' => __('Offer not found'),'data' => []];
                }
            } else {
                return ['success' => false, 'message' => __('Offer not found'),'data' => []];
            }
            $response =  ['success' => true, 'message' => __('Data get successfully'), 'data' => $data];
        } catch (\Exception $e) {
            $this->logger->log('userOpenOffer', $e->getMessage());
            $response = ['success' => false, 'message' => __('Something went wrong'),'data' => []];
        }
        return $response;
    }

    // user trading info
    public function userTradingInfo($user)
    {
        $data['total_trades'] = user_trades_count($user->id,'total');
        $data['successful_trades'] = user_trades_count($user->id, TRADE_STATUS_TRANSFER_DONE);
        $data['ongoing_trades'] = $data['total_trades']-($data['successful_trades']+user_trades_count($user->id, TRADE_STATUS_CANCEL));
        $data['cancelled_trades'] = user_trades_count($user->id, TRADE_STATUS_CANCEL);
        $data['disputed_trades'] = user_disputed_trades($user->id);
        return $data;
    }

    //  offer list
    public function offerList($offers,$country)
    {
        if (isset($offers[0])) {
            foreach ($offers as $offer) {
                $this->offerDetailsData($offer,$country);
            }
        }
        return $offers;
    }

    // offer details
    public function offerDetailsData($offer,$country)
    {
        $offer->user_registered = date('M Y', strtotime($offer->user->created_at));
        $offer->user_trade_feedback = get_user_feedback_rate($offer->user_id);
        $offer->user_trades = count_trades($offer->user_id);
        $offer->user_code = $offer->user->unique_code;
        $offer->user_name = $offer->user->username;
        $offer->coin_type = check_default_coin_type($offer->coin_type);
        $offer->payment_method_details = $this->offerPaymentMethod($offer,$country);
        $offer->country = countrylist($offer->country);
        $offer->size = number_format($offer->minimum_trade_size,2). ' '.$offer->currency . __(' to '). number_format($offer->maximum_trade_size,2). ' '.$offer->currency;
        $offer->rate_details = $this->offerRateDetails($offer);
        return $offer;
    }

    // offer payment method
    public function offerPaymentMethod($offer,$country)
    {
        $data = [];
        if (isset($offer->payment($offer->id)[0])) {
            foreach ($offer->payment($offer->id) as $offer_payment) {
                if ($country == 'any') {
                    $data []= [
                        'payment_image' => $offer_payment->payment_method->image,
                        'payment_name' => $offer_payment->payment_method->name,
                        'payment_id' => $offer_payment->payment_method_id,
                    ];
                } elseif(is_accept_payment_method($offer_payment->payment_method_id,$country)) {
                    $data []= [
                        'payment_image' => $offer_payment->payment_method->image,
                        'payment_name' => $offer_payment->payment_method->name,
                        'payment_id' => $offer_payment->payment_method_id,
                    ];
                }
            }
        }
        return $data;
    }

    // offer rate details
    public function offerRateDetails($offer)
    {
        $data['offer_rate'] = number_format($offer->coin_rate,2).' '.$offer->currency;
        if($offer->rate_type == RATE_TYPE_DYNAMIC) {
            $data['rate_text'] = number_format($offer->rate_percentage,2) .' % ' .price_rate_type($offer->price_type) .__(' Market');
        } else {
            $data['rate_text'] = __('Static Rate');
        }
        return $data;
    }
}
