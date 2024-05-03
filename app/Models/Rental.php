<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;
    protected $table = 'rental';

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'rental_start_date',
        'rental_end_date',
        'total_cost',
        'rental_status_id',
    ];

    public $primaryKey = 'rental_id';
    public $timestamps = true;
}
