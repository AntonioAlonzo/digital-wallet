<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transference extends Model
{
    /**
     * Get the user that owns the transference.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the transactions link to the the transference.
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    /**
     * Get the wallets link to the the transference.
     */
    public function wallets()
    {
        return $this->hasMany('App\Wallet');
    }
    /**
     * The transformer used to transform the model data.
     *
     * @return Transformer|callable|string|null
     */
    public static function transformer()
    {
        return TransferenceTransformer::class;
    }
}
