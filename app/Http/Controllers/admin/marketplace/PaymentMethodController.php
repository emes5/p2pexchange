<?php

namespace App\Http\Controllers\admin\marketplace;

use App\Http\Requests\Admin\PaymentMethodRequest;
use App\Http\Services\CommonService;
use App\Model\CountryPaymentMethod;
use App\Model\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentMethodController extends Controller
{
    /*
    *
    * payment method List
    * Show the list of specified resource.
    * @return \Illuminate\Http\Response
    *
    */
    public function paymentMethodList()
    {
        $data['title'] = __('Payment Method List');
        $data['items'] = PaymentMethod::orderBy('id', 'desc')->get();

        return view('admin.marketplace.payment.list', $data);
    }

    /*
     * addPaymentMethod
     *
     *
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     *
     *
     *
     */

    public function addPaymentMethod()
    {
        $data['title'] = __('Add new payment method');

        return view('admin.marketplace.payment.addEdit', $data);
    }

    /**
     * editPaymentMethod
     *
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editPaymentMethod($id)
    {
        $data['title'] = __('Update Payment Method');

        $data['item'] = PaymentMethod::where('unique_code',$id)->first();
        if(isset($data['item'])) {
            $data['selected_country'] = CountryPaymentMethod::where('payment_method_id',$data['item']->id)->pluck('country')->toArray();

            return view('admin.marketplace.payment.addEdit', $data);
        } else {
            return redirect()->back()->with(['dismiss' => __('Data not found.')]);
        }

    }

    /**
     * paymentMethodSave
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function paymentMethodSave(PaymentMethodRequest $request)
    {
        try {
            if ($request->isMethod('post')) {
                $response = app(CommonService::class)->paymentMethodSaveProcess($request);
                if ($response['success'] == true) {
                    return redirect()->route('paymentMethodList')->with('success', $response['message']);
                }

                return redirect()->back()->withInput()->with('dismiss', $response['message']);
            }
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('dismiss', __("Something went wrong"));
        }
    }

    // change payment method status
    public function paymentMethodStatusChange(Request $request)
    {
        $response = [
            'success' => false,
            'message' => __("Something went wrong"),
        ];
        if(isset($request->active_id)) {
            $item = PaymentMethod::find($request->active_id);
            if($item) {
                if($item->status == STATUS_ACTIVE) {
                    $item->update(['status' => STATUS_DEACTIVE]);
                } else {
                    $item->update(['status' => STATUS_ACTIVE]);
                }
                $response = [
                    'success' => true,
                    'message' => __("Status changed"),
                ];
            }
        }
        return response()->json($response);
    }
}
