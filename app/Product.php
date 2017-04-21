<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'barcode',
    ];

    /**
     * The transactions that belong to the product.
     */
    public function transactions()
    {
        return $this->belongsToMany('App\Transaction');
    }
}
