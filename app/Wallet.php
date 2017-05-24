<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description',
    ];

    /**
     * Get the user that owns the wallet.
     */
    public function wallet()
    {
        return $this->belongsTo('App\User');
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
