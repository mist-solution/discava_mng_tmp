<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Authority extends Model
{
    use HasFactory;

    protected $table = 'authorities';
    
    protected $fillable = [
        'name',
        'description',
        'add_account',
        'upd_account',
        'del_flg',
    ];
}
