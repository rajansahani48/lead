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
            'name' => 'required|max:50',
            // 'email' => 'required|unique:users,email,NULL,id,deleted_at,NULL',
            'email' => 'required|email',
            'phone'=>'required|min:10',
            'password'=>'required|same:confirmpassword|min:8',
            'confirmpassword'=>'required|same:password|min:8',
            'address'=>'max:200'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => "The Name Can't  be null",
            'email.required' => "The Email Can't  be null",
            // 'email.unique' => " User Already Exists",
            'phone.required' => " The Phone Can't  be null",
            'address.max' =>"You Can't enter more than 200 character",
            'password.required' => " The Password Can't  be null",
            'password.same' => " The Password Confirmpassword must be same",
            'confirmpassword.required' => " The Password Can't  be null",
            'confirmpassword.same' => " The Password Confirmpassword must be same",
        ];
    }
}
