<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Loan;
use App\Models\Transaction;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        $totalUsers = User::where('is_admin', 0)->count();
        $pendingUsers = User::where('status', 'pending')->where('is_admin', 0)->count();
        $totalBalance = Transaction::where('status', 'completed')->sum('amount');
        $pendingLoans = Loan::where('status', 'pending')->count();

        return view('admin.dashboard', compact('totalUsers', 'pendingUsers', 'totalBalance', 'pendingLoans'));
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'approved';
        $user->approved_at = now();
        $user->save();

        return redirect('/admin/users')->with('success', __('admin.user_approved'));
    }

    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'rejected';
        $user->save();

        return redirect('/admin/users')->with('success', __('admin.user_rejected'));
    }

    public function approveLoan($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->status = 'approved';
        $loan->approved_at = now();
        $loan->admin_id = Auth::id();
        $loan->save();

        return redirect('/admin/loans')->with('success', __('admin.loan_approved'));
    }

    public function rejectLoan($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->status = 'rejected';
        $loan->admin_id = Auth::id();
        $loan->save();

        return redirect('/admin/loans')->with('success', __('admin.loan_rejected'));
    }

    public function transactions()
    {
        $transactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.transactions', compact('transactions'));
    }

    public function settings()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string',
            'site_email' => 'required|email',
            'default_language' => 'required|in:bn,en',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect('/admin/settings')->with('success', __('admin.settings_updated'));
    }
}
