@extends('layouts.app')

@section('title', 'লগইন')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-sign-in-alt"></i> লগইন করুন</h4>
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

                <form method="POST" action="/auth/login">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">ইমেল ঠিকানা</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">পাসওয়ার্ড</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">আমাকে মনে রাখুন</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">লগইন করুন</button>
                </form>

                <hr>

                <p class="text-center mb-0">
                    এখনও অ্যাকাউন্ট নেই? <a href="/auth/register">এখানে নিবন্ধন করুন</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
