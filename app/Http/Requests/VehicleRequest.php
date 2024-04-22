<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
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
            'CarRentalStore_id' => 'required|min:0',
            'model_id' => 'required|min:0',
            'vehicle_description' => 'required|string',
            'license_plate' => 'required|string|regex:/^\d{2}[A-Z]{1,2}-\d{3}\.\d{1,2}$/',
            'rental_price_day' => 'required|integer|min:0',
            'vehicle_status_id' => 'required|integer|exists:vehiclestatus,vehicle_status_id',
            'vehicle_image_name' => 'required|array|size:3',
            'vehicle_image_name.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được bỏ trống',
            'min' => ':attribute không được nhỏ hơn :min',
            'integer' => ':attribute phải là số',
            'regex' => ':attribute không hợp lệ',
            'size' => ':attribute phải đủ 3 ảnh',
        ];
    }

    public function attributes()
    {
        return [
            'CarRentalStore_id' => 'Cửa hàng',
            'model_id' => 'Mẫu xe',
            'vehicle_description' => 'Thông tin chi tiết xe',
            'license_plate' => 'Biển số xe',
            'rental_price_day' => 'Số tiền thuê',
            'vehicle_status_id' => 'Trạng thái xe',
            'vehicle_image_name' => 'Hình ảnh xe',
        ];
    }
}
