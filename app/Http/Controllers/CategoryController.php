<?php

namespace App\Http\Controllers;

use App\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()!=null) {
        $categories = Category::all();

        if($request->has('name') ){
            $categories=$categories->where('name',$request->input('name'));
        }

        if($request->has('type')){
            $categories=$categories->where('type',$request->input('type'));
        }


            if (count($categories) > 0) {
                return responder()->transform($categories, new CategoryTransformer)->respond();
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
        $category = Category::findOrfail($id);
            return responder()->transform($category, new CategoryTransformer)->respond();
        }
        return responder()
            ->error(
                Config::get('constants.ERROR_CODES.UNAUTHORIZED'),
                Config::get('constants.HTTP_CODES.UNAUTHORIZED'),
                Config::get('constants.ERROR_MESSAGES.UNAUTHORIZED')
            );
    }
}
