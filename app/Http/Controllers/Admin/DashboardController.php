<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Banner;
use App\Models\Webinar;
use App\Models\Inquiry;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'articles_count' => Article::count(),
            'banners_count' => Banner::where('is_active', true)->count(),
            'webinars_count' => Webinar::count(),
            'inquiries_count' => Inquiry::count(),
            'new_inquiries' => Inquiry::where('status', 'new')->count(),
            'total_views' => Article::sum('views_count'),
        ];

        $recentInquiries = Inquiry::latest()->take(6)->get();
        $recentArticles = Article::with('category')->latest()->take(5)->get();
        $activeBanners = Banner::latest()->take(4)->get();

        return view('admin.dashboard', compact('stats', 'recentInquiries', 'recentArticles', 'activeBanners'));
    }
}
