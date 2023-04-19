<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
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
        return [
            'type' => 'required',
            'offer_id' => 'required',
            'price' => 'required|numeric',
            'amount' => 'required|numeric',
            'payment_id' => 'required',
            'text_message' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'price.required' => __('Currency price is required'),
            'amount.required' => __('Coin type amount is required'),
            'payment_id.required' => __('Please select a payment method'),
            'text_message.required' => __('Message field is required'),
        ];
    }
}
