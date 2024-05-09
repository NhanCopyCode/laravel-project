<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalStatus extends Model
{
    use HasFactory;
    protected $table = 'rentalstatus';

    protected $fillable = [
        'rental_status_name',
    ];

    public $primaryKey = 'rental_status_id';
    public $timestamps = false;

}
