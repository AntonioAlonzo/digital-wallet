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
            return responder()->error('Not Found', 404, "Currency not found");
        }
        return responder()->error('unauthorized', 403, "You are not authorized to make this request.");
    }

    public function show($id)
    {
        if(Auth::user()!=null) {
            $currency = Category::findOrfail($id);
            return responder()->transform($currency, new CurrencyTransformer())->respond();
        }
        return responder()->error('unauthorized', 403, "You are not authorized to make this request.");
    }
}
