<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUser extends FormRequest
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
            'first_name' => ['required', 'string', 'max:80'],
            'last_name' => ['required', 'string', 'max:80'],
            'username' => ['required', 'string','max:255', 'unique:users'],
            'country' => ['required','in:'.implode(',',array_keys(countrylist()))],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' =>[
                'required',
                'min:8',             // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
            ],
            'password_confirmation' => 'required|min:8|same:password',
        ];
        if (isset(allsetting()['google_recapcha']) && (allsetting()['google_recapcha'] == STATUS_ACTIVE)) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }
        return $rules;
    }

    public function messages()
    {
        return  [
            'first_name' => __('First name can not be empty'),
            'last_name' => __('Last name can not be empty'),
            'username.required' => __('Username can not be empty'),
            'password.required' => __('Password field can not be empty'),
            'password_confirmation.required' => __('Confirm Password field can not be empty'),
            'password.min' => __('Password length must be at least 8 characters.'),
            'password.regex' => __('Password must be consist of one uppercase, one lowercase and one number.'),
            'password.strong_pass' => __('Password must be consist of one uppercase, one lowercase and one number.'),
            'password_confirmation.min' => __('Confirm Password length must be at least 8 characters.'),
            'password_confirmation.same' => __("Password and confirm password doesn't match"),
            'email.required' => __('Email field can not be empty'),
            'email.unique' => __('Email Address already exists'),
            'email.email' => __('Invalid email address')
        ];
    }
}
