<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApproveCashoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'release_date' => 'required|date'
        ];
    }
}
