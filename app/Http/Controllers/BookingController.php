<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BookingVehicleRequest;
use App\Models\Payment;
use App\Models\Rental;

class BookingController extends Controller
{
    //

    public function showBookingHistory()
    {
        
    }

    public function  bookingVehicle(BookingVehicleRequest $request)
    {
    
        // Check user login và payment method === Thanh toán tiền mặt
        if(Auth::check() && $request->payment_method_id == 1) 
        {
            $validatedData = $request->validated(); 
            $user_id = Auth::user()->user_id;

            // $payment = Rental::created([
            //     'user_id' => $user_id,
            //     'vehicle_id' => $request->vehicle_id,
            //     'rental_start_date' => $request->booking_start_date,
            //     'rental_end_date' => $request->booking_end_date,
            //     'total_cost' => $request->total_cost,
            //     'rental_status_id' => 1
            // ]);

            $rental = new Rental;
            $rental->user_id = $user_id;
            $rental->vehicle_id = $request->vehicle_id;
            $rental->rental_start_date = $request->booking_start_date;
            $rental->rental_end_date = $request->booking_end_date;
            $rental->total_cost = $request->booking_total_price;
            // status === 1 đồng nghĩa với việc chưa thanh toán
            $rental->rental_status_id = 1;

            $rental->save();

            $rental_id = $rental->rental_id;
            if($rental_id) {
                $payment = new Payment;
                $payment->rental_id = $rental_id;
                $payment->amount = $request->booking_total_price;
                $payment->payment_method_id = $request->payment_method_id;
                $payment->save();
            }

            return back()->with('msg--success', 'Đặt xe thành công vui lòng vào <a href="">Lịch sử đặt xe</a> để kiểm tra');

        }else {
            return redirect()->route('home');
        }

        

    }
}
