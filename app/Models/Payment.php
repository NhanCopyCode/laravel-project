<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payment';

    protected $fillable = [
        'rental_id',
        'payment_date',
        'amount',
        'payment_method_id',
        'payment_status_id',
    ];

    public $primaryKey = 'payment_id';
    public $timestamps = false;
}
