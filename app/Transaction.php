<?php

namespace App;

use App\Transformers\TransactionTransformer;
use Flugg\Responder\Contracts\Transformable;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model implements Transformable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'transaction_date', 'note', 'location', 'reminder_date', 'reportable', 'currency_id', 'category_id', 'wallet_id',
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
     * The transformer used to transform the model data.
     *
     * @return Transformer|callable|string|null
     */
    public static function transformer()
    {
        return TransactionTransformer::class;
    }
}
