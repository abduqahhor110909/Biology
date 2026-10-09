<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = Inquiry::latest();

        if ($status && in_array($status, ['new', 'contacted', 'completed'])) {
            $query->where('status', $status);
        }

        $inquiries = $query->paginate(15);
        $counts = [
            'all' => Inquiry::count(),
            'new' => Inquiry::where('status', 'new')->count(),
            'contacted' => Inquiry::where('status', 'contacted')->count(),
            'completed' => Inquiry::where('status', 'completed')->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'counts', 'status'));
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,completed',
        ]);

        $inquiry->update($validated);

        return redirect()->back()->with('success', 'Ariza holati yangilandi.');
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->back()->with('success', 'Ariza o\'chirildi.');
    }
}
