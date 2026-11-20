<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Show account and application settings.
     */
    public function index(Request $request): View
    {
        return view('settings.index', [
            'user' => $request->user(),
            'capsulesCount' => $request->user()->capsules()->count(),
        ]);
    }

    /**
     * Update settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'timezone' => ['required', 'string', 'timezone'],
        ], [
            'timezone.required' => 'يرجى اختيار المنطقة الزمنية.',
            'timezone.timezone' => 'المنطقة الزمنية المحددة غير صحيحة.',
        ]);

        $request->user()->update([
            'timezone' => $request->input('timezone'),
        ]);

        return back()->with('status', 'تم حفظ الإعدادات بنجاح.');
    }
}
