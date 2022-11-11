<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $table = 'shops';

    protected $fillable = [
        'customer_id',
        'shop_name',
        'plan_id',
        'add_account',
        'upd_account',
        'del_flg',
    ];
}