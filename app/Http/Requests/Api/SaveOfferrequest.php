<?php

namespace App\Http\Requests\Api;

use App\Model\Coin;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class SaveOfferrequest extends FormRequest
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
        $rule = [
            'offer_type' => 'required|in:1,2',
            'coin_type' => 'required|exists:coins,type',
            'country' => 'required',
            'payment_methods' => 'required',
            'currency' => 'required',
            'rate_type' => 'required|in:1,2',
        ];

        if ($this->rate_type == RATE_TYPE_DYNAMIC) {
            $rule['price_type'] = 'required|in:1,2';
            $rule['rate_percentage'] = 'required|numeric|min:0.0001|max:100';
        } else {
            $rule['coin_rate'] = 'required|numeric|min:0.00000001';
        }
        if($this->coin_type) {
            $coin = Coin::where('type', $this->coin_type)->first();
            $rule['minimum_trade_size'] = 'required|integer|min:'.$coin->minimum_trade_size;
            $rule['maximum_trade_size'] = 'required|integer|max:'.$coin->maximum_trade_size;
            if($this->coin_type == DEFAULT_COIN_TYPE && $this->rate_type == RATE_TYPE_DYNAMIC) {
                $rule['rate_type'] = 'required|in:2';
            }
        }
        $rule['headline'] = 'required';

        return $rule;
    }

    public function messages()
    {
        $message = [
            'offer_type.required' => __('Please select a trade type Buy or Sell'),
            'coin_type.required' => __('Please select a coin type'),
            'country.required' => __('Please select a country'),
            'payment_methods.required' => __('Please select at least one payment method'),
            'currency.required' => __('Please select a currency'),
            'rate_type.required' => __('Please select coin rate type, dynamic or static'),
            'price_type.required' => __('Please select percentage type above or below'),
            'rate_percentage.required' => __('Percentage is required'),
            'market_price.required' => __('Static market price is required'),
        ];
        if($this->coin_type == DEFAULT_COIN_TYPE && $this->rate_type == RATE_TYPE_DYNAMIC) {
            $message['rate_type'] = __('For the ').settings('coin_name').__(' coin , only you can select static rate type');
        }

        return $message;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->header('accept') == "application/json") {
            $errors = [];
            if ($validator->fails()) {
                $e = $validator->errors()->all();
                foreach ($e as $error) {
                    $errors[] = $error;
                }
            }
            $json = [
                'success'=>false,
                'data'=>null,
                'message' => $errors[0],
            ];
            $response = new JsonResponse($json, 200);

            throw (new ValidationException($validator, $response))->errorBag($this->errorBag)->redirectTo($this->getRedirectUrl());
        } else {
            throw (new ValidationException($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }

    }
}
