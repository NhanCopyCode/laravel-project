<?php

namespace App\Models\admins;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'model_status_id'
    ];

    protected $primaryKey = 'model_id';
    public $timestamps = false;

    public function brand() 
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
