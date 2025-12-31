<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DpsAccount;
use App\Models\Loan;
use App\Models\Transaction;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $dpsAccounts = $user->dpsAccounts()->count();
        $activeLoans = $user->loans()->where('status', 'approved')->count();
        $totalDeposited = Transaction::where('user_id', $user->id)
            ->where('type', 'dps_deposit')
            ->where('status', 'completed')
            ->sum('amount');

        return view('user.dashboard', compact('user', 'dpsAccounts', 'activeLoans', 'totalDeposited'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'mobile' => 'required|string|min:10',
            'address' => 'required|string|min:5',
            'photo' => 'nullable|image|max:2048',
        ]);

        $user->name = $validated['name'];
        $user->mobile = $validated['mobile'];
        $user->address = $validated['address'];

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('users/photos', 'public');
            $user->photo = $path;
        }

        $user->save();

        return redirect('/user/profile')->with('success', __('user.profile_updated'));
    }

    public function idCard()
    {
        $user = Auth::user();

        if ($user->status !== 'approved') {
            return redirect('/user/dashboard')->with('error', __('user.not_approved'));
        }

        return view('user.id-card', compact('user'));
    }

    public function downloadIdCard($format)
    {
        $user = Auth::user();

        if ($user->status !== 'approved') {
            abort(403);
        }

        if ($format === 'pdf') {
            // Generate PDF using MPDF or similar
            return $this->generateIdCardPdf($user);
        } else {
            return $this->generateIdCardImage($user);
        }
    }

    public function dps()
    {
        $user = Auth::user();
        $dpsAccounts = $user->dpsAccounts()->with('scheme')->get();
        return view('user.dps', compact('dpsAccounts'));
    }

    public function applyDps(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'scheme_id' => 'required|exists:dps_schemes,id',
        ]);

        $account = DpsAccount::create([
            'user_id' => $user->id,
            'dps_scheme_id' => $validated['scheme_id'],
            'account_number' => 'DPS-' . strtoupper(substr(md5(time()), 0, 8)),
            'status' => 'active',
            'started_at' => now(),
        ]);

        return redirect('/user/dps')->with('success', __('dps.applied'));
    }

    public function loan()
    {
        $user = Auth::user();
        $loans = $user->loans()->get();
        return view('user.loan', compact('loans'));
    }

    public function applyLoan(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'duration' => 'required|integer|min:3|max:60',
            'purpose_bn' => 'required|string',
            'purpose_en' => 'required|string',
        ]);

        $loan = Loan::create([
            'user_id' => $user->id,
            'amount' => $validated['amount'],
            'duration_months' => $validated['duration'],
            'interest_rate' => 5,
            'purpose_bn' => $validated['purpose_bn'],
            'purpose_en' => $validated['purpose_en'],
            'status' => 'pending',
        ]);

        return redirect('/user/loan')->with('success', __('loan.applied'));
    }

    public function transactions()
    {
        $user = Auth::user();
        $transactions = $user->transactions()->orderBy('created_at', 'desc')->paginate(20);
        return view('user.transactions', compact('transactions'));
    }

    public function chat()
    {
        $user = Auth::user();
        $admins = User::where('is_admin', 1)->get();
        return view('user.chat', compact('admins'));
    }

    public function sendChat(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|min:1',
        ]);

        Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $validated['receiver_id'],
            'message' => $validated['message'],
        ]);

        return response()->json(['success' => true]);
    }

    private function generateIdCardPdf($user)
    {
        // Implement PDF generation
    }

    private function generateIdCardImage($user)
    {
        // Implement image generation
    }
}
