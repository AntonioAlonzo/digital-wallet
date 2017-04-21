<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'transaction_date', 'note', 'location', 'reminder_date', 'reportable',
    ];

    /**
     * Get the wallet that owns the transaction.
     */
    public function wallet()
    {
        return $this->belongsTo('App\Wallet');
    }

    /**
     * Get the category that owns the transaction.
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * Get the event that owns the transaction.
     */
    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    /**
     * The products that belong to the transaction.
     */
    public function products()
    {
        return $this->belongsToMany('App\Product');
    }
}
