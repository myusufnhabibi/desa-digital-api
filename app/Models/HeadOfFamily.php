<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeadOfFamily extends Model
{
    use SoftDeletes, UUID;

    protected $fillable = [
        'user_id',
        'profile_picture',
        'identity_number',
        'gender',
        'date_of_birth',
        'phone_number',
        'ocupation',
        'marital_status'
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
        // karena head of family adalah user juga
        return $this->belongsTo(User::class);
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function socialAssistanceRecepient()
    {
        return $this->hasMany(SocialAssistanceRecepient::class);
    }

    public function eventParticipants()
    {
        return $this->hasMany(EventParticipant::class);
    }
}
