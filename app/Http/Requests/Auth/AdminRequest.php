<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                Rule::exists('users')->where(function ($query) {
                    $query->where('role_id', 2)
                    ->orWhere('role_id', 3);
                }),
            ],
            'password' => 'required|min:3',
        ];
    }

    public function messages() 
    {
        return [
            'required' => ':attribute không được để trống',
            'email' => ':attribute không hợp lệ',
            'exists' => ':attribute này chưa được đăng kí',
            'min' => ':attribute tối thiểu :min ký tự',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'password' => 'Mật khẩu'
        ];
    }
}
