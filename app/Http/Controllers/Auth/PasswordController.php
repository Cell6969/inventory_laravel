<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            "old_password" => "required|string",
            "new_password" => "required|string|confirmed",
        ]);

        if (!Hash::check($request->old_password,$request->user()->password)) {
            $notification = array(
                "message" => "Your current password does not matches with the password you provided.",
                "alert-type" => "error"
            );

            return redirect()->back()->with($notification);
        }

        $request->user()->update([
            "password" => Hash::make($request->new_password)
        ]);

        $notification = array(
            "message" => "Password updated successfully.",
            "alert-type" => "success"
        );

        return back()->with($notification);
    }
}
