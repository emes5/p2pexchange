<?php

namespace App\Http\Controllers\admin;

use App\Model\PaymentWindow;
use App\Services\Logger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PaymentWindowController extends Controller
{
    private $logger;
    function __construct()
    {
        $this->logger = new Logger();
    }
    // adminPaymentWindowList List
    public function adminPaymentWindowList()
    {
        $data['title'] = __('Payment Window');
        $data['items'] = PaymentWindow::orderBy('id', 'desc')->get();

        return view('admin.settings.payment_window.list', $data);
    }

    // View Add new payment window page
    public function adminPaymentWindowAdd()
    {
        $data['title']=__('Add Payment Time');
        return view('admin.settings.payment_window.addEdit',$data);
    }

    // Create New payment window
    public function adminPaymentWindowSave(Request $request)
    {
        $rules = [
            'payment_time' => ['required','integer','gt:0',Rule::unique('payment_windows')->ignore($request->edit_id, 'id')],
            'status' => 'required',
        ];

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            return redirect()->back()->withInput()->with(['dismiss' => $errors[0]]);
        }
        try {
            $data=[
                'payment_time' => $request->payment_time
                ,'status' => $request->status
            ];

            if(!empty($request->edit_id)){
                PaymentWindow::where(['id'=>$request->edit_id])->update($data);
                return redirect()->route('adminPaymentWindowList')->with(['success'=>__('Payment Time Updated Successfully!')]);
            }else{
                PaymentWindow::create($data);
                return redirect()->route('adminPaymentWindowList')->with(['success'=>__('Payment Time Added Successfully!')]);
            }
        } catch (\Exception $e) {
            $this->logger->log('adminPaymentWindowSave', $e->getMessage());
            return redirect()->back()->with(['dismiss'=>__('Something went wrong')]);

        }
    }

    // Edit payment window
    public function adminPaymentWindowEdit($id)
    {
        $data['title'] = __('Update Payment Time');
        $data['item'] = PaymentWindow::where('id', $id)->first();

        return view('admin.settings.payment_window.addEdit',$data);
    }

    // Delete payment window
    public function adminPaymentWindowDelete($id)
    {
        if(isset($id)){
            $item = PaymentWindow::where(['id'=>$id])->first();
            if (empty($item)) {
                return redirect()->back()->with(['dismiss' => __('Data not found')]);
            }
            PaymentWindow::where(['id'=>$id])->delete();
        }

        return redirect()->back()->with(['success'=>__('Deleted Successfully!')]);
    }
}
