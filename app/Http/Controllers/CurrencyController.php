<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Transformers\CurrencyTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()!=null) {
            $currencies = Currency::all();

            if($request->has('name') ){
                $currencies=$currencies->where('name',$request->input('name'));
            }

            if($request->has('code')){
                $currencies=$currencies->where('code',$request->input('code'));
            }


            if (count($currencies) > 0) {
                return responder()->transform($currencies, new CurrencyTransformer())->respond();
            }
            return responder()
                ->error
                (
                    Config::get('constants.ERROR_CODES.RESOURCE_NOT_FOUND'),
                    Config::get('constants.HTTP_CODES.RESOURCE_NOT_FOUND'),
                    Config::get('constants.ERROR_MESSAGES.RESOURCE_NOT_FOUND')
                );
        }
        return responder()
            ->error(
                Config::get('constants.ERROR_CODES.UNAUTHORIZED'),
                Config::get('constants.HTTP_CODES.UNAUTHORIZED'),
                Config::get('constants.ERROR_MESSAGES.UNAUTHORIZED')
            );
    }

    public function show($id)
    {
        if(Auth::user()!=null) {
            $currency = Category::findOrfail($id);
            return responder()->transform($currency, new CurrencyTransformer())->respond();
        }
        return responder()
            ->error(
                Config::get('constants.ERROR_CODES.UNAUTHORIZED'),
                Config::get('constants.HTTP_CODES.UNAUTHORIZED'),
                Config::get('constants.ERROR_MESSAGES.UNAUTHORIZED')
            );
    }
}
