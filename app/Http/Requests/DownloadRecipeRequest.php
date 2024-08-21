<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DownloadRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required|',
            'email' => 'required',
            'date_of_birth' => 'required',
            'city' => 'required|',
            'phone' => 'required',
            'cid' => 'required',
            'type_of_signup' => 'sometimes',
            'overall_opt_in_status' => 'required',
            'tnc' => 'required',
            'hutk' => 'required',
            'latitude' => 'sometimes',
            'longitude' => 'sometimes',
            'page' => 'required',
            'page_url' => 'required',
        ];
    }
}
