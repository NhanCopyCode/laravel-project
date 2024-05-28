<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class UserManagementRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:role',
            'name' => "required",
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'role_id' => 'Vai trò',
            'name' => 'Tên người dùng',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute yêu cầu không được để trống',
            'email' => ':attribute phải đúng định dạng email',
            'exists' => ':attribute đã tồn tại trong hệ thống, vui lòng nhập email khác',
            'min' => ':attribute tối thiểu phải có :min ký tự',
            'unique' => ':attribute đã tồn tại trong hệ thống',
            
        ];
    }
}
