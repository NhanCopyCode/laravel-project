<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'location';

    protected $fillable = [
        'provine',
        'ward',
        'district',
        'unique_location',
    ];

    public $primaryKey = 'location_id';
    public $timestamps = false;

}
