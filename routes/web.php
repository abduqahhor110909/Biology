<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\WebinarController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\InquiryController;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/maqola/{slug}', [HomeController::class, 'article'])->name('article.show');
Route::post('/ariza-yuborish', [HomeController::class, 'submitInquiry'])->name('inquiry.submit');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Sozlamalar (Settings, social links, hero, etc.)
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Reklamalar va Bannerlar (Banners & Ads)
    Route::resource('banners', BannerController::class);
    Route::post('banners/{banner}/toggle', [BannerController::class, 'toggle'])->name('banners.toggle');

    // Maqolalar (Articles & Topics)
    Route::resource('articles', ArticleController::class);

    // Vebinarlar (Webinars & Lessons)
    Route::resource('webinars', WebinarController::class);

    // Statistika hisoblagichlari (Stats Counter)
    Route::get('/stats', [StatsController::class, 'index'])->name('stats');
    Route::post('/stats', [StatsController::class, 'update'])->name('stats.update');

    // Arizalar (Inquiries / Leads)
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries');
    Route::patch('/inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.status');
    Route::delete('/inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');
});
