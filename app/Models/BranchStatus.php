<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchStatus extends Model
{
    use HasFactory;

    protected $table = 'branchstatus';

    protected $primayKey = 'branch_status_id';
}
