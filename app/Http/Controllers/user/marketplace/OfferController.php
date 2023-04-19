<?php

namespace App\Http\Controllers\user\marketplace;

use App\Http\Requests\AddOfferRequest;
use App\Http\Services\CommonService;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class OfferController extends Controller
{
    /**
     * Initialize offer service
     *
     * offer controller constructor.
     */
    public function __construct()
    {
        $this->offerRepo = new OfferRepository;
    }

    /**
   *
   * offer List
   * Show the list of specified resource.
   * @return \Illuminate\Http\Response
   *
   */
    public function myOffer()
    {
        $data['title'] = __('My Offer List');
        $data['buys'] = Buy::where(['user_id' => Auth::id()])->orderBy('id', 'DESC')->paginate(20);
        $data['sells'] = Sell::where(['user_id' => Auth::id()])->orderBy('id', 'DESC')->paginate(20);

        return view('user.marketplace.offer.offer_list', $data);

    }

    /**
     * createOffer
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */
    public function createOffer()
    {
        $data['title'] = __('Create Offer');
        $data['coins'] = Coin::where('status', STATUS_ACTIVE)->orderBy('id', 'ASC')->get();
        $data['countries'] = countrylist();
        $data['currencies'] = currency_symbol_text();
        $data['payment_methods'] = PaymentMethod::where('status', STATUS_ACTIVE)->orderBy('id','Desc')->get();

        return view('user.marketplace.offer.add_offer', $data);
    }

    /**
     * createOffer
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */
    public function editOffer($id,$type)
    {
        $data['title'] = __('Edit Offer');
        $data['coins'] = Coin::where('status', STATUS_ACTIVE)->orderBy('id', 'ASC')->get();
        $data['countries'] = countrylist();
        $data['currencies'] = currency_symbol_text();
        $data['payment_methods'] = PaymentMethod::where('status', STATUS_ACTIVE)->orderBy('id','Desc')->get();

        if ($type == BUY) {
            $offer = Buy::where(['unique_code' => $id, 'user_id' => Auth::id()])->first();
        } else {
            $offer = Sell::where(['unique_code' => $id, 'user_id' => Auth::id()])->first();
        }
        if(isset($offer)) {
            $data['offer_type'] = $type;
            $data['item'] = $offer;
            $data['selected_payments'] = OfferPaymentMethod::where('offer_id', $offer->id)->pluck('payment_method_id')->toArray();

            return view('user.marketplace.offer.edit_offer', $data);
        } else {
            return redirect()->back()->with(['dismiss' => __('Offer not found.')]);
        }
    }

    /**
     * deactiveOffer
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */
    public function deactiveOffer($id,$type)
    {
        $response = $this->offerRepo->activeDeactiveOffer($id,$type,STATUS_DEACTIVE);
        if ($response['success'] == true) {
            return redirect()->back()->with('success', $response['message']);
        }

        return redirect()->back()->withInput()->with('dismiss', $response['message']);

    }
    public function activateOffer($id,$type)
    {
        $response = $this->offerRepo->activeDeactiveOffer($id,$type,STATUS_ACTIVE);
        if ($response['success'] == true) {
            return redirect()->back()->with('success', $response['message']);
        }

        return redirect()->back()->withInput()->with('dismiss', $response['message']);

    }

    /**
     * offerSaveProcess
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function offerSaveProcess(AddOfferRequest $request)
    {
        $response = $this->offerRepo->saveOffer($request);
        if ($response['success'] == true) {
            return redirect()->route('myOffer')->with('success', $response['message']);
        }

        return redirect()->back()->withInput()->with('dismiss', $response['message']);
    }

    // get country payment method
    public function getCountryPaymentMethod(Request $request)
    {
        if($request->country == 'any'){
            $payments = CountryPaymentMethod::join('payment_methods', 'payment_methods.id','=', 'country_payment_methods.payment_method_id')
                ->where(['payment_methods.status' => STATUS_ACTIVE])
                ->select('*')
                ->groupBy('country_payment_methods.payment_method_id')
                ->get();
        } else {
            $payments = CountryPaymentMethod::join('payment_methods', 'payment_methods.id','=', 'country_payment_methods.payment_method_id')
                ->where(['country_payment_methods.country' => $request->country, 'payment_methods.status' => STATUS_ACTIVE])
                ->select('*')
                ->get();
        }


        $html = '';
        $data['payment_methods'] = $payments;
        $html .= View::make('user.marketplace.offer.country_payment_method',$data);

        return response()->json(['data' => $html]);

    }
}
