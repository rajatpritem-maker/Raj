@extends('layouts.app')

@section('title', 'লেনদেন ইতিহাস')

@section('content')
<div class="card">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="fas fa-history"></i> আমার সমস্ত লেনদেন</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr class="bg-light">
                    <th>লেনদেন ID</th>
                    <th>ধরন</th>
                    <th>পরিমাণ</th>
                    <th>বিবরণ</th>
                    <th>স্ট্যাটাস</th>
                    <th>তারিখ</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                    <tr>
                        <td>
                            <strong>{{ $transaction->transaction_id }}</strong>
                        </td>
                        <td>
                            @if ($transaction->type === 'dps_deposit')
                                <span class="badge bg-success">ডিপিএস জমা</span>
                            @elseif ($transaction->type === 'loan_payment')
                                <span class="badge bg-warning">ঋণ প্রদান</span>
                            @elseif ($transaction->type === 'donation')
                                <span class="badge bg-danger">দান</span>
                            @else
                                <span class="badge bg-secondary">উত্তোলন</span>
                            @endif
                        </td>
                        <td class="fw-bold">
                            ৳ {{ number_format($transaction->amount, 2) }}
                        </td>
                        <td>
                            {{ app()->getLocale() === 'bn' ? $transaction->description_bn : $transaction->description_en }}
                        </td>
                        <td>
                            @if ($transaction->status === 'completed')
                                <span class="badge bg-success">সম্পন্ন</span>
                            @elseif ($transaction->status === 'pending')
                                <span class="badge bg-warning">অপেক্ষমান</span>
                            @else
                                <span class="badge bg-danger">ব্যর্থ</span>
                            @endif
                        </td>
                        <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-inbox"></i> কোনো লেনদেন নেই
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-light">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
