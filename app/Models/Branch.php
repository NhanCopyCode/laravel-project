<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branchs';
    protected $fillable = [
        'branch_name', 
        'branch_status_id'
    ];

    protected $primaryKey = 'branch_id';
    public $timestamps = false;
}
