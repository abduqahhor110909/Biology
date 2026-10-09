<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatsCounter;

class StatsController extends Controller
{
    public function index()
    {
        $stats = StatsCounter::orderBy('sort_order')->get();
        return view('admin.stats.index', compact('stats'));
    }

    public function update(Request $request)
    {
        $items = $request->input('counters', []);

        foreach ($items as $id => $data) {
            StatsCounter::where('id', $id)->update([
                'number' => $data['number'],
                'suffix' => $data['suffix'] ?? '+',
                'label' => $data['label'],
            ]);
        }

        return redirect()->back()->with('success', 'Statistika hisoblagichlari muvaffaqiyatli yangilandi!');
    }
}
