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
            return responder()->error('Not Found', 404, "Category not found");
        }
        return responder()->error('unauthorized', 403, "You are not authorized to make this request.");
    }

    public function show($id)
    {
        if(Auth::user()!=null) {
        $category = Category::findOrfail($id);
            return responder()->transform($category, new CategoryTransformer)->respond();
        }
        return responder()->error('unauthorized', 403, "You are not authorized to make this request.");
    }
}
