<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventParticipant extends Model
{
    use UUID, SoftDeletes;

    protected $fillable = [
        'event_id',
        'head_of_family_id',
        'quantity',
        'total_price',
        'payment_status',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'total_price' => 'decimal:2',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('headOfFamily', function ($q) use ($search) {
            $q->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            });
        })->orWhereHas('event', function ($q) use ($search) {
            $q->where('name', 'LIKE', "%$search%");
        });
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function headOfFamily()
    {
        return $this->belongsTo(HeadOfFamily::class);
    }
}
