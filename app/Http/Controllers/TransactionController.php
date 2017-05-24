<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Transformers\TransactionTransformer;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
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
        $user = Auth::user();
        $transactions = $user->transactions();

        if ($request->has('category_id')) {
            $transactions->where('category_id', $request->category_id);
        }
        if ($request->has('currency_id')) {
            $transactions->where('currency_id', $request->currency_id);
        }
        if(count($transactions->get())>0){
            return responder()->success($transactions);
        }

        return responder()
            ->error
            (
                Config::get('constants.ERROR_CODES.RESOURCE_NOT_FOUND'),
                Config::get('constants.HTTP_CODES.RESOURCE_NOT_FOUND'),
                Config::get('constants.ERROR_MESSAGES.RESOURCE_NOT_FOUND')
            );
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
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
            'note' => 'nullable|max:255',
            'location' => 'nullable|max:255',
            'reminder_date' => 'nullable|date',
            'reportable' => 'required|boolean',
            'currency_id' => 'required|integer|exists:currencies,id',
            'category_id' => 'required|integer|exists:categories,id',
            'wallet_id' => 'required|integer|exists:wallets,id',
        ]);

        if ($validator->fails()) {
            return responder()
                ->error
                (Config::get('constants.ERROR_CODES.VALIDATION_FAILED'),
                    Config::get('constants.HTTP_CODES.VALIDATION_FAILED'),
                    Config::get('constants.ERROR_MESSAGES.VALIDATION_FAILED')
                );
        }

        $transaction = new Transaction();
        $transaction->amount = $request->amount;
        $transaction->transaction_date = $request->transaction_date;
        $transaction->note = $request->note;
        $transaction->location = $request->location;
        $transaction->reminder_date = $request->reminder_date;
        $transaction->reportable = $request->reportable;
        $transaction->currency_id = $request->currency_id;
        $transaction->category_id = $request->category_id;
        $transaction->wallet_id = $request->wallet_id;
        $transaction->save();

        return responder()->success(Config::get('constants.HTTP_CODES.SUCCESS'));
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

        return responder()
            ->error(
                Config::get('constants.ERROR_CODES.UNAUTHORIZED'),
                Config::get('constants.HTTP_CODES.UNAUTHORIZED'),
                Config::get('constants.ERROR_MESSAGES.UNAUTHORIZED')
            );
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
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
            'note' => 'nullable|max:255',
            'location' => 'nullable|max:255',
            'reminder_date' => 'nullable|date',
            'reportable' => 'required|boolean',
            'currency_id' => 'required|integer|exists:currencies,id',
            'category_id' => 'required|integer|exists:categories,id',
            'wallet_id' => 'required|integer|exists:wallets,id',
        ]);

        if ($validator->fails()) {
            return responder()
                ->error
                (Config::get('constants.ERROR_CODES.VALIDATION_FAILED'),
                    Config::get('constants.HTTP_CODES.VALIDATION_FAILED'),
                    Config::get('constants.ERROR_MESSAGES.VALIDATION_FAILED')
                );
        }

        $transaction = Transaction::findOrFail($id);
        $wallet = Wallet::findOrFail($transaction->wallet_id);

        if ($wallet->user_id == Auth::user()->id) {
            $transaction->fill($request->all());
            $transaction->save();

            return responder()->success(Config::get('constants.HTTP_CODES.SUCCESS'));
        }

        return responder()
            ->error(
                Config::get('constants.ERROR_CODES.UNAUTHORIZED'),
                Config::get('constants.HTTP_CODES.UNAUTHORIZED'),
                Config::get('constants.ERROR_MESSAGES.UNAUTHORIZED')
            );
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

            return responder()->success(Config::get('constants.HTTP_CODES.SUCCESS'));
        }

        return responder()
            ->error(
                Config::get('constants.ERROR_CODES.UNAUTHORIZED'),
                Config::get('constants.HTTP_CODES.UNAUTHORIZED'),
                Config::get('constants.ERROR_MESSAGES.UNAUTHORIZED')
            );
    }
}
