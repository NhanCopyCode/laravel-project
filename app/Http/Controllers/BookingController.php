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
        $booking_start_date =  explode(' - ', $request->booking_daterange)[0];
        $booking_end_date = str_replace(' / ', ' - ', explode(' - ', $request->booking_daterange)[1]);

        // dd($booking_start_date, $booking_end_date);

        // Check user login và payment method === Thanh toán tiền mặt
        if(Auth::check() && $request->redirect != null) {
            $this->VNPAYpayment($request);
        }
        elseif(Auth::check() && $request->payment_method_id == 1) 
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
            $rental->rental_start_date = $booking_start_date;
            $rental->rental_end_date = $booking_end_date;
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

    public function VNPAYpayment(Request $request)
    {
        // dd($request->all());
        $vnp_Url = env('vnp_Url');
        $vnp_Returnurl = env('vnp_Returnurl');
        $vnp_TmnCode = env('vnp_TmnCode');
        $vnp_HashSecret = env('vnp_HashSecret');
        
        $vnp_TxnRef = rand(0, 9999); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toan GD: '. $vnp_TxnRef;
        $vnp_OrderType = 'VNPAY';
        $vnp_Amount = $request->booking_total_price * 100;
        $vnp_Locale = $request->language;
        // $vnp_BankCode = $request->bankCode;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
       
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }


        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        // dd($vnp_Url);
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);

                // return back()->with('msg--success-vnpay', 'Thanh toán thành công bằng VNPAY, bạn có thể vào <a href="">lịch sử đặt xe</a> để kiểm tra');
                die();
            } else {
                echo json_encode($returnData);
            }

        
    }
    
}

/*


Location: https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
?vnp_Amount=1000000
&vnp_Command=pay
&vnp_CreateDate=20240504185231
&vnp_CurrCode=VND
&vnp_ExpireDate=20240504190731
&vnp_IpAddr=127.0.0.1
&vnp_Locale=vn
&vnp_OrderInfo=Thanh+toan+GD%3A9932
&vnp_OrderType=other
&vnp_ReturnUrl=http%3A%2F%2Flocalhost%2Fvnpay_php%2Fvnpay_return.php
&vnp_TmnCode=JY3C3HGY
&vnp_TxnRef=9932
&vnp_Version=2.1.0
&vnp_SecureHash=ab0f061c72cc13deb866b3a879a1d9cab6be09891044a24421723865752fd18d8047ec0a39f0b54615924624d67375597f394235ce2108f3c66be9d2853362a8


https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
?vnp_Amount=13500000
&vnp_BankCode=True
&vnp_Command=pay
&vnp_CreateDate=20240504185631
&vnp_CurrCode=VND
&vnp_IpAddr=127.0.0.1
&vnp_Locale=vn
&vnp_OrderInfo=Thanh+to%C3%A1n+xe
&vnp_OrderType=billpayment
&vnp_ReturnUrl=http%3A%2F%2F127.0.0.1%3A8000%2F
&vnp_TmnCode=JY3C3HGY&vnp_TxnRef=858&vnp_Version=2.1.0
&vnp_SecureHash=2d0b36d9c228e056927f7fea98a7d7a207d48e300e545f32c461b36c8444dcc0b2fbf2d905e12beed61ec645bc21c2357d72a399b6a1b374bb5da98bc4828fa2
*/