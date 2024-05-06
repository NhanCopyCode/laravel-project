<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Models\Rental;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;

class BookingVehicleRequest extends FormRequest
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
            'payment_method_id' => 'required|exists:paymentmethod,payment_method_id',
            'booking_daterange' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Phân tích $value để lấy ngày bắt đầu và kết thúc
                    [$start_date, $end_date] = explode(' - ', $value);
                    
                    // Định dạng lại ngày tháng cho đúng với dữ liệu nhận được
                    $start_date = Carbon::createFromFormat('Y-m-d', trim($start_date))->format('Y-m-d');
                    $end_date = Carbon::createFromFormat('Y-m-d', trim($end_date))->format('Y-m-d');
                    
                    // Thực hiện truy vấn để kiểm tra xem khoảng thời gian đã tồn tại trong DB hay chưa
                    $exists = DB::table('rental') // Thay 'rental' bằng tên bảng đúng của bạn
                                ->where(function($query) use ($start_date, $end_date) {
                                    $query->whereBetween('rental_start_date',[$start_date, $end_date])
                                          ->whereBetween('rental_end_date',[$start_date, $end_date]);
                                })
                                ->get();
    
                    // Nếu tồn tại, trả về lỗi
                    if (!$exists->isEmpty()) {
                        $fail('Xe đã được đặt trong thời gian này!!');
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được bỏ trống',
            'payment_method_id.exists' => 'Phương thức thanh toán không hợp lệ',
            
        ];
    }

    public function attributes()
    {
        return [
            'payment_method' => 'Phương thức thanh toán',
            'booking_daterange' => 'Thời gian đặt xe',
        ];
    }
}
