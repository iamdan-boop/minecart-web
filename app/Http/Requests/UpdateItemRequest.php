<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'handling_fee' => 'required|numeric',
            'shelf_location' => 'required|string',
            'note' => 'required|string',
            'sellers_price' => 'nullable|sometimes|numeric',
            'shelf_life_till' => 'required|date'
        ];
    }
}
