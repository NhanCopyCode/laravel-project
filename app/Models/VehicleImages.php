<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleImages extends Model
{
    use HasFactory;
    protected $table = 'vehicleimages';

    protected $fillable = [
        'vehicle_image_data_1',
        'vehicle_image_data_2',
        'vehicle_image_data_3',
    ];

    public $primaryKey = 'vehicle_img_id';
    public $timestamps = false;

}
