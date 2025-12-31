@extends('layouts.app')

@section('title', 'অ্যাডমিন ড্যাশবোর্ড')

@section('content')
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users" style="font-size: 2.5rem; color: #3498db;"></i>
                <h3 class="mt-2">{{ $totalUsers }}</h3>
                <p class="text-muted mb-0">মোট ব্যবহারকারী</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-hourglass-end" style="font-size: 2.5rem; color: #f39c12;"></i>
                <h3 class="mt-2">{{ $pendingUsers }}</h3>
                <p class="text-muted mb-0">অপেক্ষমান অনুমোদন</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-money-bill-wave" style="font-size: 2.5rem; color: #27ae60;"></i>
                <h3 class="mt-2">৳ {{ number_format($totalBalance, 2) }}</h3>
                <p class="text-muted mb-0">মোট ব্যালেন্স</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-file-invoice-dollar" style="font-size: 2.5rem; color: #e74c3c;"></i>
                <h3 class="mt-2">{{ $pendingLoans }}</h3>
                <p class="text-muted mb-0">অপেক্ষমান ঋণ</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-tools"></i> অ্যাডমিন প্যানেল</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="/admin/users" class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-users fa-2x mb-2"></i><br>
                            সদস্য ব্যবস্থাপনা
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="/admin/loans" class="btn btn-outline-success w-100 py-3">
                            <i class="fas fa-file-contract fa-2x mb-2"></i><br>
                            ঋণ অনুমোদন
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="/admin/news" class="btn btn-outline-danger w-100 py-3">
                            <i class="fas fa-newspaper fa-2x mb-2"></i><br>
                            খবর পরিচালনা
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="/admin/dps" class="btn btn-outline-warning w-100 py-3">
                            <i class="fas fa-piggy-bank fa-2x mb-2"></i><br>
                            ডিপিএস স্কিম
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="/admin/transactions" class="btn btn-outline-info w-100 py-3">
                            <i class="fas fa-exchange-alt fa-2x mb-2"></i><br>
                            লেনদেন রিপোর্ট
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="/admin/settings" class="btn btn-outline-secondary w-100 py-3">
                            <i class="fas fa-cog fa-2x mb-2"></i><br>
                            সেটিংস
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-list"></i> অপেক্ষমান অনুমোদন</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr class="bg-light">
                            <th>ব্যবহারকারী</th>
                            <th>ইমেল</th>
                            <th>মোবাইল</th>
                            <th>আবেদন তারিখ</th>
                            <th>কার্যক্রম</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                <i class="fas fa-inbox"></i> কোনো অপেক্ষমান অনুমোদন নেই
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
