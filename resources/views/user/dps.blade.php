@extends('layouts.app')

@section('title', 'ডিপিএস সঞ্চয়')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-piggy-bank"></i> আমার ডিপিএস অ্যাকাউন্টসমূহ</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr class="bg-light">
                            <th>অ্যাকাউন্ট নম্বর</th>
                            <th>স্কিম</th>
                            <th>মাসিক</th>
                            <th>বর্তমান মাস</th>
                            <th>স্ট্যাটাস</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dpsAccounts as $account)
                            <tr>
                                <td>{{ $account->account_number }}</td>
                                <td>{{ $account->scheme->name_bn }}</td>
                                <td>৳ {{ number_format($account->scheme->monthly_amount, 2) }}</td>
                                <td>{{ $account->current_month }} / {{ $account->scheme->total_months }}</td>
                                <td>
                                    @if ($account->status === 'active')
                                        <span class="badge bg-success">সক্রিয়</span>
                                    @elseif ($account->status === 'completed')
                                        <span class="badge bg-info">সম্পন্ন</span>
                                    @else
                                        <span class="badge bg-danger">বাতিল</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    কোনো ডিপিএস অ্যাকাউন্ট নেই
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-plus-circle"></i> নতুন ডিপিএস খুলুন</h5>
            </div>
            <div class="card-body">
                <form action="/user/dps/apply" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">স্কিম নির্বাচন করুন</label>
                        <select class="form-select" name="scheme_id" required>
                            <option value="">-- স্কিম বেছে নিন --</option>
                            <option value="1">ডিপিএস ৫০০ (মাসিক ৫০০ টাকা, ১২ মাস)</option>
                            <option value="2">ডিপিএস ১০০০ (মাসিক ১০০০ টাকা, ২৪ মাস)</option>
                            <option value="3">ডিপিএস ২০০০ (মাসিক ২০০০ টাকা, ৩৬ মাস)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-check"></i> নতুন অ্যাকাউন্ট খুলুন
                    </button>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> সুবিধাসমূহ</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-check text-success"></i>
                        নমনীয় সঞ্চয় পরিকল্পনা
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success"></i>
                        আকর্ষণীয় সুদের হার
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success"></i>
                        স্বচ্ছ লেনদেন
                    </li>
                    <li class="mb-0">
                        <i class="fas fa-check text-success"></i>
                        তাড়াতাড়ি ঋণের আবেদন
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
