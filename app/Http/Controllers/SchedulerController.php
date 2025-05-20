<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchedulerSetting;

class SchedulerController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'day_of_week' => 'required|string|in:sun,mon,tue,wed,thu,fri,sat',
            'hour' => 'required|integer|min:0|max:23',
            'minute' => 'required|integer|min:0|max:59',
        ]);

        $setting = SchedulerSetting::first();

        if ($setting) {
            $setting->update($validated);
        } else {
            SchedulerSetting::create($validated);
        }

        return redirect()->back()->with('success', '✅ Jadwal scheduler berhasil disimpan.');
    }
}
