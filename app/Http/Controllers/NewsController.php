<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    
    public function index()
    {
        $news = News::all();
        $news = News::latest()->paginate(10);
        return view('news.index', compact('news'));
    }

     
    public function create()
    {
        return view('news.create');
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        News::create($request->all());
        return redirect()->route('news.index');
    }

    
    public function show(string $id)
    {
        $news = News::findOrFail($id);
        $comments = $news->comments()->latest()->paginate(5);
        return view('news.show', compact('news', 'comments'));
    }

    
    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('news.edit', compact('news'));
    }

   
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $news->update($request->all());

        return redirect()->route('news.index');
    }

   
    public function destroy(string $id)
    {
        if(auth()->user()->role !== 'admin') {
            abort(403, 'ban khong co quyen xoa tin tuc nay');
        } 
        $news = News::findOrFail($id);
        $news->delete();
        return redirect()->route('news.index');
    }
}
