<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     * TODO: Change 'name' to 'country'
     */
    protected $fillable = [
        'name', 'code',
    ];

    /**
     * Get the wallets for the currency.
     */
    public function wallets()
    {
        return $this->hasMany('App\Wallet');
    }
}
