<?php
namespace App\Repository;
use App\Model\Admin\Bank;
use App\Model\Buy;
use App\Model\Coin;
use App\Model\MembershipBonusDistributionHistory;
use App\Model\MembershipClub;
use App\Model\MembershipPlan;
use App\Model\MembershipTransactionHistory;
use App\Model\OfferPaymentMethod;
use App\Model\Sell;
use App\Model\Wallet;
use App\Services\CoinPaymentsAPI;
use App\Services\Logger;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Null_;

class OfferRepository
{

    // save offer details buy and sell
    public function saveOffer($request)
    {
        $response = [
            'success' => false,
            'message' => __('Something went wrong')
        ];
        DB::beginTransaction();
        try {
            $coin =  Coin::where(['type' => $request->coin_type, 'status' => STATUS_ACTIVE])->first();
            if (empty($coin)) {
                $response = [
                    'success' => false,
                    'message' => __('Coin not found')
                ];
                return $response;
            }
            if ($request->offer_type == BUY) {
                if ($coin->is_buy != STATUS_ACTIVE) {
                    $response = [
                        'success' => false,
                        'message' => __('This coin is not active for buy')
                    ];
                    return $response;
                }
                $offer_type = BUY;
            }
            if ($request->offer_type == SELL) {
                if ($coin->is_sell != STATUS_ACTIVE) {
                    $response = [
                        'success' => false,
                        'message' => __('This coin is not active for sell')
                    ];
                    return $response;
                }
                $offer_type = SELL;
            }
            $data = [
                'coin_type' => $request->coin_type,
                'coin_id' => $coin->id,
                'country' => $request->country,
                'address' => $request->address,
                'currency' => $request->currency,
                'ip' => request()->ip(),
                'rate_type' => $request->rate_type,
                'minimum_trade_size' => $request->minimum_trade_size,
                'maximum_trade_size' => $request->maximum_trade_size,
                'headline' => $request->headline,
                'terms' => $request->terms,
                'instruction' => $request->instruction,
            ];

            if(empty($request->edit_id)) {
                $data['unique_code'] = uniqid().date('').time();
            }
            if($request->coin_type == DEFAULT_COIN_TYPE) {
                $data['market_price'] = $request->coin_rate;
            } else {
                $data['market_price'] = convert_currency(1,$request->currency,$request->coin_type);
            }
            $wallet = get_primary_wallet(Auth::id(), $request->coin_type);
            if (empty($request->edit_id)) {
                $data['user_id'] = Auth::id();
            }
            $data['wallet_id'] = $wallet->id;
            if($request->coin_type == DEFAULT_COIN_TYPE) {
                $data['coin_rate'] = $request->coin_rate;
            } else {
                if ($request->rate_type == RATE_TYPE_DYNAMIC) {
                    $data['price_type'] = $request->price_type;
                    $data['rate_percentage'] = $request->rate_percentage;
                    $data['coin_rate'] = get_current_market_price_rate($data['market_price'], $data['rate_percentage'],$data['price_type']);
                } else {
                    $data['coin_rate'] = $request->coin_rate;
                }
            }

            if (isset($request->edit_id)) {
                if ($request->offer_type == BUY) {
                    $offer_type=BUY;
                    $offer = Buy::where(['id' => $request->edit_id, 'user_id' => Auth::id()])->first();
                } else {
                    $offer_type=SELL;
                    $offer = Sell::where(['id' => $request->edit_id, 'user_id' => Auth::id()])->first();
                }
            }

            if (!empty($request->edit_id)) {
                if (isset($offer)) {
                    $offer->update($data);
                    if (isset($request->payment_methods[0])) {
                        $this->create_offer_payment_method($request->payment_methods, $offer->id, $request->offer_type);
                    }
                    $selected_payments = OfferPaymentMethod::where('offer_id', $offer->id)->pluck('payment_method_id');
                    $offer->offer_type=$offer_type;
                    $offer->payment_method=$selected_payments;
                    $offer->market_rate = ($offer->price_type == RATE_ABOVE) ? ($offer->rate_percentage+0)." % Above Market" : ($offer->rate_percentage+0)." % Below Market";
                    $response = [
                        'success' => true,
                        'data' => ['offer'=>$offer],
                        'message' => __('Offer updated successfully')
                    ];
                } else {
                    $response = [
                        'success' => true,
                        'message' => __('Offer not found')
                    ];
                }
            } else {
                if ($request->offer_type == BUY) {
                    $offer_type=BUY;
                    $create_offer = Buy::create($data);
                    $retrive_data = Buy::find($create_offer->id);
                } else {
                    $offer_type=SELL;
                    $create_offer = Sell::create($data);
                    $retrive_data = Sell::find($create_offer->id);
                }

                if ($create_offer) {
                    if (isset($request->payment_methods[0])) {
                        $this->create_offer_payment_method($request->payment_methods, $create_offer->id, $request->offer_type);
                    }
                }
                $selected_payments = OfferPaymentMethod::where('offer_id', $create_offer->id)->pluck('payment_method_id');
                $create_offer->status=$retrive_data->status;
                $create_offer->offer_type=$offer_type;
                $create_offer->payment_method=$selected_payments;
                $create_offer->market_rate = ($create_offer->price_type == RATE_ABOVE) ? ($create_offer->rate_percentage+0)." % Above Market" : ($create_offer->rate_percentage+0)." % Below Market";
                $response = [
                    'success' => true,
                    'data' => ['offer'=>$create_offer],
                    'message' => __('Offer created successfully')
                ];
            }

        } catch (\Exception $e) {
            Log::info('save offer ex-> '. $e->getMessage());
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

    // create offer payment method
    public function create_offer_payment_method($payment_methods,$offer_id,$offer_type)
    {
        $offers = OfferPaymentMethod::where(['offer_id' => $offer_id, 'offer_type' => $offer_type])->get();
        if (isset($offers[0])) {
            OfferPaymentMethod::where(['offer_id' => $offer_id, 'offer_type' => $offer_type])->delete();
        }
        foreach ($payment_methods as $key => $method) {
            OfferPaymentMethod::create([
                'offer_id' => $offer_id,
                'payment_method_id' => $method,
                'offer_type' => $offer_type,
            ]);
        }
    }

    // active inactive offer
    public function activeDeactiveOffer($id,$type,$status)
    {
        $response = [
            'success' => true,
            'message' => __('Invalid Request')
        ];
        try {
            if ($type == BUY) {
                $offer = Buy::where(['id' => $id, 'user_id' => Auth::id()])->first();
            } else {
                $offer = Sell::where(['id' => $id, 'user_id' => Auth::id()])->first();
            }
            if(isset($offer)) {
                $offer->update(['status' => $status]);
                if($status == STATUS_ACTIVE) {
                    $message = __('Offer activated successfully');
                } else {
                    $message = __('Offer deactivated successfully');
                }
                $response = [
                    'success' => true,
                    'message' => $message
                ];
            } else {
                $response = [
                    'success' => true,
                    'message' => __('Offer not found')
                ];
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return $response;
        }

        return $response;
    }


    // check dynamic offer and update with rate
    public function checkOfferWithDynamicRate($type,$offer_id)
    {
        $logger = new Logger();
        try {
            if ($type == 'sell') {
                $offer = Buy::where(['unique_code' => $offer_id])->first();
            } else {
                $offer = Sell::where(['unique_code' => $offer_id])->first();
            }
            if (isset($offer)) {
                if ($offer->rate_type == RATE_TYPE_DYNAMIC) {
                    $data['market_price'] = convert_currency(1,$offer->currency,$offer->coin_type);
                    $logger->log('checkOfferWithDynamicRate current market rate ', $data['market_price']);
                    $logger->log('checkOfferWithDynamicRate current offer rate ', $offer->market_price);
                    if ($data['market_price'] != $offer->market_price) {
                        $logger->log('checkOfferWithDynamicRate old rate ', $offer->coin_rate);

                        $data['coin_rate'] = get_current_market_price_rate($data['market_price'], $offer->rate_percentage,$offer->price_type);
                        $logger->log('checkOfferWithDynamicRate new rate ', $data['coin_rate']);

                        $offer->update($data);
                    }
                }
            }
        } catch (\Exception $e) {
            $logger->log('checkOfferWithDynamicRate', $e->getMessage());
        }
    }

    public function updateOfferWithDynamicRate(){

        $rate = getCoinPaymentApiRates();
        $logger = new Logger();
        $offer_buys = Buy::where('rate_type','=',RATE_TYPE_DYNAMIC)->where('status','=',STATUS_ACTIVE)->get();
        $offer_sales = Sell::where('rate_type','=',RATE_TYPE_DYNAMIC)->where('status','=',STATUS_ACTIVE)->get();
        $market_price = [];
        foreach($offer_buys as $item){
            $to = $item->currency;
            $from = $item->coin_type;
            if(isset($market_price[$from][$to]) && !empty($market_price[$from][$to])){
                $data['market_price'] = $market_price[$from][$to];
            }else{
                if($rate){
                    $btcRate = $rate[$to];
                    if ($from == 'BTC') {
                        $data['market_price'] = bcmul(1,(bcdiv(1, $btcRate['rate_btc'],8)),8);
                    } else {
                        $otherRate = $rate[$from];
                        $toRate = bcdiv($btcRate['rate_btc'],$otherRate['rate_btc'],8);
                        $data['market_price'] = bcmul(1, (bcdiv(1,$toRate,8)),8);
                    }
                }else{
                    $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
                    $json = file_get_contents($url); //,FALSE,$ctx);
                    $jsondata = json_decode($json, TRUE);
                    $data['market_price'] = bcmul(1, $jsondata[$to],8);
                }
                $market_price[$from][$to] = $data['market_price'];
            }
            if ($data['market_price'] != $item->market_price) {
                $data['coin_rate'] = get_current_market_price_rate($data['market_price'], $item->rate_percentage,$item->price_type);
                Buy::where('id','=',$item->id)->update($data);
            }
        }
        foreach($offer_sales as $item){
            $to = $item->currency;
            $from = $item->coin_type;
            if(isset($market_price[$from][$to]) && !empty($market_price[$from][$to])){
                $data['market_price'] = $market_price[$from][$to];
            }else{
                if($rate){
                    $btcRate = $rate[$to];
                    if ($from == 'BTC') {
                        $data['market_price'] = bcmul(1,(bcdiv(1, $btcRate['rate_btc'],8)),8);
                    } else {
                        $otherRate = $rate[$from];
                        $toRate = bcdiv($btcRate['rate_btc'],$otherRate['rate_btc'],8);
                        $data['market_price'] = bcmul(1, (bcdiv(1,$toRate,8)),8);
                    }
                }else{
                    $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
                    $json = file_get_contents($url); //,FALSE,$ctx);
                    $jsondata = json_decode($json, TRUE);
                    $data['market_price'] = bcmul(1, $jsondata[$to],8);
                }
                $market_price[$from][$to] = $data['market_price'];
            }
            if ($data['market_price'] != $item->market_price) {
                $data['coin_rate'] = get_current_market_price_rate($data['market_price'], $item->rate_percentage,$item->price_type);
                Sell::where('id','=',$item->id)->update($data);
            }
        }
        $logger->log('updateOfferWithDynamicRate', 'Output');
    }
}
