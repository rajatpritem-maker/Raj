<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Notice;
use App\Models\User;
use App\Models\Donation;
use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestNews = News::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        $notices = Notice::where('status', 'active')
            ->orderBy('priority', 'desc')
            ->limit(3)
            ->get();

        $totalMembers = User::where('status', 'approved')
            ->where('is_admin', 0)
            ->count();

        $totalDonations = Transaction::where('type', 'donation')
            ->where('status', 'completed')
            ->sum('amount');

        return view('home', compact('latestNews', 'notices', 'totalMembers', 'totalDonations'));
    }

    public function members()
    {
        $members = User::where('status', 'approved')
            ->where('is_admin', 0)
            ->paginate(20);

        return view('members', compact('members'));
    }

    public function news()
    {
        $news = News::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(15);

        return view('news.index', compact('news'));
    }

    public function newsDetail($id)
    {
        $news = News::findOrFail($id);

        if ($news->status !== 'published') {
            abort(404);
        }

        $relatedNews = News::where('status', 'published')
            ->where('id', '!=', $id)
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        return view('news.detail', compact('news', 'relatedNews'));
    }

    public function activities()
    {
        $activities = Activity::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('activities', compact('activities'));
    }

    public function notices()
    {
        $notices = Notice::where('status', 'active')
            ->orderBy('priority', 'desc')
            ->paginate(10);

        return view('notices', compact('notices'));
    }

    public function donations()
    {
        return view('donations');
    }

    public function storeDonation(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:100',
            'donor_name' => 'required|string|min:3',
            'donor_email' => 'required|email',
            'message' => 'nullable|string',
        ]);

        $transaction = Transaction::create([
            'transaction_id' => Transaction::generateTransactionId(),
            'type' => 'donation',
            'amount' => $validated['amount'],
            'status' => 'pending',
            'description_bn' => $validated['message'] ?? '',
            'description_en' => $validated['message'] ?? '',
        ]);

        return redirect('/')->with('success', __('donation.success'));
    }

    public function tracking()
    {
        return view('tracking');
    }

    public function trackingSearch(Request $request)
    {
        $validated = $request->validate([
            'tracking_code' => 'required|string',
        ]);

        $user = User::where('tracking_code', $validated['tracking_code'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => __('tracking.not_found')
            ], 404);
        }

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'status' => $user->status,
            'member_id' => $user->member_id,
            'applied_at' => $user->created_at->format('Y-m-d'),
            'approved_at' => $user->approved_at ? $user->approved_at->format('Y-m-d') : null,
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }
}
