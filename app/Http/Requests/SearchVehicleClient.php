<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchVehicleClient extends FormRequest
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
            'location_id' => 'required|integer',
            // 'before_or_equal:end-date' cho phép start-date nhỏ hơn hoặc bằng end-date
            'start_date' => 'required|date|before_or_equal:end_date',
            // 'after_or_equal:start-date' cho phép end-date lớn hơn hoặc bằng start-date
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }

    public function messages()
    {
        return [
            'required' => ":attribute không được để trống",
            'integer' => ':attribute không hợp lệ',
            'before' => ":attribute phải bé hơn ngày kết thúc",
            'after' => ":attribute phải lớn hơn ngày bắt đầu thúc",
        ];
    }

    public function attributes()
    {
        return [
            'location_id' => 'Địa điểm',
            'start_date' => 'Ngày bắt đầu',
            'end_date' => 'Ngày kết thúc'
        ];
    }
}
