<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class PlanMateFunction extends Model
{
    use HasFactory;

    protected $table = 'plan_mate_functions';
    
    protected $fillable = [
        'plan_id',
        'mate_function_id',
        'add_account',
        'upd_account',
        'del_flg',
    ];
}
