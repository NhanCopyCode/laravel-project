<?php

namespace App\Http\Controllers;

use App\Models\VNPAY;
use Illuminate\Http\Request;

class VNPayPaymentController extends Controller
{
    //
    public function vnpayPayment(Request $request)
    {
        $vnp_Url = env('vnp_Url');
        $vnp_Returnurl = env('vnp_Returnurl');
        $vnp_TmnCode = env('vnp_TmnCode');
        $vnp_HashSecret = env('vnp_HashSecret');
        
        $vnp_TxnRef = rand(0, 9999); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán xe';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->total_price;
        $vnp_Locale = $request->language;
        $vnp_BankCode = $request->bankCode;
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
        
        //var_dump($inputData);
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
        dd($vnp_Url);
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
    }

    public function vnpayReturn()
    {
        if(isset($_GET['vnp_Amount'])) {
            

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
        }
        return view('clients.vnpay.vnpay_return');
    }
}

/*
http://127.0.0.1:8000/vnpay_return?
vnp_Amount=3000000&
vnp_BankCode=NCB&
vnp_BankTranNo=VNP14403806&
vnp_CardType=ATM&
vnp_OrderInfo=Thanh+toan+GD%3A+7890&
vnp_PayDate=20240506155257&
vnp_ResponseCode=00&
vnp_TmnCode=JY3C3HGY&
vnp_TransactionNo=14403806&
vnp_TransactionStatus=00&
vnp_TxnRef=7890&
vnp_SecureHash=64637a8a15e2591aba10441815517fce90912a70995b7f72b161e3ac288a41eec11bb48f14ae639e8c89d9559baf5c63e2108414484c808fd163333d08e0ada7

*/