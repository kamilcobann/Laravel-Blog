<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use File;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at','ASC')->get();
        return view('back.articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view('back.articles.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg',

        ]);
        $article = new Article;

        $article->title = $request->title;
        $article->category_id = $request->category;
        $article->content = $request->content;
        $article->slug = str_slug($request->title);

        if($request->hasFile('image')){
            $image_name = str_slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$image_name);
            $article->image = 'uploads/'.$image_name;
        }
        $article->save();
        toastr()->success('Başarılı','Makale başarıyla oluşturuldu');
        return redirect()->route('admin.articles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('back.articles.update',compact('categories','article'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'image|mimes:jpeg,png,jpg',

        ]);
        $article =Article::findOrFail($id);

        $article->title = $request->title;
        $article->category_id = $request->category;
        $article->content = $request->content;
        $article->slug = str_slug($request->title);

        if($request->hasFile('image')){
            $image_name = str_slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$image_name);
            $article->image = 'uploads/'.$image_name;
        }
        $article->save();
        toastr()->success('Başarılı','Makale başarıyla güncellendi');
        return redirect()->route('admin.articles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        Article::find($id)->delete();
        toastr()->success("Makale geri dönüşüme taşındı");
        return redirect()->route('admin.articles.index');
    }

    public function switch(Request $request)
    {
        $article = Article::findOrFail($request->id);
        $article->status = $request->statu=="true" ? 1 : 0;
        $article->save();
    }


    public function trash()
    {
        $articles = Article::onlyTrashed()->orderBy('created_at','desc')->get();
        return view('back.articles.trash',compact('articles'));
    }


    public function recycle($id)
    {
        Article::onlyTrashed()->find($id)->restore();
        toastr()->success('Makale başarıyla geri döndürüldü.');
        return redirect()->back();
    }

    public function hardDelete($id)
    {
        $article = Article::onlyTrashed()->find($id);
        if(File::exists($article->image))
        {
            File::delete(public_path($article->image));
        }
        $article->forceDelete();
        toastr()->success("Makale tamamen silindi");
        return redirect()->back();
    }

}
