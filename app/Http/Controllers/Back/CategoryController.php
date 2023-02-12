<?php

namespace App\Http\Controllers\Back;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //

    public function index()
    {
        $categories = Category::all();
        return view('back.categories.index',compact('categories'));
    }

    public function switch(Request $request)
    {
        $category=Category::findOrFail($request->id);
        $category->status = $request->statu=="true" ? 1 : 0;
        $category->save();
    }

    public function create(Request $request)
    {

        $exists = Category::whereSlug(str_slug($request->category))->first();
        
        if($exists){
            toastr()->error('Kategori zaten var');
            return redirect()->back();
        }

        $category = new Category;

        $category->name = $request->category;
        $category->slug = str_slug($request->category);

        $category->save();
        toastr()->success('Kategori oluşturuldu');

        return redirect()->back();
    }
}
