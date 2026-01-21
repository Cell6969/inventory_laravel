<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VerificationTwoFactorController extends Controller
{
    public function show() : View
    {
        return view("auth.two-factor-verification");
    }

    public function store(Request $request)
    {
        $request->validate([
            "code" => "required|numeric",
        ]);

        if ($request->code == session("verification_code")) {
            Auth::loginUsingId(session("user_id"));
            session()->forget(['user_id', 'verification_code']);
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(["code" => "Invalid verification code."]);
    }
}
