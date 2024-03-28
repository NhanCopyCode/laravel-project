<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class OwnerRequest extends FormRequest
{
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
            'email' => [
                'required',
                'email',
                // Rule::exists('users')->where(function ($query) {
                //     $query->where('role_id', 2);
                // }),
                'exists:users'
            ],
            'password' => 'required',
        ];
    }

    public function messages() 
    {
        return [
            'required' => ':attribute không được để trống',
            'email' => ':attribute không hợp lệ',
            'exists' => ':attribute này chưa được đăng kí',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên',
            'email' => 'Email',
            'password' => 'Mật khẩu'
        ];
    }

}
