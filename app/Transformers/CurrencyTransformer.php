<?php

namespace App\Transformers;

use App\Currency;
use Flugg\Responder\Transformer;

class CurrencyTransformer extends Transformer
{
    /**
     * A list of all available relations.
     *
     * @var array
     */
    protected $relations = ['*'];

    /**
     * Transform the model data into a generic array.
     *
     * @param  Currency $currency
     * @return array
     */
    public function transform(Currency $currency)
    {
            return [
                'id' => (int)$currency->id,
                'name' => (string)$currency->name,
                'code' => (string)$currency->code,
            ];


    }
}
