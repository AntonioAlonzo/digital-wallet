<?php

namespace App\Transformers;

use App\Transfer;
use Flugg\Responder\Transformer;

class TransferTransformer extends Transformer
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
     * @param  Transfer $transference
     * @return array
     */
    public function transform(Transfer $transfer)
    {
        return [
            'id' => (int) $transfer->id,
            'income_transaction_id' => (int) $transfer->income_transaction_id,
            'expense_transaction_id' => (int) $transfer->expense_transaction_id,
        ];
    }
}
