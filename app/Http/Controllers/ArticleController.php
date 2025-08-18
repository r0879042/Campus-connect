<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    // List all articles
    public function index(Request $request)
    {
        $q = $request->input('q');

        $articles = Article::query()
            ->where('published', true) // move this from the view to the query
            ->when($q, function ($query) use ($q) {
                $query->where(function ($q2) use ($q) {
                    $q2->where('title', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('published_at')
            ->paginate(5)          
            ->withQueryString(); 

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

    // Show the articles overview page
    public function overview()
    {
        // Get all articles (admin can see all, user may filter later)
        $articles = Article::all();

        return view('overview', compact('articles'));
    }

    // Delete an article
    public function delete(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'id' => 'required|exists:articles,id',
        ]);

        $article = Article::find($request->id);
        $article->delete();

        return redirect()->back()->with('success', 'Article deleted successfully.');
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
