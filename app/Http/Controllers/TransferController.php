<?php

namespace App\Http\Controllers;

use App\Transfer;
use Illuminate\Http\Request;

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

        if(count($transfer->get())>0){
            return responder()->success($transfer);
        }

        return responder()->error('Not Found', 404,"No transference was found");
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|max:255',
            'transaction_date' => 'required|max:255',
            'note' => 'nullable|boolean',
            'location' => 'nullable|boolean',
            'reminder_date' => 'nullable|max:255',
            'reportable' => 'required|boolean',
            'currency_id' => 'required|integer|exists:currencies,id',
            'origin_wallet_id' => 'required|integer|exists:wallets,id',
            'target_wallet_id' => 'required|integer|exists:wallets,id',
        ]);

        if ($validator->fails()) {
            return responder()->error('validation_failed', 422);
        }

        $transactionExpense = new Transaction();
        $transactionExpense->amount = $request->amount;
        $transactionExpense->transaction_date = $request->transaction_date;
        $transactionExpense->note = $request->note;
        $transactionExpense->location = $request->location;
        $transactionExpense->reminder_date = $request->reminder_date;
        $transactionExpense->reportable = $request->reportable;
        $transactionExpense->currency_id = $request->currency_id;
        $transactionExpense->category_id = 0;
        $transactionExpense->wallet_id = $request->origin_wallet_id;
        $transactionExpense->create();

        $transactionIncome = new Transaction();
        $transactionIncome->amount = $request->amount;
        $transactionIncome->transaction_date = $request->transaction_date;
        $transactionIncome->note = $request->note;
        $transactionIncome->location = $request->location;
        $transactionIncome->reminder_date = $request->reminder_date;
        $transactionIncome->reportable = $request->reportable;
        $transactionIncome->currency_id = $request->currency_id;
        $transactionIncome->category_id = 1;
        $transactionIncome->wallet_id = $request->target_wallet_id;
        $transactionIncome->create();

        $transfer = new Transfer();
        $transfer->expense_transaction_id = $transactionExpense->id;
        $transfer->income_transaction_id = $transactionIncome->id;
        $transfer->created_at = $request->transaction_date;
        $transfer->user_id = Auth::user()->id;


        return responder()->success(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transfer  $transference
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transfer = Transfer::findOrFail($id);

        return responder()->success($transfer);
    }

}
