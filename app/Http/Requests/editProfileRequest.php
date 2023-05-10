<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class editProfileRequest extends FormRequest
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
            'email' => 'require',
            'phone'=>'required|min:10',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => "The Name Can't  be null",
            'name.regex' => "Please enter only character",
            'phone.required' => " The Phone Can't  be null",
            'email' =>"Email is Required"
        ];
    }
}
