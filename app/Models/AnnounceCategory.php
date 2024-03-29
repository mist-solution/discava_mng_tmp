<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnounceCategory extends Model
{
    use HasFactory;

    protected $table = 'announce_categories';

    protected $fillable = [
        'shop_id',
        'category_name',
        'description',
        'icon',
        'add_account',
        'upd_account',
        'del_flg',
    ];
}
