<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemAdmin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'login_user_id',
        'mail',
        'name',
        'initial_password',
        'password',
        'add_account',
        'upd_account',
        'del_flg',
    ];
}
