<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')->latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'read_time' => 'nullable|string|max:50',
            'image_file' => 'nullable|image|max:4096',
            'image_url' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . rand(100, 999);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_published'] = $request->has('is_published');
        $validated['read_time'] = $validated['read_time'] ?? '5 daqiqa';

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'art_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $validated['image'] = '/images/' . $fileName;
        } elseif (!empty($request->image_url)) {
            $validated['image'] = $request->image_url;
        } else {
            $validated['image'] = '/images/hero-banner.jpg';
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Biologiya maqolasi muvaffaqiyatli saqlandi!');
    }

    public function edit(Article $article)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'read_time' => 'nullable|string|max:50',
            'image_file' => 'nullable|image|max:4096',
            'image_url' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'art_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $validated['image'] = '/images/' . $fileName;
        } elseif (!empty($request->image_url)) {
            $validated['image'] = $request->image_url;
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Maqola muvaffaqiyatli yangilandi!');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Maqola o\'chirildi.');
    }
}
