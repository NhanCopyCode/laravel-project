<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\VNPAY;
use App\Models\Rental;
use App\Models\Payment;
use App\Models\Vehicle;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\BookingVehicleRequest;
use Illuminate\Support\Composer;

class BookingController extends Controller
{
    //
    public function index()
    {
        $vehicle_list = Vehicle::join('models', 'models.model_id', '=', 'vehicles.model_id')
        ->join('vehicleimages', 'vehicleimages.vehicle_img_id', '=', 'vehicles.vehicle_image_id')
        ->paginate(3);
        $vehicle_count = Vehicle::count();
        // dd(Vehicle::get());
        return view('clients.booking.showBooking', compact('vehicle_list', 'vehicle_count'));
    }

    public function showBookingHistory()
    {
        $list_booking_vehicle = DB::table('payment')
        ->join('rental', 'payment.rental_id', '=', 'rental.rental_id')
        ->join('rentalstatus', 'rental.rental_status_id', '=', 'rentalstatus.rental_status_id')
        ->join('vehicles', 'vehicles.vehicle_id', '=', 'rental.vehicle_id' )
        ->join('vehicleimages', 'vehicleimages.vehicle_img_id', '=', 'vehicles.vehicle_image_id')
        ->join('models', 'models.model_id', '=', 'vehicles.model_id')
        ->join('paymentmethod', 'paymentmethod.payment_method_id', '=', 'payment.payment_method_id')
        ->where('rental.user_id', '=', Auth::user()->user_id)
        ->where('payment.is_deleted', '=', false)
        ->select('*')
        ->orderBy('payment.created_at', 'desc')
        ->paginate(5);

        // dd($list_booking_vehicle);

        return view('clients.vehicle.booking_history', compact('list_booking_vehicle'));

    }

    public function  bookingVehicle(BookingVehicleRequest $request)
    {
        try {
            $validatedData = $request->validated(); 

            // if($validatedData->fails()) {
            //     dd('vào ddaaay là sai');
            //     return redirect()->back()->with('msg--failure', 'Đặt xe thất bại! Hãy thử kiểm tra lại!');

            // }

            $booking_start_date =  explode(' - ', $request->booking_daterange)[0];
            $booking_end_date = str_replace(' / ', ' - ', explode(' - ', $request->booking_daterange)[1]);

            // Đầu tiên phải check được user đã đủ thông tin để booking được vehicle hay chưa
            $user = Auth::user();
            if($user->phone_number == null || $user->CCCD == null || $user->date_of_birth == null || $user->name == null || $user->email == null ) {
                return redirect()->route('user.update.profile', ['user' => $user->user_id])->with('msg--need-profile-user', 'Bạn cần nhập đầy đủ thông tin trước khi thuê xe!' );
            }

            // Check user login và payment method === Thanh toán tiền mặt
            if(Auth::guard('web')->check() && $request->redirect === 'vnpay_payment') {
                
                // dd(Carbon::now());
                $user_id = Auth::user()->user_id;

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
                    $payment->payment_date = Carbon::now();
                    $payment->amount = $request->booking_total_price;
                    $payment->payment_method_id = 2;
                    $payment->save();
                }
                
                $payment_id = $payment->payment_id;
            
                // Lưu vào cache
                Cache::put('rental_id', $rental_id, now()->addMinutes(30));
                Cache::put('payment_id', $payment_id, now()->addMinutes(30));
    


                $this->VNPAYpayment($request, $rental_id, $payment_id);
                // $this->vnpayReturn();
            }
            elseif(Auth::guard('web')->check() && $request->payment_method_id == 1) 
            {
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
                    // Không thể update payment date bởi vì đây là phương thức thanh toán bằng tiền mặt
                    // $payment->payment_date = Carbon::now();
                    $payment->amount = $request->booking_total_price;
                    $payment->payment_method_id = $request->payment_method_id;
                    $payment->save();
                }

                return back()->with('msg--success', 'Đặt xe thành công vui lòng vào <a href="'.route('user.booking.history').'">Lịch sử đặt xe</a> để kiểm tra');

            }
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return redirect()->back()->with('msg--failure', 'Đặt xe thất bại! Hãy thử kiểm tra lại!');
        }


    }

    public function VNPAYpayment(Request $request, $rental_id, $payment_id)
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
    public function vnpayReturn(Request $request)
    {
        if($request->vnp_ResponseCode == 0) {
           
            // Lấy từ cache
            $rental_id = Cache::get('rental_id');
            $payment_id = Cache::get('payment_id');
   
            if(Cache::has('rental_id') && Cache::has('payment_id')) {
                Cache::forget('rental_id');
                Cache::forget('payment_id');
            }

            

            $vnp_Amount = $_GET['vnp_Amount'];
            $vnp_BankCode = $_GET['vnp_BankCode'];
            $vnp_BankTranNo = $_GET['vnp_BankTranNo'];
            $vnp_CardType = $_GET['vnp_CardType'];
            $vnp_OrderInfo = $_GET['vnp_OrderInfo'];
            $vnp_TransactionNo = $_GET['vnp_TransactionNo'];
            $vnp_TmnCode = $_GET['vnp_TmnCode'];
            $vnp_ResponseCode = $_GET['vnp_ResponseCode'];
            $vnp_PayDate = $_GET['vnp_PayDate'];
            $vnp_TransactionStatus = $_GET['vnp_TransactionStatus'];
            $vnp_TxnRef = $_GET['vnp_TxnRef'];
            $vnp_SecureHash = $_GET['vnp_SecureHash'];

            VNPAY::create([
                'vnp_Amount' => $vnp_Amount,
                //Thiếu payment id
                'payment_payment_id' => $payment_id,
                'vnp_BankCode' => $vnp_BankCode,
                'vnp_BankTranNo' => $vnp_BankTranNo,
                'vnp_OrderInfo' => $vnp_OrderInfo,
                'vnp_CardType' => $vnp_CardType,
                'vnp_TransactionNo' => $vnp_TransactionNo,
                'vnp_TmnCode' => $vnp_TmnCode,
                'vnp_ResponseCode' => $vnp_ResponseCode,
                'vnp_PayDate' => $vnp_PayDate,
                'vnp_TransactionStatus' => $vnp_TransactionStatus,
                'vnp_TxnRef' => $vnp_TxnRef,
                'vnp_SecureHash' => $vnp_SecureHash,

            ]);

            $rental = Rental::find($rental_id);

            $rental->rental_status_id = 2;
            $rental->save();


        }else {
            $rental_id = Cache::get('rental_id');
            $payment_id = Cache::get('payment_id');
   
            if ($rental_id && $payment_id) {
            // Tìm và xóa payment
                $payment = Payment::find($payment_id);
                if ($payment) {
                    $payment->delete();
                }

                // Tìm và xóa rental
                $rental = Rental::find($rental_id);
                if ($rental) {
                    $rental->delete();
                }
        
        
                // Xóa các giá trị trong cache
                Cache::forget('rental_id');
                Cache::forget('payment_id');

            }
        }
        return view('clients.vnpay.vnpay_return');
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