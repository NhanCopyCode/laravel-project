<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name_register' => ['required'
            , 'string'
            , 'min:6', 
        ],
            'email_register' => 'required|email|unique:users',
            'password_register' => 'required|min:6',
        ];
    }

    public function messages() 
    {
        return [
            'required' => ':attribute không được để trống',
            'string' => ':attribute chỉ được nhập chữ cái',
            'email' => ':attribute không hợp lệ',
            'min' => ':attribute không được ít hơn :min kí tự'
        ];
    }

    public function attributes()
    {
        return [
            'name_register' => 'Tên',
            'email_register' => 'Email',
            'password_register' => 'Mật khẩu'
        ];
    }
}
