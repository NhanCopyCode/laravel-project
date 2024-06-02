<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rental extends Model
{
    use HasFactory;
    protected $table = 'rental';

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'rental_start_date',
        'rental_end_date',
        'rental_status_id',
        'amount_paid',
    ];

    public $primaryKey = 'rental_id';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
