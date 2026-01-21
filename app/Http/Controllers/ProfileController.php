<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('pages.profile', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = Auth::user();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('photo'), $filename);

            // check if user has old photo
            if ($user->photo) {
                $this->deleteOldPhoto($user->photo);
            }
            $validated['photo'] = $filename;
        }

        $user->update($validated);
        $notification = array(
            'message' => 'Your profile has been updated.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    /**
     * Delete Old Photo
     */
    private function deleteOldPhoto(string $file) : void
    {
        $fullPath = public_path('photo/' . $file);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
