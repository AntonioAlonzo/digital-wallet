<?php

namespace App\Transformers;

use App\Transaction;
use Flugg\Responder\Transformer;

class TransactionTransformer extends Transformer
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
     * @param  Transaction $transaction
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'id' => (int)$transaction->id,
            'amount' => $transaction->amount,
            'transaction_date' => $transaction->date,
            'note' => $transaction->note,
            'location' => $transaction->location,
            'reminder_date' => $transaction->reminder_date,
            'reportable' => (boolean)$transaction->reportable,
            'category_id' => $transaction->category_id,
            'event_id' => $transaction->event_id,

        ];
    }
}
