@extends('layouts.app')

@section('title', 'ঋণ ব্যবস্থাপনা')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-file-contract"></i> আমার ঋণসমূহ</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr class="bg-light">
                            <th>পরিমাণ</th>
                            <th>মেয়াদ</th>
                            <th>উদ্দেশ্য</th>
                            <th>স্ট্যাটাস</th>
                            <th>তারিখ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($loans as $loan)
                            <tr>
                                <td>৳ {{ number_format($loan->amount, 2) }}</td>
                                <td>{{ $loan->duration_months }} মাস</td>
                                <td>{{ $loan->purpose_bn }}</td>
                                <td>
                                    @if ($loan->status === 'pending')
                                        <span class="badge bg-warning">অপেক্ষমান</span>
                                    @elseif ($loan->status === 'approved')
                                        <span class="badge bg-success">অনুমোদিত</span>
                                    @elseif ($loan->status === 'rejected')
                                        <span class="badge bg-danger">প্রত্যাখ্যান</span>
                                    @else
                                        <span class="badge bg-info">সম্পন্ন</span>
                                    @endif
                                </td>
                                <td>{{ $loan->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    কোনো ঋণ নেই
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
                <h5 class="mb-0"><i class="fas fa-plus-circle"></i> নতুন ঋণের আবেদন করুন</h5>
            </div>
            <div class="card-body">
                <form action="/user/loan/apply" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">ঋণের পরিমাণ</label>
                        <input type="number" class="form-control" name="amount" step="100" min="1000" required>
                        <small class="text-muted">সর্বনিম্ন ১০০০ টাকা</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">মেয়াদ (মাসে)</label>
                        <input type="number" class="form-control" name="duration" min="3" max="60" required>
                        <small class="text-muted">৩-৬০ মাস</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ঋণের উদ্দেশ্য (বাংলা)</label>
                        <textarea class="form-control" name="purpose_bn" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ঋণের উদ্দেশ্য (ইংরেজি)</label>
                        <textarea class="form-control" name="purpose_en" rows="2" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-paper-plane"></i> আবেদন জমা দিন
                    </button>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-lightbulb"></i> ঋণের শর্তাবলী</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <i class="fas fa-check text-success"></i>
                        <strong>সুদের হার:</strong> ৫-৭%
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success"></i>
                        <strong>মেয়াদ:</strong> ৩-৬০ মাস
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success"></i>
                        <strong>অনুমোদন:</strong> ৭ দিন
                    </li>
                    <li class="mb-0">
                        <i class="fas fa-check text-success"></i>
                        <strong>সর্বোচ্চ:</strong> ৫ লক্ষ টাকা
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
