<?php

namespace App\Http\Controllers;

use App\Transference;
use Illuminate\Http\Request;

class TransferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transferences = Transference::where("user_id", Auth::user()->id);

        if(count($transferences->get())>0){
            return responder()->success($transferences);
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
            'wallet_id' => 'required|integer|exists:wallets,id',
        ]);

        if ($validator->fails()) {
            return responder()->error('validation_failed', 422);
        }

        $transaction1 = new Transaction();
        $transaction1->amount = $request->amount;
        $transaction1->transaction_date = $request->transaction_date;
        $transaction1->note = $request->note;
        $transaction1->location = $request->location;
        $transaction1->reminder_date = $request->reminder_date;
        $transaction1->reportable = $request->reportable;
        $transaction1->currency_id = $request->currency_id;
        $transaction1->category_id = 0;
        $transaction1->wallet_id = $request->wallet_id;
        $transaction1->save();

        $transaction = new Transaction();
        $transaction->amount = $request->amount;
        $transaction->transaction_date = $request->transaction_date;
        $transaction->note = $request->note;
        $transaction->location = $request->location;
        $transaction->reminder_date = $request->reminder_date;
        $transaction->reportable = $request->reportable;
        $transaction->currency_id = $request->currency_id;
        $transaction->category_id = 1;
        $transaction->wallet_id = $request->wallet_id;
        $transaction->save();

        return responder()->success(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transference  $transference
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transference = Transference::findOrFail($id);

        return responder()->success($transference);
    }

}
