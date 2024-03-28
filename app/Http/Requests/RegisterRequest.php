<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required'
                , 'string'
                , 'min:6', 
            ],
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ];
    }
    
    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'unique' => ':attribute đã được đăng kí',
            'string' => ':attribute chỉ được nhập chữ cái',
            'email' => ':attribute không hợp lệ',
            'min' => ':attribute không được ít hơn :min kí tự',
            'confirmed' => ':attribute nhập lại không trùng nhau'
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
