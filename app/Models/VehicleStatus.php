<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleStatus extends Model
{
    use HasFactory;
    protected $table = 'vehiclestatus';

    protected $fillable = [
        'vehicle_status_name',
    ];

    public $primaryKey = 'vehicle_status_id';
    public $timestamps = false;

}
