<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class AnnounceAttachment extends Model
{
    use HasFactory;

    protected $table = 'announce_attachments';

    protected $fillable = [
        'shop_id',
        'announce_id',
        'img_path',
        'img_filename',
        'add_account',
        'upd_account',
        'del_flg',
    ];

}