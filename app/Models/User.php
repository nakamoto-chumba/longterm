<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'phone',
        'referral_id',
        'balance',
        'cashout',
        'investment',
        'uplinebonus',
        'email',
        'password',
        'status',
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
        'password' => 'hashed',
    ];
  
    public function upline() :BelongsTo
    {
        return $this->belongsTo(User::class, 'referral_id', 'id');
    }
    public function referrals() :HasMany
    {
        return $this->hasMany(User::class, 'referral_id', 'id');
    }
    protected $appends = ['referral_link'];
    /**
     * Get the user's referral link
     * 
     * @return string
     */
    public function getReferralLinkAttribute() 
    {
        return $this->referral_link = route('register', ['upline' => $this->username]);  
    }
}
