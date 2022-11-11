<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopUser extends Model
{
    use HasFactory;

    protected $table = 'shop_users';

    protected $fillable = [
        'shop_id',
        'user_id',
        'authority_id',
        'add_account',
        'upd_account',
        'del_flg',
    ];
}
