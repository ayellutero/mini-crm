<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;//User::where('id', \Auth::id())->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:250',
            'email' => 'nullable|email',
            'logo' => 'image|mimes:jpeg,png,jpg|dimensions:min_width=100,min_height=100|max:2000'
        ];
    }

    public function messages()
    {
        return [
            'logo.*' => 'The logo must be an image (jpeg, png, jpg). Logo must be at least 100x100 and may not be greater than 2 MB.'
        ];
    }
}
