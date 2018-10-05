<?php

namespace App\Http\Requests\Customers;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AddVisitorsRequest
 * @package App\Http\Requests\Customers
 */
class AddVisitorsRequest extends FormRequest
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
            'data'  => 'required|array',
            'data.*' => 'required|array',
            'data.*.name'  => 'required|string|max:64|min:1',
            'data.*.phone' => 'required|string|max:16|min:10|unique:visitors,phone',
        ];
    }
}
