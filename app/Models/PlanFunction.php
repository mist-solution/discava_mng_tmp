<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class PlanFunction extends Model
{
    use HasFactory;

    protected $table = 'plan_functions';
    
    protected $fillable = [
        'plan_id',
        'function_id',
        'add_account',
        'upd_account',
        'del_flg',
    ];
}
