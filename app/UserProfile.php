<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'about', 'social_networks', 'phone', 'mobile_phone'
    ];

    protected $table = 'user_profile';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
