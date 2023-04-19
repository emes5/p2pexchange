<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportUserRequest extends FormRequest
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
            'order_id' => 'required',
            'type' => 'required',
            'reason' => 'required',
        ];
        if($this->attach_file) {
            $rule['attach_file'] = 'mimes:jpeg,png,jpg|max:2048';
        }

        return $rule;
    }
}
