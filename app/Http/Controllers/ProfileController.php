<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Peminjaman;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Handle Photo Upload
        if ($request->hasFile('photo')) {
            $request->validate(['photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048']);
            
            // Delete old photo
            if ($request->user()->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($request->user()->photo);
            }

            $path = $request->file('photo')->store('profiles', 'public');
            $request->user()->photo = $path;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function downloadQr(Request $request)
    {
        $user = $request->user();

        // Get active loans for the QR summary
        $currentLoans = Peminjaman::where('user_id', $user->id)
                        ->where('status', 'dipinjam')
                        ->with('barang')
                        ->get();

        if ($currentLoans->count() > 0) {
            $loanSummary = "Status Peminjaman " . $user->name . " (" . date('d-m-Y') . "):\n";
            foreach ($currentLoans as $index => $loan) {
                $loanSummary .= ($index + 1) . ". " . $loan->barang->nama . "\n";
            }
        } else {
            $loanSummary = "Member Valid: " . $user->name . "\nID: " . $user->id . "\nTidak ada barang dipinjam.";
        }

        return view('profile.qr', compact('user', 'loanSummary'));
    }
}
