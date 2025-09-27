<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyMember extends Model
{
    use UUID, SoftDeletes;

    protected $fillable = [
        'head_of_family_id',
        'user_id',
        'profile_picture',
        'identity_number',
        'gender',
        'date_of_birth',
        'phone_number',
        'ocupation',
        'marital_status',
        'relation'
    ];

    public function scopeSearch($query, $search)
    {
        // karena relasi dengan user, maka pencarian juga dilakukan pada tabel user
        return $query->whereHas('user', function ($q) use ($search) {
            $q->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%");
        })->orWhere('identity_number', 'LIKE', "%$search%")
          ->orWhere('phone_number', 'LIKE', "%$search%")
          ->orWhere('ocupation', 'LIKE', "%$search%")
          ->orWhere('marital_status', 'LIKE', "%$search%");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function headOfFamily()
    {
        return $this->belongsTo(HeadOfFamily::class);
    }
}
