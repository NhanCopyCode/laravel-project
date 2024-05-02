<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $table = 'paymentmethod';

    protected $fillable = [
        'payment_method_name',
    ];

    public $primaryKey = 'payment_method_id';
    public $timestamps = false;
}
