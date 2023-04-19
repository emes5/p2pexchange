<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserProfileUpdate extends FormRequest
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
        $user = (!empty($this->id)) ? User::find(decrypt($this->id)) : Auth::user();
        $rule = [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'username' => ['required','max:255',
                Rule::unique('users')->ignore($user->id, 'id')
            ],
            'email' => ['required','email','max:233',
                Rule::unique('users')->ignore($user->id, 'id')
            ],
            'phone' => ['required','numeric',
                Rule::unique('users')->ignore($user->id, 'id')
            ],
            'country' => ['required','in:'.implode(',',array_keys(countrylist()))]
        ];
        if (Auth::user()->role == USER_ROLE_USER) {
            if (isset(allsetting()['google_recapcha']) && (allsetting()['google_recapcha'] == STATUS_ACTIVE)) {
                $rule['g-recaptcha-response'] = 'required|captcha';
            }
            $rule['gender'] = ['required'];
        }


        return $rule;
    }

    public function messages()
    {
        return  [
            'email' => __('Email can not be empty'),
            'first_name' => __('First name can not be empty'),
            'username' => __('Username can not be empty'),
            'phone.required' => __('Phone number can not be empty'),
            'country.required' => __('Country can not be empty'),
            'phone.numeric' => __('Please enter a valid phone number'),
            'last_name' => __('Last name can not be empty'),
            'gender' => __('Gender can not be empty')
            ];
    }
}
