<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'confirmation_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the wallets for the user.
     */
    public function wallets()
    {
        return $this->hasMany('App\Wallet');
    }

    /**
     * Get the transactions for the user.
     */
    public function transactions()
    {
        return $this->hasManyThrough('App\Transaction', 'App\Wallet');
    }

}
