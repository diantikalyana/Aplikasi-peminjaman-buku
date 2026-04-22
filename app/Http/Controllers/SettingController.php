<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'fine_per_day' => 'required|integer|min:0'
        ]);

        $setting = Setting::first();

        if (!$setting) {
            Setting::create([
                'fine_per_day' => $request->fine_per_day
            ]);
        } else {
            $setting->update([
                'fine_per_day' => $request->fine_per_day
            ]);
        }

        return back()->with('success', 'Denda berhasil diubah');
    }
}