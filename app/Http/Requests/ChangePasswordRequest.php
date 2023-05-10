<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
                'oldPassword' => 'required',
                'newPassword' => 'required|same:newConfirmPassword',
                'newConfirmPassword'=>'required|same:newPassword'
        ];
    }
    public function messages()
    {
        return [
            'oldPassword.required' => "The Old Password is Required",
            'newPassword.required' => "The Password is Required",
            'newConfirmPassword.required' => " The Confirm Password is Required",
            'newPassword.same' => " The Password Confirmpassword must be same",
            'newConfirmPassword.same' => " The Password Confirmpassword must be same",
        ];
    }
}
