<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transference extends Model
{
    /**
     * Get the wallet that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
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
