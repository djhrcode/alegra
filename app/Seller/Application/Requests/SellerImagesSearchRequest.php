<?php

namespace App\Seller\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerImagesSearchRequest extends FormRequest
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
            'query' => 'required|string|max:255'
        ];
    }
}
