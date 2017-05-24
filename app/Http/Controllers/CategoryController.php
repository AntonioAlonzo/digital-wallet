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
    public function index()
    {
        $categories = Category::paginate(5);

        return responder()->transform($categories, new CategoryTransformer)->respond();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $category = Category::findOrFail($id);

        if ($category->user_id == Auth::user()->id) {
            return responder()->transform($category, new CategoryTransformer)->respond();
        }

        return responder()->error('unauthorized', 403);
    }


    public function searchByName($name)
    {
        $categories = Category::where('name',$name);
        $categories_result=null;

        foreach ($categories as $category) {

            if ($category->user_id == Auth::user()->id) {
                $categories_result[]=$category;
            }
        }
        if(count($categories_result)!=0) {
            return responder()->transform($categories_result, new CategoryTransformer)->respond();
        }

        return responder()->error('unauthorized', 403);
    }

    public function searchByType($type)
    {
        $categories = Category::where('type',$type);

        foreach ($categories as $category) {

            if ($category->user_id == Auth::user()->id) {
                $categories_result[]=$category;
            }
        }
        if(count($categories_result)!=0) {
            return responder()->transform($categories_result, new CategoryTransformer)->respond();
        }


        return responder()->error('unauthorized', 403);
    }




}
