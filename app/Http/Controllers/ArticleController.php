<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // List all articles
    public function index()
    {
        // Fetch articles from DB with pagination (5 per page)
        $articles = Article::orderBy('published_at', 'desc')->paginate(5);

        return view('home', compact('articles'));
    }

    // Show the create form
    public function create()
    {
        return view('articles.create');
    }

    // Store new article
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        Article::create($validated);

        return redirect()->route('articles.index')->with('success', 'Article created successfully!');
    }

    // Show a single article by ID
    public function show($id)
    {
        $article = Article::findOrFail($id);
        $previousArticle = Article::where('id', '<', $id)->orderBy('id', 'desc')->first();
        $nextArticle = Article::where('id', '>', $id)->orderBy('id')->first();
    
        return view('articles.show', compact('article', 'previousArticle', 'nextArticle'));
    }

    // Show edit form
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.edit', compact('article'));
    }

    // Update article
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($validated);

        return redirect()->route('articles.index')->with('success', 'Article updated successfully!');
    }

    // Delete article
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('articles.overview')->with('success', 'Article deleted successfully.');

    }

    public function overview() {
        // Get all articles, including published and unpublished
        $articles = Article::all();
        return view('articles.overview');
    }

    public function togglePublish($id)
    {
        $article = Article::findOrFail($id);
        $article->published = !$article->published;

        if ($article->published && !$article->published_at) {
            $article->published_at = now();
        }
        $article->save();

        return redirect()->route('articles.index')->with('success', 'Article status updated.');
    }
}
