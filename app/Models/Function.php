<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Function extends Model
{
    use HasFactory;

    protected $table = 'functions';
    
    protected $fillable = [
        'name',
        'description',
        'add_account',
        'upd_account',
        'del_flg',
    ];
}
