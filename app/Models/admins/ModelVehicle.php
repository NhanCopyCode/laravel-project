<?php

namespace App\Models\admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelVehicle extends Model
{
    use HasFactory;

    protected $table = 'models';

    protected $fillable = [
        'model_name', 
        'engine_type',
        'color',
        'year_of_production',
        'brand_id',
    ];

    protected $primaryKey = 'model_id';
    public $timestamps = false;
}
