<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return Auth::user()->is_admin ? redirect('/admin/dashboard') : redirect('/user/dashboard');
        }
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($validated)) {
            $user = Auth::user();
            if ($user->is_admin) {
                return redirect('/admin/dashboard');
            } elseif ($user->status === 'approved') {
                return redirect('/user/dashboard');
            } else {
                Auth::logout();
                return redirect('/auth/login')->with('error', __('auth.pending_approval'));
            }
        }

        return redirect('/auth/login')->with('error', __('auth.invalid_credentials'));
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.register');
    }

    public function doRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|string|min:10',
            'password' => 'required|string|min:6|confirmed',
            'address' => 'required|string|min:5',
            'photo' => 'required|image|max:2048',
            'nid_image' => 'nullable|image|max:5120',
            'birth_certificate' => 'nullable|image|max:5120',
        ]);

        // Validate at least NID or Birth Certificate
        if (!$request->hasFile('nid_image') && !$request->hasFile('birth_certificate')) {
            return redirect('/auth/register')->with('error', __('auth.nid_or_bc_required'));
        }

        // Upload files
        $photoPath = $request->file('photo')->store('users/photos', 'public');

        $nidPath = null;
        if ($request->hasFile('nid_image')) {
            $nidPath = $request->file('nid_image')->store('users/nid', 'public');
        }

        $bcPath = null;
        if ($request->hasFile('birth_certificate')) {
            $bcPath = $request->file('birth_certificate')->store('users/bc', 'public');
        }

        // Create User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'address' => $validated['address'],
            'password' => Hash::make($validated['password']),
            'photo' => $photoPath,
            'nid_image' => $nidPath,
            'birth_certificate' => $bcPath,
            'tracking_code' => User::generateTrackingCode(),
            'status' => 'pending',
            'is_admin' => 0,
        ]);

        return redirect('/auth/login')->with('success', __('auth.registration_success'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }

    public function forgotPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Send password reset email
        // This is simplified - implement proper password reset flow

        return redirect('/auth/login')->with('success', __('auth.reset_link_sent'));
    }
}
