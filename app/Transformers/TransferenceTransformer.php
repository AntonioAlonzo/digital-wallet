<?php

namespace App\Transformers;

use App\Transference;
use Flugg\Responder\Transformer;

class TransferenceTransformer extends Transformer
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
     * @param  Transference $transference
     * @return array
     */
    public function transform(Transference $transference)
    {
        return [
            'id' => (int) $transference->id,
            'income_transaction_id' => (int) $transference->income_transaction_id,
            'expense_transaction_id' => (int) $transference->expense_transaction_id,
        ];
    }
}
