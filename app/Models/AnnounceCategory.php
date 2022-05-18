<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Announce;

class AnnounceCategory extends Model
{
    public function index()
    {
        return Announce::all();
        
    }
}
