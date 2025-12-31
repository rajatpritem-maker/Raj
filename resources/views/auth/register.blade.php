@extends('layouts.app')

@section('title', 'নিবন্ধন')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-user-plus"></i> নতুন অ্যাকাউন্ট তৈরি করুন</h4>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/auth/register" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">পূর্ণ নাম <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">ইমেল ঠিকানা <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="mobile" class="form-label">মোবাইল নম্বর <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}" placeholder="01XXXXXXXXX" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">ঠিকানা <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">পাসওয়ার্ড <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <small class="text-muted">কমপক্ষে ৬ অক্ষর</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">পাসওয়ার্ড নিশ্চিত করুন <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>

                    <hr>
                    <h5 class="mb-3"><i class="fas fa-image"></i> ছবি এবং নথি</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="photo" class="form-label">প্রোফাইল ছবি <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
                            <small class="text-muted">সর্বোচ্চ ২ MB</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nid_image" class="form-label">জাতীয় পরিচয়পত্র (NID)</label>
                            <input type="file" class="form-control" id="nid_image" name="nid_image" accept="image/*">
                            <small class="text-muted">সর্বোচ্চ ৫ MB</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="birth_certificate" class="form-label">জন্ম সনদ</label>
                        <input type="file" class="form-control" id="birth_certificate" name="birth_certificate" accept="image/*">
                        <small class="text-muted">সর্বোচ্চ ৫ MB (NID বা জন্ম সনদ অবশ্যই প্রয়োজন)</small>
                    </div>

                    <div class="alert alert-info mb-3">
                        <i class="fas fa-info-circle"></i>
                        আপনার আবেদন জমা দেওয়ার পরে, আমাদের প্রশাসক দল যাচাই করার জন্য পর্যালোচনা করবে। আপনার অ্যাকাউন্ট অনুমোদিত হওয়ার পরে সমস্ত বৈশিষ্ট্য অ্যাক্সেস করা হবে।
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">নিবন্ধন করুন</button>
                </form>

                <hr>

                <p class="text-center mb-0">
                    ইতিমধ্যে অ্যাকাউন্ট আছে? <a href="/auth/login">এখানে লগইন করুন</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
