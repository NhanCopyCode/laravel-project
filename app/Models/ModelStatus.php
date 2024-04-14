<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelStatus extends Model
{
    use HasFactory;

    protected $table = 'modelStatus';

    protected $fillable = [
        'model_status_id',
        'model_status_name',
    ];

    public $primaryKey = 'model_id';
    public $timestamps = false;

}
