<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Transformers\TransactionTransformer;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user =  Auth::user();
        $transactions = $user->transactions();

        if ($request->has('category_id')) {
            $transactions->where('category_id', $request->category_id);
        }
        if ($request->has('currency_id')) {
            $transactions->where('currency_id', $request->category_id);
        }
        if(count($transactions)>0){
            return responder()->success($transactions);
        }

        return responder()->error('Not Found', 404,"No transaction was found");
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
            'wallet_id' => 'required|integer|exists:wallets,id'
        ]);

        if ($validator->fails()) {
            return responder()->error('validation_failed', 422);
        }

        $transaction = new Transaction();
        $transaction->amount = $request->amount;
        $transaction->transaction_date = $request->transaction_date;
        $transaction->note = $request->note;
        $transaction->location = $request->location;
        $transaction->reminder_date = $request->reminder_date;
        $transaction->reportable = $request->reportable;
        $transaction->currency_id = $request->currency_id;
        $transaction->wallet_id = $request->wallet_id;
        $transaction->save();

        return responder()->success(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction =  Transaction::findOrFail($id);
        $wallet = Wallet::findOrFail($transaction->wallet_id);

        if (Auth::user()->can('show', $wallet)) {
                return responder()->transform($transaction, new TransactionTransformer())->respond();
        }

        return responder()->error('unauthorized', 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|max:255',
            'transaction_date' => 'required|max:255',
            'note' => 'nullable|boolean',
            'location' => 'nullable|boolean',
            'reminder_date' => 'nullable|max:255',
            'reportable' => 'required|boolean',
            'currency_id' => 'required|integer|exists:currencies,id',
            'wallet_id' => 'required|integer|exists:wallets,id'
        ]);

        if ($validator->fails()) {
            return responder()->error('validation_failed', 422);
        }

        $transaction = Transaction::findOrFail($id);
        $wallet = Wallet::findOrFail($transaction->wallet_id);

        if ($wallet->user_id == Auth::user()->id) {
            $transaction->fill($request->all());
            $transaction->save();

            return responder()->success();
        }

        return responder()->error('unauthorized', 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $wallet = Wallet::findOrFail($transaction->wallet_id);

        if ($wallet->user_id == Auth::user()->id) {
            $transaction->delete();

            return responder()->success();
        }

        return responder()->error('unauthorized', 403);
    }
}
