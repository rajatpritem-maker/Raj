@extends('layouts.app')

@section('title', 'আমার প্রোফাইল')

@section('content')
<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card text-center">
            <div class="card-body">
                @if ($user->photo)
                    <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <i class="fas fa-user-circle" style="font-size: 5rem; color: #bbb;"></i>
                @endif
                <h4 class="mt-3">{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                <span class="badge bg-{{ $user->status === 'approved' ? 'success' : ($user->status === 'pending' ? 'warning' : 'danger') }}">
                    {{ ucfirst($user->status) }}
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-edit"></i> প্রোফাইল আপডেট করুন</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/user/profile/update" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">পূর্ণ নাম</label>
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ইমেল (পরিবর্তনযোগ্য নয়)</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">মোবাইল নম্বর</label>
                            <input type="tel" class="form-control" name="mobile" value="{{ $user->mobile }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ট্র্যাকিং কোড</label>
                            <input type="text" class="form-control" value="{{ $user->tracking_code }}" disabled>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ঠিকানা</label>
                        <textarea class="form-control" name="address" rows="2" required>{{ $user->address }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">প্রোফাইল ছবি</label>
                        <input type="file" class="form-control" name="photo" accept="image/*">
                        <small class="text-muted">নতুন ছবি আপলোড করতে বেছে নিন (সর্বোচ্চ ২ MB)</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">সদস্য ID</label>
                            <input type="text" class="form-control" value="{{ $user->member_id ?? 'অপেক্ষমান' }}" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">যোগদান তারিখ</label>
                            <input type="text" class="form-control" value="{{ $user->created_at->format('d M Y') }}" disabled>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">নথিপত্র</h6>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">জাতীয় পরিচয়পত্র (NID)</label>
                            @if ($user->nid_image)
                                <div class="mb-2">
                                    <a href="{{ Storage::url($user->nid_image) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> দেখুন
                                    </a>
                                </div>
                            @else
                                <p class="text-muted small">আপলোড করা হয়নি</p>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">জন্ম সনদ</label>
                            @if ($user->birth_certificate)
                                <div class="mb-2">
                                    <a href="{{ Storage::url($user->birth_certificate) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> দেখুন
                                    </a>
                                </div>
                            @else
                                <p class="text-muted small">আপলোড করা হয়নি</p>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> পরিবর্তনগুলি সংরক্ষণ করুন
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
