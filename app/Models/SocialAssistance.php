<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAssistance extends Model
{
    use SoftDeletes, UUID;
    protected $fillable = [
        'thumbnail',
        'name',
        'category',
        'amount',
        'provider',
        'description',
        'is_available'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('category', 'like', '%' . $search . '%');
    }

    public function socialAssistanceRecepient()
    {
        return $this->hasMany(SocialAssistanceRecepient::class);
    }
}
