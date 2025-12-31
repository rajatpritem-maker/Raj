@extends('layouts.app')

@section('title', 'আমার ড্যাশবোর্ড')

@section('content')
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-user-circle" style="font-size: 2.5rem; color: #3498db;"></i>
                <h6 class="mt-2">আপনার স্ট্যাটাস</h6>
                <span class="badge status-{{ $user->status }}">{{ ucfirst($user->status) }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-id-card" style="font-size: 2.5rem; color: #27ae60;"></i>
                <h6 class="mt-2">সদস্য ID</h6>
                <p class="mb-0">{{ $user->member_id ?? 'চলছে' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-piggy-bank" style="font-size: 2.5rem; color: #e74c3c;"></i>
                <h6 class="mt-2">ডিপিএস অ্যাকাউন্ট</h6>
                <p class="mb-0">{{ $dpsAccounts }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-handshake" style="font-size: 2.5rem; color: #f39c12;"></i>
                <h6 class="mt-2">সক্রিয় ঋণ</h6>
                <p class="mb-0">{{ $activeLoans }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-chart-line"></i> সঞ্চয় তথ্য</h5>
            </div>
            <div class="card-body">
                <p class="mb-2">
                    <strong>মোট জমা:</strong><br>
                    <span style="font-size: 1.5rem; color: #27ae60;">৳ {{ number_format($totalDeposited, 2) }}</span>
                </p>
                <hr>
                <a href="/user/dps" class="btn btn-sm btn-success">
                    <i class="fas fa-eye"></i> সবকিছু দেখুন
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-tasks"></i> দ্রুত অ্যাক্সেস</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if ($user->status === 'approved')
                        <a href="/user/dps" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-piggy-bank"></i> ডিপিএস সঞ্চয় শুরু করুন
                        </a>
                        <a href="/user/loan" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-handshake"></i> ঋণের জন্য আবেদন করুন
                        </a>
                        <a href="/user/id-card" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-id-card"></i> আইডি কার্ড ডাউনলোড করুন
                        </a>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-info-circle"></i> আপনার অ্যাকাউন্ট অনুমোদনের জন্য অপেক্ষা করছে
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-history"></i> সাম্প্রতিক লেনদেন</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr class="bg-light">
                            <th>লেনদেন ID</th>
                            <th>ধরন</th>
                            <th>পরিমাণ</th>
                            <th>স্ট্যাটাস</th>
                            <th>তারিখ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                <i class="fas fa-inbox"></i> কোনো লেনদেন নেই
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
