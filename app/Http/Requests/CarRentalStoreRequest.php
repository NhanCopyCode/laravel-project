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
            'province' => 'required|min:1',
            'ward' => 'required|min:1',
            'district' => 'required|min:1',
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
            'avatar.mimes' => ':attribute phải là một trong các kiểu file sau: :values.',
        ];
    }

    public function attributes()
    {
        return [
            'province' => 'Tỉnh',
            'district' => 'Quận/huyện',
            'ward' => 'Phường/xã',
            'unique_location' => 'Địa chỉ',
            'phone_number' => 'Số điện thoại',
            'avatar' => 'Ảnh đại diện',
            'description' => 'Mô tả',
            'branch_id' => 'Chi nhánh',
            // Các thuộc tính khác...
        ];
    }
}
