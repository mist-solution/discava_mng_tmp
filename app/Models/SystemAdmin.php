<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemAdmin extends Model
{
    use HasFactory;

    protected $table = 'system_admins';

    protected $fillable = [
        'mail',
        'name',
        'initial_password',
        'password',
        'add_account',
        'upd_account',
        'del_flg',
    ];
}
