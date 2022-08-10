<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnounceCategory extends Model
{
    use HasFactory;
    protected $table = 'announce_categories';
    protected $fillable = [
        'code',
        'contract_id',
        'category',
        'description',
    ];
}
