<?php

namespace App\Http\Controllers\Back;

use App\Models\Category;
use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //

    public function index()
    {
        $categories = Category::all();
        return view('back.categories.index', compact('categories'));
    }

    public function switch(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = $request->statu == "true" ? 1 : 0;
        $category->save();
    }

    public function getCategory(Request $request)
    {
        $category = Category::findOrFail($request->id);
        return response()->json($category);
    }

    public function updateCategory(Request $request)
    {
        $isSlug = Category::whereSlug(str_slug($request->slug))->whereNotIn('id', [$request->id])->first();
        $isName = Category::whereName($request->name)->whereNotIn('id', [$request->id])->first();
        if ($isSlug || $isName) {
            toastr()->error('Kategori zaten var');
            return redirect()->refresh();
        }

        $category = Category::find($request->id);

        $category->name = $request->newcategory;
        $category->slug = str_slug($request->newslug);

        $category->save();
        toastr()->success('Kategori güncellendi');

        return redirect()->back();
    }

    public function create(Request $request)
    {

        $exists = Category::whereSlug(str_slug($request->category))->first();

        if ($exists) {
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

    public function delete(Request $request)
    {
        $category = Category::findOrFail($request->id);

        if ($category->id == 1) {
            toastr()->error('Bu kategori silinemez');
            return redirect()->back();
        }
        $count = $category->articleCount();
        if ($count > 0) {
            Article::where('category_id', $category->id)->update(['category_id' => 1]);
            $default = Category::find(1);
            toastr()->success('Kategori silindi', 'Bu kategoriye ait ' . $count . ' makale ' . $default->name . ' kategorisine taşındı.');
        }
        $category->delete();
        toastr()->success('Bu kategori silindi');
        return redirect()->back();
    }
}
