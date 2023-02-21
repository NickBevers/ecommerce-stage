<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements CanResetPasswordContract
{
    use HasFactory;
    use CanResetPassword;
    use Notifiable;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }



    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function cart(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function whishlist(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Whishlist::class);
    }
}