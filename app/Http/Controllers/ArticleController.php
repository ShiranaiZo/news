<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['articles'] = Article::where('user_id', getUserID())->latest()->get();

        return view('articles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Example of validation
        $request->validate([
            'image' => 'required|image',
            'title' => 'required',
            'slug' => 'required|unique:articles,slug,NULL,id,deleted_at,NULL',
            'content' => 'required',
        ]);

        $data = $request->except('_method', '_token', 'image');

        $destination = 'assets/attachments/article_thumbnails/';

        $file = $request->file('image');

        if ($file) {
            $file_name = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();
            $move = $file->move($destination, $file_name);

            if ($move) {
                $data['image'] = $destination.$file_name;
            }
        }

        $data['publication_date'] = date('Y-m-d H:i:s');

        $article = Article::create($data);

        return redirect('/admin/articles')->with('success', 'Article Saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $data['article'] = Article::where('slug', $slug)->first();

        if ($data['article']) {
            return view('public.detail', $data);
        }

        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['article'] = Article::where('id', $id)->where('user_id', getUserID())->first();

        if ($data['article']) {
            return view('articles.edit', $data);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image',
            'title' => 'required',
            'slug' => 'required|unique:articles,slug,'.$id.',id,deleted_at,NULL',
            'content' => 'required',
        ]);

        $data = $request->except('_method', '_token', 'image');

        $article = Article::where('id', $id)->where('user_id', getUserID())->first();

        if ($article) {
            $destination = 'assets/attachments/article_thumbnails/';

            $file = $request->file('image');

            if ($file) {
                $file_name = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();
                $move = $file->move($destination, $file_name);

                if ($move) {
                    $data['image'] = $destination.$file_name;
                }
            }

            $article->update($data);

            return redirect('/admin/articles')->with('success', 'Article Updated!');
        }

        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $article = Article::where('id', $id)->where('user_id', getUserID())->first();

        if ($article) {
            $article->delete();

            return redirect('/admin/articles')->with('success', 'Article Deleted!');
        }

        abort(404);

    }

    function getPublicArticles($limit = 10, $search = null)
    {
        $articles = Article::with('user')->latest();

        if ($limit != 'all') {
            $articles = $articles->limit($limit);
        }

        if ($search) {
            $articles = $articles->where('title', 'like', '%'.$search.'%')->orWhere('content', 'like', '%'.$search.'%');
        }

        $articles = $articles->get();

        return response()->json($articles);
    }
}
