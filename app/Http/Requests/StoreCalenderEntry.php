<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCalenderEntry extends FormRequest
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
             'start' => 'required|date', 
             'finish' => 'required|date', 
             'subject' => 'required|string|min:1|max:254',
        ];
    }

    public function messages()
    {
        return [
             'start.required' => 'This field is required', 
             'start.date' => 'This is not a ', 
             'subject' => 'required|string|min:1|max:254',
        ];
    }
}
