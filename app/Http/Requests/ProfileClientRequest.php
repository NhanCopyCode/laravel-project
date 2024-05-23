<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileClientRequest extends FormRequest
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
        $user = Auth::guard('web')->user();
        $user_id  = $user->user_id;
        return [
            //
            'avatar' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user_id, 'user_id')],
            'phone_number' => ['required', 'numeric', 'digits_between:10,15'],
            'CCCD' => ['required','string', 'size: 12', Rule::unique('users')->ignore($user_id, 'user_id')],
            'date_of_birth' => ['required', 'date', 'before:today'],
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được bỏ trống',
            'string' => ':attribute không được chứa số',
            'max' => ':attribute không được vượt quá :max',
            'email' => ':attribute không đúng định dạng',
            'numeric' => ':attribute không được chứa chữ',
            'size' => ':attribute phải đủ :size ký tự',
            'unique' => ':attribute đã tồn tại',
            'digits_between' => ':attribute phải có từ :min đến :max chữ số',
            'date' => ':attribute không đúng định dạng',
            'before' => ':attribute phải là ngày trước ngày hôm nay',
            'image' => ':attribute phải là hình ảnh',
            'mimes' => ':attribute phải là một trong các định dạng sau: :values',
            'max.uploaded'=>':attribute không được vượt quá :max kB',
        ];
    }

    public function attributes()
    {
        return [
            'avatar' => 'Ảnh đại diện',
            'name' => 'Tên người dùng',
            'email' => "Email",
            'phone_number' => 'Số điện thoại',
            'CCCD' => 'Căn cước công dân',
            'date_of_birth' => 'Ngày sinh'
        ];
    }
}
