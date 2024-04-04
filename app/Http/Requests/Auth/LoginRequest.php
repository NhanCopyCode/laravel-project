<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ];
    }

    public function messages() 
    {
        return [
            'required' => ':attribute không được để trống',
            'email' => ':attribute không hợp lệ',
            'exists' => ':attribute chưa được đăng kí',
        ];
    }

    public function attributes()
    {
        return [
            // 'name' => 'Tên',
            'email' => 'Email',
            'password' => 'Mật khẩu'
        ];
    }

    
}
