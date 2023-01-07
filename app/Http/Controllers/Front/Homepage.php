<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Article;


class Homepage extends Controller
{
    //
    public function index(){
        
        $data['articles'] = Article::orderBy('created_at','DESC')->paginate(2);
        $data['articles']->withPath(url('sayfa'));
        $data['categories'] = Category::inRandomOrder()->get();
        
        return view('front.homepage',$data);
    }

    public function single($category,$slug)
    {
        $category = Category::whereSlug($category)->first() ?? abort(403,"Category doesn't exist");
        $article = Article::whereSlug($slug)->whereCategoryId($category->id)->first() ?? abort(403,"Article doesn't exist");
        $article->increment('hit');


        $data['article'] = $article;
        $data['categories'] = Category::inRandomOrder()->get();
        return view('front.single',$data);
    }

    public function category($slug)
    {
        $category = Category::whereSlug($slug)->first() ?? abort(403,"Category doesn't exist");
        $data['category'] = $category;
        $data['articles'] = Article::where('category_id',$category->id)->orderBy('created_at','DESC')->paginate(1);
        $data['categories'] = Category::inRandomOrder()->get();
        return view('front.category',$data);
    }
}
