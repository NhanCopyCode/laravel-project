<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarRentalStoreRequest extends FormRequest
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
            'province' => 'required',
            'ward' => 'required',
            'district' => 'required',
            'province_id' => 'required|not_in:0',
            'ward_id' => 'required|not_in:0',
            'district_id' => 'required|not_in:0',
            'unique_location' => 'required',
            'phone_number' => 'required|min:10|max:11',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            'branch_id' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được bỏ trống',
            'phone_number.digits' => ':attribute phải chứa đúng :digits chữ số',
            'avatar.max' => ':attribute có dung lượng tối đa là :max kilobytes.',
            'avatar.required' => ':attribute không được bỏ trống',
            'avatar.mimes' => ':attribute phải là một trong các kiểu file sau: :values.',
            'province_id.not_in' => ':attribute không được bỏ trống',
            'ward_id.not_in' => ':attribute không được bỏ trống',
            'district_id.not_in' => ':attribute không được bỏ trống'
        ];
    }

    public function attributes()
    {
        return [
            'province' => 'Tỉnh/Thành phố',
            'district' => 'Quận/huyện',
            'ward' => 'Phường/xã',
            'province_id' => 'Tỉnh/Thành Phố',
            'district_id' => 'Quận/Huyện',
            'ward_id' => 'Phường/Xã',
            'unique_location' => 'Địa chỉ',
            'phone_number' => 'Số điện thoại',
            'avatar' => 'Ảnh cửa hàng',
            'description' => 'Mô tả',
            'branch_id' => 'Chi nhánh',
            // Các thuộc tính khác...
        ];
    }
}
