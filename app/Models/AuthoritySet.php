<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class AuthoritySet extends Model
{
    use HasFactory;

    protected $table = 'authority_sets';
    
    protected $fillable = [
        'name',
        'description',
        'add_account',
        'upd_account',
        'del_flg',
    ];
}
