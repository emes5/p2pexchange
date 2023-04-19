<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Requests\Api\ChangeOfferStatus;
use App\Http\Requests\Api\SaveOfferrequest;
use App\Model\Buy;
use App\Model\Coin;
use App\Model\CountryPaymentMethod;
use App\Model\OfferPaymentMethod;
use App\Model\PaymentMethod;
use App\Model\Sell;
use App\Repository\OfferRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class OfferController extends Controller
{
    public function offerList(Request $request){
        $limit = $request->limit ?? 5;
        if(isset($request->type) && !empty($request->type)){
            $type = $request->type;
            if($type==BUY){
                $offer_type = BUY;
                $response = Buy::where(['user_id' => Auth::id()])->orderBy('id', 'DESC')->paginate($limit);
            }else if($type==SELL){
                $offer_type = SELL;
                $response = Sell::where(['user_id' => Auth::id()])->orderBy('id', 'DESC')->paginate($limit);
            } else{
                $data = ['success' => false, 'data' => [], 'message' => __('Invalid request found!')];
            }
            if($type==BUY || $type==SELL){
                foreach($response as $resp){
                    $resp->offer_type = $offer_type;
                    $resp->country = countrylist($resp->country);
                    $resp->market_rate = ($resp->price_type == RATE_ABOVE) ? ($resp->rate_percentage+0)." % Above Market" : ($resp->rate_percentage+0)." % Below Market";
                    $resp->selected_payment_methods = OfferPaymentMethod::where('offer_id', $resp->id)->pluck('payment_method_id');
                }
                if($type == BUY){
                    $data = ['success' => true, 'data' => $response, 'message' => __('Buy offer list')];
                }else{
                    $data = ['success' => true, 'data' => $response, 'message' => __('Sell offer list')];
                }
            }
        }
        else{
            $data = ['success' => false, 'data' => [], 'message' => __('Invalid request found!')];
        }
        return response()->json($data);
    }

    public function changeOfferStatus(ChangeOfferStatus $request){
        try {
            $type = $request->type;
            $id = $request->offer_id;
            if($type==BUY){
                $response = Buy::where(['id' => $id, 'user_id' => Auth::id()])->first();
            }else if($type==SELL){
                $response = Sell::where(['id' => $id, 'user_id' => Auth::id()])->first();
            }
            if(isset($response) && !empty($response)){
                $offerRepo = new OfferRepository();
                if($response->status==STATUS_ACTIVE){
                    $status = STATUS_DEACTIVE;
                }
                else{
                    $status = STATUS_ACTIVE;
                }
                $data = $offerRepo->activeDeactiveOffer($id,$type,$status);
            }
            else{
                $data = ['success' => false, 'data' => [], 'message' => __('Invalid request found!')];
            }
        }
        catch (\Exception $e) {
            $data = ['success' => false, 'data' => [], 'message' => __('Something went wrong.')];
        }
        return response()->json($data);
    }

    public function createOffer(Request $request){
        try {
            if(isset($request->offer_id) && !empty($request->offer_id) && isset($request->type) && !empty($request->offer_id)){
                if($request->type==BUY){
                    $offer_type=BUY;
                    $response['db_info']= Buy::where(['id' => $request->offer_id, 'user_id' => Auth::id()])->first();
                    $response['db_info']->offer_type = $offer_type;
                    $response['db_info']->selected_payment_methods = OfferPaymentMethod::where('offer_id', $request->offer_id)->where('offer_type', BUY)->pluck('payment_method_id');
                }
                else{
                    $offer_type=SELL;
                    $response['db_info']= Sell::where(['id' => $request->offer_id, 'user_id' => Auth::id()])->first();
                    $response['db_info']->offer_type = $offer_type;
                    $response['db_info']->selected_payment_methods = OfferPaymentMethod::where('offer_id', $request->offer_id)->where('offer_type', SELL)->pluck('payment_method_id');
                }
            }
            $response['offer_id'] = null;
            $message = 'Create offer information';
            if(isset($response['db_info']) && !empty($response['db_info'])){
                $response['offer_id'] = $response['db_info']->id;
                $message = 'Edit Offer information';
            }
            $response['coins'] = Coin::where('status', STATUS_ACTIVE)->orderBy('id', 'ASC')->get();
            $response['countries'] = countrylist();
            $response['currencies'] = currency_symbol_text();
            $response['payment_methods'] = PaymentMethod::where('status', STATUS_ACTIVE)->orderBy('id','Desc')->get();
            $response['rate_type'][RATE_TYPE_DYNAMIC] = __('Dynamic market price');
            $response['rate_type'][RATE_TYPE_STATIC] = __('Static Rate');
            $response['price_type'][RATE_ABOVE] = __('Above');
            $response['price_type'][RATE_BELOW] = __('Below');
            $data = ['success' => true, 'data' => $response, 'message' => __($message)];
        }
        catch (\Exception $e) {
            $data = ['success' => false, 'data' => [], 'message' => __('Something went wrong.')];
        }
        return response()->json($data);
    }

    public function saveOffer(SaveOfferrequest $request){
        $offerRepo = new OfferRepository();
        $response = $offerRepo->saveOffer($request);
        return response()->json($response);
    }

    public function getCountryPaymentMethodApp(Request $request)
    {
        $payments = CountryPaymentMethod::join('payment_methods', 'payment_methods.id','=', 'country_payment_methods.payment_method_id')
            ->where('country_payment_methods.country', $request->country)
            ->select('*')
            ->get();
        $response = ['success' => true, 'data' => $payments, 'message'=>__('Payment methods get using country code')];
        return response()->json($response);

    }

}
