<?php

namespace App\Http\Controllers;

use App\Wallet;
use App\Transformers\WalletTransformer;
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
    public function index()
    {
        $wallets = Wallet::where('user_id', Auth::user()->id)->paginate(5);

        return responder()->transform($wallets, new WalletTransformer)->respond();
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
            'reportable' => 'nullable|boolean',
            'currency_id' => 'required|integer|exists:currencies,id',
            'wallet_type_id' => 'required|integer|exists:wallet_types,id'
        ]);

        if ($validator->fails()) {
            return responder()->error('validation_failed', 422);
        }

        $wallet = new Wallet;
        $wallet->name = $request->name;
        $wallet->description = $request->description;
        $wallet->reportable = $request->reportable;
        $wallet->currency_id = $request->currency_id;
        $wallet->wallet_type_id = $request->wallet_type_id;
        $wallet->user_id = Auth::user()->id;
        $wallet->save();

        return responder()->success(201);
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
            return responder()->transform($wallet, new WalletTransformer)->include('transactions')->respond();
        }

        return responder()->error('unauthorized', 403);
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
            'description' => 'sometimes|max:255',
            'reportable' => 'sometimes|boolean',
            'currency_id' => 'sometimes|integer|exists:currencies,id',
            'wallet_type_id' => 'sometimes|integer|exists:wallet_types,id'
        ]);

        if ($validator->fails()) {
            return responder()->error('validation_failed', 422);
        }

        $wallet = Wallet::findOrFail($id);

        if ($wallet->user_id == Auth::user()->id) {
            $wallet->fill($request->all());
            $wallet->save();

            return responder()->success();
        }

        return responder()->error('unauthorized', 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function modify(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'nullable|max:255',
            'reportable' => 'nullable|boolean',
            'currency_id' => 'required|integer|exists:currencies,id',
            'wallet_type_id' => 'required|integer|exists:wallet_types,id'
        ]);

        if ($validator->fails()) {
            return responder()->error('validation_failed', 422);
        }

        $wallet = Wallet::findOrFail($id);

        if ($wallet->user_id == Auth::user()->id) {
            $wallet->fill($request->all());
            $wallet->save();

            return responder()->success();
        }

        return responder()->error('unauthorized', 403);
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

        return responder()->error('unauthorized', 403);
    }
}
