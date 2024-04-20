<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarRentalStore extends Model
{
    use HasFactory;
    protected $table = 'carrentalstore';

    protected $fillable = [
        'location_id',
        'phone_number',
        'avatar',
        'description',
        'branch_id'
    ];

    public $primaryKey = 'CarRentalStore_id';
    public $timestamps = true;

}
