<?php

namespace App\Http\Controllers;

use App\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        if($request->has('name') ){
            $categories=$categories->where('name',$request->input('name'));
        }

        if($request->has('type')){
            $categories=$categories->where('type',$request->input('type'));
        }

        if(count($categories)>0) {
            return responder()->transform($categories, new CategoryTransformer)->respond();
        }

        return responder()->error('Not Found', 404,"Category not found");

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $category = Category::findOrfail($id);

            return responder()->transform($category, new CategoryTransformer)->respond();

    }


    public function searchByName($name)
    {
        $categories = Category::where('name',$name);

        return responder()->transform($categories, new CategoryTransformer)->respond();

    }

    public function searchByType($type)
    {
        $categories = Category::where('type',$type);

        return responder()->transform($categories, new CategoryTransformer)->respond();

    }




}
