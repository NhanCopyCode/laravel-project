<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'brand_name' => 'required|unique:brands,brand_name,' . $this->brand . ',brand_id',
        ];
    }

    public function messages()
    {
        return [
            'required' => ":attribute không được bỏ trống",
            'unique' => ":attribute đã tồn tại"
        ];
    }

    public function attributes()
    {
        return [
            'brand_name' => 'Hãng xe',
        ];
    }
}
