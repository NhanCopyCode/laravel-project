<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandStatus extends Model
{
    use HasFactory;

    protected $table = 'branchs';

    protected $fillable = [
        'brand_status_id',
        'brand_status_name',
    ];

    public $primaryKey = 'brand_id';
    public $timestamps = false;

}
