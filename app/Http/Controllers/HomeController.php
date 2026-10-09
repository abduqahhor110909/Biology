<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Article;
use App\Models\Webinar;
use App\Models\StatsCounter;
use App\Models\QuizQuestion;
use App\Models\Inquiry;

class HomeController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::getAllKeyValues();
        
        $stats = StatsCounter::orderBy('sort_order')->get();
        $categories = Category::withCount('articles')->orderBy('sort_order')->get();
        $articles = Article::with('category')->where('is_published', true)->orderBy('is_featured', 'desc')->latest()->take(6)->get();
        $webinars = Webinar::where('is_active', true)->orderBy('sort_order')->get();
        
        $heroBanner = Banner::where('position', 'hero_bottom')->where('is_active', true)->first();
        $middleBanner = Banner::where('position', 'middle_feed')->where('is_active', true)->first();
        $allBanners = Banner::where('is_active', true)->orderBy('sort_order')->get();
        
        $quizzes = QuizQuestion::inRandomOrder()->take(5)->get();

        return view('home', compact(
            'settings',
            'stats',
            'categories',
            'articles',
            'webinars',
            'heroBanner',
            'middleBanner',
            'allBanners',
            'quizzes'
        ));
    }

    public function article($slug)
    {
        $settings = SiteSetting::getAllKeyValues();
        $article = Article::with('category')->where('slug', $slug)->firstOrFail();
        $article->increment('views_count');

        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('is_published', true)
            ->take(3)
            ->get();

        return view('article', compact('settings', 'article', 'relatedArticles'));
    }

    public function submitInquiry(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'interest' => 'nullable|string|max:150',
            'message' => 'nullable|string|max:1000',
        ]);

        Inquiry::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Arizangiz muvaffaqiyatli qabul qilindi! Tez orada mutaxassisimiz siz bilan bog\'lanadi.',
            ]);
        }

        return redirect()->back()->with('success', 'Arizangiz muvaffaqiyatli qabul qilindi! Tez orada mutaxassisimiz siz bilan bog\'lanadi.');
    }
}
