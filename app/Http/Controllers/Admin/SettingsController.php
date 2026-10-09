<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::getAllKeyValues();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', 'hero_image_file', 'logo_image_file']);

        // Handle Hero Image upload if provided
        if ($request->hasFile('hero_image_file')) {
            $file = $request->file('hero_image_file');
            $fileName = 'hero_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $data['hero_image'] = '/images/' . $fileName;
        }

        // Save each key
        foreach ($data as $key => $val) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $val]
            );
        }

        return redirect()->back()->with('success', 'Sayt sozlamalari, ijtimoiy tarmoq linklari va dizayn parametrlari muvaffaqiyatli saqlandi!');
    }
}
