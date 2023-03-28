<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class MediaAttachment extends Model
{
    use HasFactory;

    protected $table = 'media_attachments';
    
    protected $fillable = [
        'shop_id',
        'media_folder_id',
        'img_path',
        'img_filename',
        'img_fileformat',
        'img_filesize',
        'img_height',
        'img_width',
        'img_caption',
        'img_memo',
        'img_alt',
        'img_sortno',
        'add_account',
        'upd_account',
        'del_flg',
    ];
}
