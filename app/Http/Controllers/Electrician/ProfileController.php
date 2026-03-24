<?php

namespace App\Http\Controllers\Electrician;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Load electrician data if user is an electrician
        if ($user->isElectrician()) {
            $user->load('electrician');
        }
        
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Base validation rules for all users
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
        ];

        // Add electrician-specific validation
        if ($user->isElectrician()) {
            $rules = array_merge($rules, [
                'business_name' => ['required', 'string', 'max:255'],
                'bio' => ['nullable', 'string', 'max:1000'],
                'years_experience' => ['nullable', 'integer', 'min:0', 'max:100'],
                'hourly_rate' => ['nullable', 'numeric', 'min:0'],
                'license_number' => ['nullable', 'string', 'max:100'],
                'service_areas' => ['nullable', 'array'],
                'service_areas.*' => ['string', 'max:100'],
            ]);
        }

        $validated = $request->validate($rules);

        // Update user basic info
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ];

        $user->update($userData);

        // Update electrician-specific data
        if ($user->isElectrician() && $user->electrician) {
            $electricianData = [
                'business_name' => $validated['business_name'],
                'bio' => $validated['bio'] ?? null,
                'years_experience' => $validated['years_experience'] ?? null,
                'hourly_rate' => $validated['hourly_rate'] ?? null,
                'license_number' => $validated['license_number'] ?? null,
            ];

            // Handle service areas (JSON field)
            if (isset($validated['service_areas'])) {
                $electricianData['service_areas'] = $validated['service_areas'];
            }

            $user->electrician->update($electricianData);
        }

        // If email was changed, require re-verification
        if ($user->wasChanged('email')) {
            $user->email_verified_at = null;
            $user->save();
            
            // Send email verification notification
            $user->sendEmailVerificationNotification();
            
            return redirect()->route('profile.edit')
                ->with('success', 'Profile updated successfully. Please verify your new email address.');
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update profile photo.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:2048'], // max 2MB
        ]);

        $user = Auth::user();

        // Store the photo
        $path = $request->file('photo')->store('profile-photos', 'public');

        // Delete old photo if exists
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->update([
            'profile_photo_path' => $path,
        ]);

        return back()->with('success', 'Profile photo updated successfully.');
    }

    /**
     * Delete profile photo.
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $user->update(['profile_photo_path' => null]);
        }

        return back()->with('success', 'Profile photo removed successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Check if user has active bookings
        if ($user->isClient()) {
            $activeBookings = $user->clientBookings()
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();
            
            if ($activeBookings) {
                return back()->with('error', 'Cannot delete account with active bookings. Please cancel or complete them first.');
            }
        }

        if ($user->isElectrician() && $user->electrician) {
            $activeBookings = $user->electrician->bookings()
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();
            
            if ($activeBookings) {
                return back()->with('error', 'Cannot delete account with active bookings. Please complete them first.');
            }
        }

        // Logout the user
        Auth::logout();

        // Delete the user
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }

    /**
     * Show the change password form.
     */
    public function showChangePasswordForm()
    {
        return view('profile.change-password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Password changed successfully.');
    }
}