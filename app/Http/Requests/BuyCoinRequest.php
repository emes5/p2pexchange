<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyCoinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'payment_type' => ['required'],
            'coin' => ['required', 'numeric'],
        ];
        if ($this->payment_type == BTC){
//            $rules['btc_address'] =  ['required'];
        }
        if ($this->payment_type == CARD){
            $rules['payment_method_nonce'] =  ['required'];
        }

        if ($this->payment_type == BANK_DEPOSIT){

            $rules['sleep'] =  ['required','mimes:jpeg,jpg,png,gif|required|max:10000'];
            $rules['bank_id'] =  'required|integer';
        }

        return $rules;
    }
    public function messages()
    {
        $data['payment_type.required'] = __('Select your payment method');
        $data['bank_id.required'] = __('Must be select a bank');
        $data['sleep.required'] = __('Bank document is required');
        $data['payment_method_nonce.required'] = __('Invalid card ID or CVV');


        return $data;
    }
}
