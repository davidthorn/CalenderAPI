<?php

namespace App\Http\Requests;

class UpdateCalenderEntry extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'start' => 'sometimes|date',
             'finish' => 'sometimes|date',
             'subject' => 'sometimes|string|min:1|max:254',
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
