<?php

namespace App\Http\Controllers;

use App\Wallet;
use App\Currency;
use App\Transformers\WalletTransformer;
use App\Transformers\WalletListTransformer;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $wallets = Wallet::where('user_id', Auth::user()->id);

        if ($request->has('name')) {
            $wallets->where('name', $request->name);
        }

        if ($request->has('withCategory')) {
            $wallets->whereHas('transactions', function ($query) use ($request) {
                $query->where('category_id', $request->withCategory);
            });
        }

        if ($request->has('withCurrency')) {
            $wallets->whereHas('transactions', function ($query) use ($request) {
                $query->where('currency_id', $request->withCurrency);
            });
        }

        return responder()->transform($wallets->paginate(5), new WalletListTransformer)->respond();
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
            'name' => 'required|max:255',
            'description' => 'nullable|max:255',
        ]);

        if ($validator->fails()) {
            return responder()
                ->error
                (
                    Config::get('constants.ERROR_CODES.VALIDATION_FAILED'),
                    Config::get('constants.HTTP_CODES.VALIDATION_FAILED'),
                    Config::get('constants.ERROR_MESSAGES.VALIDATION_FAILED')
                );
        }

        $wallet = new Wallet;
        $wallet->name = $request->name;
        $wallet->description = $request->description;
        $wallet->user_id = Auth::user()->id;
        $wallet->save();

        return responder()->success(Config::get('constants.HTTP_CODES.SUCCESS'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wallet = Wallet::findOrFail($id);

        if (Auth::user()->can('show', $wallet)) {
            $wallet->balances = $this->getBalance($wallet);

            return responder()->transform($wallet, new WalletTransformer)->include('transactions')->respond();
        }

        return responder()
            ->error(
                Config::get('constants.ERROR_CODES.UNAUTHORIZED'),
                Config::get('constants.HTTP_CODES.UNAUTHORIZED'),
                Config::get('constants.ERROR_MESSAGES.UNAUTHORIZED')
            );
    }

    /**
     * Update the specified resource in storage partially.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|max:255',
            'description' => 'sometimes|max:255'
        ]);

        if ($validator->fails()) {
            return responder()
                ->error
                (
                    Config::get('constants.ERROR_CODES.VALIDATION_FAILED'),
                    Config::get('constants.HTTP_CODES.VALIDATION_FAILED'),
                    Config::get('constants.ERROR_MESSAGES.VALIDATION_FAILED')
                );
        }

        $wallet = Wallet::findOrFail($id);

        if ($wallet->user_id == Auth::user()->id) {
            $wallet->fill($request->all());
            $wallet->save();

            return responder()->success();
        }

        return responder()
            ->error
            (
                Config::get('constants.ERROR_CODES.UNAUTHORIZED'),
                Config::get('constants.HTTP_CODES.UNAUTHORIZED'),
                Config::get('constants.ERROR_MESSAGES.UNAUTHORIZED')
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wallet = Wallet::findOrFail($id);

        if ($wallet->user_id == Auth::user()->id) {
            $wallet->delete();

            return responder()->success();
        }

        return responder()
            ->error(
                Config::get('constants.ERROR_CODES.UNAUTHORIZED'),
                Config::get('constants.HTTP_CODES.UNAUTHORIZED'),
                Config::get('constants.ERROR_MESSAGES.UNAUTHORIZED')
            );
    }

    /**
     * Get the wallet balance.
     */
    private function getBalance($wallet)
    {
        $incomeTransactions = $wallet->transactions()->join("categories", "transactions.category_id", "=", "categories.id")
            ->where("categories.type", "=", "income")->get();

        $expenseTransactions = $wallet->transactions()->join("categories", "transactions.category_id", "=", "categories.id")
            ->where("categories.type", "=", "expense")->get();

        $incomes = array();
        foreach ($incomeTransactions as $transaction) {
            if (array_key_exists($transaction->currency_id, $incomes)) {
                $incomes[$transaction->currency_id] = $incomes[$transaction->currency_id] + $transaction->amount;
            } else {
                $incomes[$transaction->currency_id] = $transaction->amount;
            }
        }

        $expenses = array();
        foreach ($expenseTransactions as $transaction) {
            if (array_key_exists($transaction->currency_id, $expenses)) {
                $expenses[$transaction->currency_id] = $expenses[$transaction->currency_id] + $transaction->amount;
            } else {
                $expenses[$transaction->currency_id] = $transaction->amount;
            }
        }

        $balances = array();
        foreach ($incomes as $key => $income) {
            $currency_code = Currency::findOrFail($key)->code;

            if (array_key_exists($key, $expenses)) {
                $balances[$currency_code] = $income - $expenses[$key];
                unset($expenses[$key]);
            } else {
                $balances[$currency_code] = $income;
            }
        }

        if (count($expenses) != 0) {
            foreach ($expenses as $key => $expense) {
                $currency_code = Currency::findOrFail($key)->code;

                $balances[$currency_code] = $expense * (-1);
            }
        }

        return $balances;
    }
}
