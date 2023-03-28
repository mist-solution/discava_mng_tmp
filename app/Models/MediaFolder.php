<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class MediaFolder extends Model
{
    use HasFactory;

    protected $table = 'media_folders';
    
    protected $fillable = [
        'shop_id',
        'parent_folder_id',
        'name',
        'media_sort',
        'media_width',
        'media_height',
        'media_column_num',
        'media_align',
        'media_link',
        'media_margin',
        'media_caption',
        'media_frame_design',
        'media_frame_color',
        'media_shadow',
        'media_hover_expand',
        'media_hover_icon',
        'add_account',
        'upd_account',
        'del_flg',
    ];
}
