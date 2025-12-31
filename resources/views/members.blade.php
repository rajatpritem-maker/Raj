@extends('layouts.app')

@section('title', 'সদস্য তালিকা')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-users"></i> অনুমোদিত সদস্যসমূহ</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr class="bg-light">
                    <th>নাম</th>
                    <th>সদস্য ID</th>
                    <th>ইমেল</th>
                    <th>মোবাইল</th>
                    <th>যোগদান তারিখ</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $member)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if ($member->photo)
                                    <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; margin-right: 10px;">
                                @else
                                    <i class="fas fa-user-circle" style="font-size: 1.5rem; margin-right: 10px; color: #bbb;"></i>
                                @endif
                                <strong>{{ $member->name }}</strong>
                            </div>
                        </td>
                        <td>{{ $member->member_id }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->mobile }}</td>
                        <td>{{ $member->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            কোনো সদস্য নেই
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-light">
        {{ $members->links() }}
    </div>
</div>
@endsection
