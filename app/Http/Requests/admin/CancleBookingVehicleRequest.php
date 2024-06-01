<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class CancleBookingVehicleRequest extends FormRequest
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
            'rental_id' => 'required|exists:rental,rental_id',
            'reason' =>'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'exists' => ':attribute không tại trong hệ thống',
            
        ];
    }

    public function attributes()
    {
        return [
            'reason' => 'Lý do',
            'rental_id' => 'Giao dịch thuê xe',
        ];
    }
}
