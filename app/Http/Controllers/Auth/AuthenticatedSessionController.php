<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\VerificationTwoFactor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Handle 2FA Authentication
     */
    public function store2FA(Request $request): RedirectResponse
    {
        $credential = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($credential)) {
            $user = Auth::user();
            $verification_code = random_int(100000, 999999);
            session(['verification_code' => $verification_code, 'user_id' => $user->id]);

            // send verification code via email
            Mail::to($user->email)->send(new VerificationTwoFactor($verification_code));
            Auth::logout();

            return redirect()->route("app.view.verification.login")->with('status', 'Verification code has been sent to your email.');
        }

        return redirect()->back()->withErrors([
            'email' => "Invalid email and password.",
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
