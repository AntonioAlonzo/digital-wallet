<?php

namespace App\Transformers;

use App\Wallet;
use Flugg\Responder\Transformer;

class WalletListTransformer extends Transformer
{
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

        ];
    }
}
