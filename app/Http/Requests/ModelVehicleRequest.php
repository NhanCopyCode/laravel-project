<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModelVehicleRequest extends FormRequest
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
            'model_name' => 'required',
            'engine_type' => 'required|integer|min:1',
            'color' => 'required',
            'year_of_production' => 'required|integer|min:1900|max: '.date('Y'),
            'brand_id' => 'required|integer|min:1',
            // 'model_status_id' => 'required|integer|min:1',
        ];
    }

    public function messages() {
        return [
            'required' => ':attribute không được để trống',
            'integer' => ':attribute phải là số nguyên',
            'min' => ':attribute không được bé hơn :min',
            'max' => ':attribute không được lớn hơn :max'
        ];
    }

    public function attributes()
    {
        return [
            'model_name' => 'Mẫu xe',
            'engine_type' => 'Dung tích động cơ',
            'color' => 'Màu sắc',
            'year_of_production' => 'Năm sản xuất',
            'brand_id' => 'Hãng xe',
        ];
    }
}
