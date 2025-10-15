<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use UUID, SoftDeletes;

    protected $fillable = [
        'thumbnail',
        'name',
        'description',
        'price',
        'date',
        'time',
        'is_active'
    ];

    protected $cast = [
        "price" => "decimal:2",
    ];

    public function scopeSearch($query, $search)
    {
        $query->where('name', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%");
    }

    public function eventParticipants()
    {
        return $this->hasMany(EventParticipant::class);
    }
}
