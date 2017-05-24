<?php

namespace App\Transformers;

use App\Wallet;
use Flugg\Responder\Transformer;
use League\Fractal\ParamBag;

class WalletTransformer extends Transformer
{
    /**
     * A list of all available relations.
     *
     * @var array
     */
    protected $relations = [];

    /**
     * Transform the model data into a generic array.
     *
     * @param  Wallet $wallet
     * @return array
     */
    public function transform(Wallet $wallet)
    {
        return [
            'id' => (int)$wallet->id,
            'name' => (string)$wallet->name,
            'description' => (string)$wallet->description,
            'transactions' => $wallet->transactions,
            'balance' => $wallet->balances,

        ];
    }

    public function transactions(Wallet $wallet, ParamBag $paramBag)
    {
        return $wallet->transactions;
    }
}
