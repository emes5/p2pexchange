<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
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
        $rules =  [
            'name' =>'required',
            'country' =>'required',
            'status' =>'required',
        ];
        if($this->image) {
//            $rules['image'] = 'mimes:jpeg,png,jpg|max:2048';
        }

        return $rules;
    }
}
