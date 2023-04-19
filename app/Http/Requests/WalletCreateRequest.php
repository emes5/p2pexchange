<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WalletCreateRequest extends FormRequest
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
            'wallet_name' => 'required|max:100',
            'coin_type' => 'required|exists:coins,type'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
          'wallet_name.required' => __('Wallet name is required'),
          'coin_type.required' => __('Coin type is required'),
          'coin_type.exists' => __('Invalid coin type'),
        ];
    }
}
