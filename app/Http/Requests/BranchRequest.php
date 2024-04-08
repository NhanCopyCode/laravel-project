<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
            //
            'branch_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute yêu cầu không để trống'
        ];
    }

    public function attributes()
    {
        return [
            'branch_name' => 'Tên chi nhánh'
        ];
    }
}
