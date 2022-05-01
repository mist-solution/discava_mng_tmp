<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announce extends Model
{
    use HasFactory;

    protected $table = 'announce';
    protected $fillable = [
        'title',
        'contents',
        'approval_status',
        'approval_comment',
        'approval_account',
        'approval_datetime',
        'del_flg',
    ];

    public function upd_account() {
         return $this->belongsTo(User::class, 'upd_account');
    }

    public static function getAnnounce($offset, $limit) {
        $announceModel = Announce::with('upd_account')
            ->where('del_flg', false)
            ->orderBy('id');

        $announce['count'] = $announceModel
            ->count();
        
        $announce['anounce'] = $announceModel
            ->limit($limit)
            ->offset($offset)
            ->get();
        return $announce;
    }

}
