<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'company_name',
        'business_content',
        'postal_code',
        'address',
        'tel',
        'fax',
        'mail',
    ];

    public function end_user()
    {
        return $this->hasMany(EndUser::class);
    }
}
