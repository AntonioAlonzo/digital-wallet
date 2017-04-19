<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the wallets for the wallet type.
     */
    public function wallets()
    {
        return $this->hasMany('App\Wallet');
    }
}
