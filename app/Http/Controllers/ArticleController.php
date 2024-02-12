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
        // get latest articles by user id
        $data['articles'] = Article::where('user_id', getUserID())->latest()->get();

        // redirect to articles index view with data
        return view('articles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // redirect to create article view
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'image' => 'required|image',
            'title' => 'required',
            'slug' => 'required|unique:articles,slug,NULL,id,deleted_at,NULL',
            'content' => 'required|summernote_required',
        ]);

        // collect data request except image
        $data = $request->except('_method', '_token', 'image');

        // Set Destination folder to save image
        $destination = 'assets/attachments/article_thumbnails/';

        // get file image from request
        $file = $request->file('image');

        // if file exists
        if ($file) {
            // set file name with unique id and time
            $file_name = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

            // Move file to destination folder
            $move = $file->move($destination, $file_name);

            // if move success
            if ($move) {
                // collect image path to data
                $data['image'] = $destination.$file_name;
            }
        }

        // collect data publication date with time now
        $data['publication_date'] = date('Y-m-d H:i:s');

        // create article
        $article = Article::create($data);

        // redirect to articles index page with success message
        return redirect('/admin/articles')->with('success', 'Article Saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        // get article by slug
        $data['article'] = Article::where('slug', $slug)->first();

        // if article exists
        if ($data['article']) {
            // redirect to detail view with data
            return view('public.detail', $data);
        }

        // if article not exists, return 404
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // get article by id and user id
        $data['article'] = Article::where('id', $id)->where('user_id', getUserID())->first();

        // if article exists
        if ($data['article']) {
            // redirect to edit view with data
            return view('articles.edit', $data);
        }

        // if article not exists, return 404
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // validation
        $request->validate([
            'image' => 'nullable|image',
            'title' => 'required',
            'slug' => 'required|unique:articles,slug,'.$id.',id,deleted_at,NULL',
            'content' => 'required|summernote_required',
        ]);
        // dd($request->get('content'));
        // collect data request except image
        $data = $request->except('_method', '_token', 'image');

        // get article by id and user id
        $article = Article::where('id', $id)->where('user_id', getUserID())->first();

        // if article exists
        if ($article) {
            // Set Destination folder to save image
            $destination = 'assets/attachments/article_thumbnails/';

            // get file image from request
            $file = $request->file('image');

            // if file exists
            if ($file) {
                // set file name with unique id and time
                $file_name = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

                // Move file to destination folder
                $move = $file->move($destination, $file_name);

                // if move success
                if ($move) {
                    // collect image path to data
                    $data['image'] = $destination.$file_name;
                }
            }

            // update article
            $article->update($data);

            // redirect to articles index page with success message
            return redirect('/admin/articles')->with('success', 'Article Updated!');
        }

        // if article not exists, return 404
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // get article by id and user id
        $article = Article::where('id', $id)->where('user_id', getUserID())->first();

        // if article exists
        if ($article) {
            // delete article
            $article->delete();

            // redirect to articles index page with success message
            return redirect('/admin/articles')->with('success', 'Article Deleted!');
        }

        // if article not exists, return 404
        abort(404);

    }

    function getPublicArticles($limit = 10, $search = null)
    {
        // set latest articles with user
        $articles = Article::with('user')->latest();

        // if limit not all
        if ($limit != 'all') {
            // set limit articles
            $articles = $articles->limit($limit);
        }

        // if search not null
        if ($search) {
            // set search articles by title or content
            $articles = $articles->where('title', 'like', '%'.$search.'%')->orWhere('content', 'like', '%'.$search.'%');
        }

        // get articles
        $articles = $articles->get();

        // return articles as json
        return response()->json($articles);
    }
}
