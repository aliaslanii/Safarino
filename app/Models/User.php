<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firsName',
        'lastName',
        'mobile',
        'mobile',
        'email',
        'password',
        'birthday',
        'gender',
        'nationalcode',
        'shabanumber',
        'cardnumber',
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

    public function role() : BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
    public function Passenger() : HasMany
    {
        return $this->hasMany(Passenger::class,'user_id');
    }
    public function hasRole($role)
    {
        return $this->role()->where('name',$role)->first();
    }
    public function wallet() : HasOne
    {
        return $this->hasOne(wallet::class,'user_id');
    }
    public function Order() : HasMany
    {
        return $this->hasMany(Order::class,'user_id');
    }
}
