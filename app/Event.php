<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'start_date', 'end_date',
    ];

    /**
     * Get the transactions for the event.
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    /**
     * Get the user that owns the wallet.
     */
    public function wallet()
    {
        return $this->belongsTo('App\User');
    }
}
