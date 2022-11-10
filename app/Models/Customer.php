<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'company_name',
        'business_content',
        'postal_code',
        'address',
        'building_name',
        'tel',
        'fax',
        'mail',
        'add_account',
        'upd_account',
        'del_flg',
    ];
}
