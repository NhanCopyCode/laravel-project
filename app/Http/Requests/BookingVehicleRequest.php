<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Models\Rental;
use Illuminate\Http\Request;
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
    public function rules(Request $request): array
    {
        return [
            'booking_total_price' => 'required',
            'vehicle_id' => 'required|exists:vehicles,vehicle_id',
            // 'payment_method_id' => 'required|exists:paymentmethod,payment_method_id',
            'booking_daterange' => [
                'required',
                function ($attribute, $value, $fail) use ($request) { // Thêm $request vào use
                    // Phân tích $value để lấy ngày bắt đầu và kết thúc
                    [$start_date, $end_date] = explode(' - ', $value);
                    
                    // Định dạng lại ngày tháng cho đúng với dữ liệu nhận được
                    $start_date = Carbon::createFromFormat('Y-m-d', trim($start_date))->format('Y-m-d');
                    $end_date = Carbon::createFromFormat('Y-m-d', trim($end_date))->format('Y-m-d');
                    if($start_date === $end_date) {
                        $end_date = Carbon::createFromFormat('Y-m-d', trim($end_date))->addDay()->format('Y-m-d');
                        
                    }

                    // dd($start_date, $end_date);
                    
                    // Thực hiện truy vấn để kiểm tra xem khoảng thời gian đã tồn tại trong DB hay chưa
                    $exists = DB::select("
                        SELECT *
                        FROM rental
                        WHERE vehicle_id = ?
                        AND (
                            (rental_start_date BETWEEN ? AND ?)
                            OR (rental_end_date BETWEEN ? AND ?)
                        )
                        AND rental_status_id IN (1, 4)
                    ", [$request->vehicle_id, $start_date, $end_date, $start_date, $end_date]);
                        // $sql = $exists->toSql();
                        // $bindings = $exists->getBindings();
                        // dd($sql, $bindings);
                    // Nếu tồn tại, trả về lỗi
                    // dd($exists);
                    if (count($exists) > 0) {
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
            'booking_total_price.required' => 'Cần chọn ngày thuê xe',
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
