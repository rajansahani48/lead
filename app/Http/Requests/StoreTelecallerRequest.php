<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTelecallerRequest extends FormRequest
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
            'name' => 'required|max:50|regex:(^([a-zA-z]))',
            'email' => 'required|unique:users,email,NULL,id,deleted_at,NULL',
            'phone'=>'required|min:10',
            'password'=>'required|same:confirmpassword',
            'confirmpassword'=>'required|same:password'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => "The Name Can't  be null",
            'name.regex' => "Please enter only character",
            'email.required' => "The Email Can't  be null",
            'email.unique' => " User Already Exists",
            'phone.required' => " The Phone Can't  be null",
            'password.required' => " The Password Can't  be null",
            'password.same' => " The Password Confirmpassword must be same",
            'confirmpassword.required' => " The Password Can't  be null",
            'confirmpassword.same' => " The Password Confirmpassword must be same",
        ];
    }
}
