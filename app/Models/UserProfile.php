<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'email_notifications',
        'sms_notifications',
        'author_recommendations',
    ];

    protected $casts = [
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'author_recommendations' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
