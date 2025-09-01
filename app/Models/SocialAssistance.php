<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAssistance extends Model
{
    use SoftDeletes, UUID;
    protected $fillable = [
        'name',
        'thumbnail',
        'category',
        'amount',
        'provider',
        'description',
        'is_available'
    ];
}
