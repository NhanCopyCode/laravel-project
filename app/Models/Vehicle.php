<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';

    protected $fillable = [
        'CarRentalStore_id',
        'model_id',
        'description',
        'license_plate',
        'rental_price_day',
        'vehicle_status_id',
        'vehicle_image_id',
    ];

    public $primaryKey = 'vehicle_id';
    public $timestamps = true;
}
