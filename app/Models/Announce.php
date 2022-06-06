<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

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

    public function upd_account()
    {
        return $this->belongsTo(User::class, 'upd_account');
    }

    public static function getAnnounce($offset, $limit)
    {
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

    public static function getAnnounceSort($sort)
    {
        $announceModel = Announce::with('upd_account')
            ->where('del_flg', false)
            ->orderBy('id');
        log::info("selected  " . $sort);
        // $announce['sort'] = $announceModel
        //     ->sort();

        $announce['anounce'] = $announceModel
            ->orderBy($sort)
            ->get();
        return $announce;
    }
}
