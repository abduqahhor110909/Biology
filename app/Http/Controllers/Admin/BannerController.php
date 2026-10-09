<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->latest()->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'badge' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'button_text' => 'required|string|max:100',
            'button_url' => 'required|string|max:255',
            'position' => 'required|string|in:hero_bottom,middle_feed,sidebar,footer',
            'bg_gradient' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'image_file' => 'nullable|image|max:4096',
            'image_url' => 'nullable|string|max:255',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'banner_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $validated['image'] = '/images/' . $fileName;
        } elseif (!empty($request->image_url)) {
            $validated['image'] = $request->image_url;
        } else {
            $validated['image'] = '/images/promo-banner.jpg';
        }

        Banner::create($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Reklama banneri muvaffaqiyatli qo\'shildi!');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'badge' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'button_text' => 'required|string|max:100',
            'button_url' => 'required|string|max:255',
            'position' => 'required|string|in:hero_bottom,middle_feed,sidebar,footer',
            'bg_gradient' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'image_file' => 'nullable|image|max:4096',
            'image_url' => 'nullable|string|max:255',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'banner_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $validated['image'] = '/images/' . $fileName;
        } elseif (!empty($request->image_url)) {
            $validated['image'] = $request->image_url;
        }

        $banner->update($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Reklama banneri yangilandi!');
    }

    public function toggle(Banner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);
        return redirect()->back()->with('success', 'Banner holati o\'zgartirildi.');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner o\'chirildi.');
    }
}
