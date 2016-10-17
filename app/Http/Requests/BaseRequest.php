<?php

namespace App\Http\Requests;

// Laravel FormRequest
// use Illuminate\Foundation\Http\FormRequest;

// Dingo API FormRequest
use Dingo\Api\Http\FormRequest;

class BaseRequest extends FormRequest
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
}
