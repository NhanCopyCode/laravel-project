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
        'avatar',
        'phone_number',
        'company_name',
        'description',
        'branch_id'
    ];

    public $primaryKey = 'CarRentalStore_id';
    public $timestamps = true;

}
