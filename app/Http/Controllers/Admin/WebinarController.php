<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Webinar;

class WebinarController extends Controller
{
    public function index()
    {
        $webinars = Webinar::orderBy('sort_order')->latest()->paginate(10);
        return view('admin.webinars.index', compact('webinars'));
    }

    public function create()
    {
        return view('admin.webinars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'badge' => 'nullable|string|max:100',
            'instructor_name' => 'required|string|max:150',
            'instructor_title' => 'nullable|string|max:255',
            'date_time_text' => 'required|string|max:100',
            'duration' => 'nullable|string|max:50',
            'is_free' => 'nullable|boolean',
            'price_text' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
            'join_link' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'image_file' => 'nullable|image|max:4096',
            'image_url' => 'nullable|string|max:255',
        ]);

        $validated['is_free'] = $request->has('is_free');
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'web_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $validated['image'] = '/images/' . $fileName;
        } elseif (!empty($request->image_url)) {
            $validated['image'] = $request->image_url;
        } else {
            $validated['image'] = '/images/promo-banner.jpg';
        }

        Webinar::create($validated);

        return redirect()->route('admin.webinars.index')->with('success', 'Vebinar muvaffaqiyatli qo\'shildi!');
    }

    public function edit(Webinar $webinar)
    {
        return view('admin.webinars.edit', compact('webinar'));
    }

    public function update(Request $request, Webinar $webinar)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'badge' => 'nullable|string|max:100',
            'instructor_name' => 'required|string|max:150',
            'instructor_title' => 'nullable|string|max:255',
            'date_time_text' => 'required|string|max:100',
            'duration' => 'nullable|string|max:50',
            'is_free' => 'nullable|boolean',
            'price_text' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
            'join_link' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'image_file' => 'nullable|image|max:4096',
            'image_url' => 'nullable|string|max:255',
        ]);

        $validated['is_free'] = $request->has('is_free');
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'web_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $validated['image'] = '/images/' . $fileName;
        } elseif (!empty($request->image_url)) {
            $validated['image'] = $request->image_url;
        }

        $webinar->update($validated);

        return redirect()->route('admin.webinars.index')->with('success', 'Vebinar muvaffaqiyatli yangilandi!');
    }

    public function destroy(Webinar $webinar)
    {
        $webinar->delete();
        return redirect()->route('admin.webinars.index')->with('success', 'Vebinar o\'chirildi.');
    }
}
