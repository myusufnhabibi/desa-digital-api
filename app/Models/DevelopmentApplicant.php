<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DevelopmentApplicant extends Model
{
    use UUID, SoftDeletes;

    protected $fillable = [
        'development_id',
        'user_id',
        'status',
    ];

    public function scopeSearch($query, $keyword)
    {
        $query->whereHas('user', function ($q) use ($keyword) {
            $q->where('name', 'LIKE', "%$keyword%")
              ->orWhere('email', 'LIKE', "%$keyword%");
        });
    }

    public function development()
    {
        return $this->belongsTo(Development::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
