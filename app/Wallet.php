<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'initial_balance', 'initial_balance_date', 'reportable',
    ];

    /**
     * Get the user that owns the wallet.
     */
    public function wallet()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the wallet type that owns the wallet.
     */
    public function walletType()
    {
        return $this->belongsTo('App\WalletType');
    }

    /**
     * Get the currency that owns the wallet.
     */
    public function currency()
    {
        return $this->belongsTo('App\Currency');
    }

    /**
     * Get the transactions for the wallet.
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
