<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
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
            'campaign_name' => 'required|regex:(^([a-zA-z]))',
            'cost_per_lead'=>'required|numeric',
            'conversion_cost'=>'required|numeric',
            // 'telecaller_id'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'campaign_name.required' => "The Campaign name Can't  be null",
            'campaign_name.regex' => "Please enter only character",
            'cost_per_lead.required' => "The Cost per lead  Can't  be null",
            'cost_per_lead.numeric' => "Please enter only number",
            'conversion_cost.required' => "The conversion cost  Can't  be null",
            'conversion_cost.numeric' => "Please enter only number",
        ];
    }
}
