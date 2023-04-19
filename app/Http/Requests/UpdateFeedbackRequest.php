<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeedbackRequest extends FormRequest
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
            'order_id' => 'required|exists:orders,id',
            'type' => 'required|in:seller,buyer'
        ];
        if($this->type == 'seller') {
            $rules['seller_feedback'] = 'required|integer';
        }
        if($this->type == 'buyer') {
            $rules['buyer_feedback'] = 'required|integer';
        }

        return $rules;
    }
}
