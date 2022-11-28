<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopUser extends Model
{
    use HasFactory;

    protected $table = 'shop_users';

    protected $fillable = [
        'customer_id',
        'shop_id',
        'user_id',
        'authority_id',
        'add_account',
        'upd_account',
        'del_flg',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
