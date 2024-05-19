<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PDO;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'mobile_verified_at',
        'is_admin',
        'is_active',
        'username',
        'mobile'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany{
    return $this->hasMany(Post::class,'created_by');
   }

   public function otp(): \Illuminate\Database\Eloquent\Relations\HasOne{
    return $this->hasOne(Otp::class,'user_id');
   }

   public function authenticate(){
    return $this->createToken('user-api',['user'])->plainTextToken;
   }

}
