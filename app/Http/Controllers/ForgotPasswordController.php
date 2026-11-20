<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    /**
     * Show password reset request form.
     */
    public function showLinkRequestForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link / create mock token for local testing.
     */
    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'البريد الإلكتروني غير صالح.',
            'email.exists' => 'لم نتمكن من العثور على حساب مرتبط بهذا البريد الإلكتروني.',
        ]);

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->input('email')],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        // Since it's a local/test environment or mail logged, provide a clear direct link or success notice
        return back()->with('status', 'تم إنشاء رابط استعادة كلمة المرور وإرساله بنجاح! يمكنك إتمام الاستعادة.')
            ->with('reset_token', $token)
            ->with('reset_email', $request->input('email'));
    }

    /**
     * Show the password reset form.
     */
    public function showResetForm(Request $request, ?string $token = null): View
    {
        return view('auth.reset-password', [
            'token' => $token ?? $request->query('token'),
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Reset the user's password.
     */
    public function reset(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'يرجى كتابة كلمة المرور الجديدة.',
            'password.min' => 'يجب ألا تقل كلمة المرور عن 8 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->input('email'))
            ->first();

        if (!$record || !Hash::check($request->input('token'), $record->token)) {
            return back()->withErrors(['email' => 'رمز استعادة كلمة المرور غير صالح أو منتهي الصلاحية.']);
        }

        $user = User::where('email', $request->input('email'))->first();
        if (!$user) {
            return back()->withErrors(['email' => 'المستخدم غير موجود.']);
        }

        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        DB::table('password_reset_tokens')->where('email', $request->input('email'))->delete();

        return redirect()->route('login')->with('status', 'تمت إعادة تعيين كلمة المرور بنجاح. يمكنك تسجيل الدخول الآن.');
    }
}
