<?php

namespace App\Http\Controllers;

use App\Transfer;
use Illuminate\Http\Request;
use App\Transaction;
use Illuminate\Support\Facades\Auth;
use Validator;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transfer = Transfer::where("user_id", Auth::user()->id);


        if (count($transfer->get()) > 0) {
            return responder()->success($transfer);
        }

        return responder()->error('Not Found', 404, "No transference was found");
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
            'note' => 'nullable|max:255',
            'location' => 'nullable|max:255',
            'reminder_date' => 'nullable|date',
            'reportable' => 'required|boolean',
            'currency_id' => 'required|integer|exists:currencies,id',
            'origin_wallet_id' => 'required|integer|exists:wallets,id',
            'target_wallet_id' => 'required|integer|exists:wallets,id',
        ]);

        if ($validator->fails()) {
            return responder()->error('validation_failed', 422);
        }

        $transactionExpense= Transaction::create(['amount' => $request->amount, 'transaction_date' => $request->transaction_date,
            'note' =>$request->note, 'location' => $request->location, 'reminder_date' => $request->reminder_date,
            'reportable' => $request->reportable, 'currency_id' => $request->currency_id, 'category_id' => 18,
            'wallet_id' => $request->origin_wallet_id ]);


        $transactionIncome= Transaction::create(['amount' => $request->amount, 'transaction_date' => $request->transaction_date,
            'note' =>$request->note, 'location' => $request->location, 'reminder_date' => $request->reminder_date,
            'reportable' => $request->reportable, 'currency_id' => $request->currency_id, 'category_id' => 7,
            'wallet_id' => $request->target_wallet_id ]);

        $transfer = new Transfer();
        $transfer->expense_transaction_id = $transactionExpense->id;
        $transfer->income_transaction_id = $transactionIncome->id;
        $transfer->user_id = Auth::user()->id;
        $transfer->save();

        return responder()->success(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transfer $transference
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transfer = Transfer::findOrFail($id);

        return responder()->success($transfer);
    }

}
