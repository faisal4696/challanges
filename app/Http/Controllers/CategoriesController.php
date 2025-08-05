<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Storage;

class CategoriesController extends Controller
{
	public function addcategory(Request $request)
	{

	}

    public function categories()
    {
    	// $basepath = 'http://192.168.10.3:8000';
    	$categories = Category::all();
    	return response()->json(['status'=>true,'categories'=>$categories]);
    }
}
