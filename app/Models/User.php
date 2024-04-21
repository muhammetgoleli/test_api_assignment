<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $table = 'users';
    
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id', 'name', 'email', 'password', 'is_admin', 'subscription_status', 'chat_credit'
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
