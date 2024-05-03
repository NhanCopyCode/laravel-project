<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingVehicleRequest extends FormRequest
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
            'payment_method_id' => 'required|exists:paymentmethod,payment_method_id',
            'booking_start_date' => 'required|date|before_or_equal:booking_end_date',
            'booking_end_date' => 'required|date|after_or_equal:booking_start_date'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được bỏ trống',
            'payment_method.min' => 'Phương thức thanh toán không hợp lệ',
            'payment_method.max' => 'Phương thức thanh toán không hợp lệ',
            'date' => ':attribute không hợp lệ',
            'booking_start_date.before_or_equal' => 'Ngày bắt đầu phải trước hoặc cùng ngày với ngày kết thúc.',
            'booking_end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc cùng ngày với ngày bắt đầu.',
            'exists' => ':attribute không tồn tại',
        ];
    }

    public function attributes()
    {
        return [
            'payment_method' => 'Phương thức thanh toán',
            'booking_start_date' => 'Ngày bắt đầu',
            'booking_end_date' => 'Ngày kết thúc',
        ];
    }
}
