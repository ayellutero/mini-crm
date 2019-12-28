<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
        $rules = [
            'first_name' => ['required_without:file_import', 'max:250'],
            'last_name' => ['required_without:file_import', 'max:250'],
            'email' => ['required_without:file_import'],
            'file_import' => ['sometimes', 'file', 'employees_import' ]
        ];

        // if the user attached a file for reading
        if (!isset($this->file_import)) {
            // add 'email' validation rule to email field
            array_push($rules['email'], 'email');
        }
        
        return $rules;
    }

    public function attributes()
    {
        return [
            'file_import' => 'spreadsheet file',
        ];
    }

    public function messages()
    {
        return [
            'employees_import' => 'The :attribute must be of file type: xlsx or csv.'
        ];
    }
}
