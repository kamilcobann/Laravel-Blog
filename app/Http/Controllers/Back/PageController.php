<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use File;
class PageController extends Controller
{
    //
    public function index()
    {
        $pages = Page::all();
        return view('back.page.index', compact('pages'));
    }

    public function switch(Request $request)
    {
        $page = Page::findOrFail($request->id);
        $page->status = $request->statu == "true" ? 1 : 0;
        $page->save();
    }


    public function create()
    {
        return view('back.page.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $last = Page::orderBy('order', 'desc')->first();



        $page = new Page;
        $page->title = $request->title;
        $page->content = $request->content;
        $page->order = $last->order + 1;
        $page->slug = $request->title;

        if ($request->hasFile('image')) {
            $imageName = str_slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);
            $page->image = 'uploads/' . $imageName;
        }
        $page->save();

        toastr()->success('Sayfa oluşturuldu');
        return redirect()->route('admin.page.index');
    }


    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('back.page.update', compact('page'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'image|mimes:jpeg,png,jpg',

        ]);
        $page = Page::findOrFail($id);

        $page->title = $request->title;
        $page->content = $request->content;
        $page->slug = str_slug($request->title);

        if ($request->hasFile('image')) {
            $image_name = str_slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $image_name);
            $page->image = 'uploads/' . $image_name;
        }
        $page->save();
        toastr()->success('Başarılı', 'Sayfa başarıyla güncellendi');
        return redirect()->route('admin.page.index');
    }


    public function delete($id)
    {
        
        $page = Page::find($id);
        if(File::exists($page->image))
        {
            File::delete(public_path($page->image));
        }
        $page->delete();
        toastr()->success("Sayfa tamamen silindi");
        return redirect()->back();
    

    }
}
