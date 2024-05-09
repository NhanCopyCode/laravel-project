<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VNPAY extends Model
{
    use HasFactory;
    protected $table = 'vnpay';

    protected $fillable = [
        'payment_payment_id' ,
        'vnp_Amount' ,
        'vnp_BankCode' ,
        'vnp_BankTranNo' ,
        'vnp_CardType' ,
        'vnp_OrderInfo' ,
        'vnp_TransactionNo' ,
        'vnp_TmnCode' ,
        'vnp_ResponseCode' ,
        'vnp_PayDate' ,
        'vnp_TransactionStatus',
        'vnp_TxnRef' ,
        'vnp_SecureHash' ,
    ];

    public $primaryKey = 'vnp_id';
    public $timestamps = false;

}