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
        'authority_set_id',
        'mate_function_id',
        'function_auth_flg',
        'create_auth_flg',
        'read_auth_flg',
        'update_auth_flg',
        'delete_auth_flg',
        'request_auth_flg',
        'approval_auth_flg',
        'add_account',
        'upd_account',
        'del_flg',
    ];
}
