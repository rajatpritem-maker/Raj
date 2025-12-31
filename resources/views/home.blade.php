@extends('layouts.app')

@section('title', 'হোম')

@section('content')
<!-- Hero Section -->
<div style="background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%); color: white; padding: 4rem 0; margin: -2rem 0 2rem 0; border-radius: 0 0 15px 15px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold mb-3">স্বাগতম সমিতি ম্যানেজমেন্ট সিস্টেমে</h1>
                <p class="lead mb-4">একসাথে আমরা আরও শক্তিশালী। আমাদের সম্প্রদায়ের সাথে যোগ দিন এবং আর্থিক স্বাধীনতা অর্জন করুন।</p>
                <div class="gap-3 d-flex">
                    <a href="/auth/register" class="btn btn-light btn-lg">নিবন্ধন করুন</a>
                    <a href="/tracking" class="btn btn-outline-light btn-lg">ট্র্যাকিং করুন</a>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <i class="fas fa-users" style="font-size: 8rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users" style="font-size: 2rem; color: #3498db;"></i>
                <h3 class="mt-2">{{ $totalMembers }}</h3>
                <p class="text-muted">সক্রিয় সদস্য</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-hand-holding-heart" style="font-size: 2rem; color: #27ae60;"></i>
                <h3 class="mt-2">৳ {{ number_format($totalDonations) }}</h3>
                <p class="text-muted">মোট দান</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-piggy-bank" style="font-size: 2rem; color: #e74c3c;"></i>
                <h3 class="mt-2">ডিপিএস</h3>
                <p class="text-muted">সঞ্চয় প্রোগ্রাম</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-handshake" style="font-size: 2rem; color: #f39c12;"></i>
                <h3 class="mt-2">ঋণ</h3>
                <p class="text-muted">সহজ শর্তে</p>
            </div>
        </div>
    </div>
</div>

<!-- Latest News -->
<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-4"><i class="fas fa-newspaper"></i> সর্বশেষ খবর</h2>
        @forelse ($latestNews as $item)
            <div class="card mb-3">
                @if ($item->image)
                    <div style="background: url('{{ Storage::url($item->image) }}'); background-size: cover; height: 200px;"></div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ app()->getLocale() === 'bn' ? $item->title_bn : $item->title_en }}</h5>
                    <p class="card-text text-truncate">{{ app()->getLocale() === 'bn' ? $item->content_bn : $item->content_en }}</p>
                    <a href="/news/{{ $item->id }}" class="btn btn-sm btn-primary">বিস্তারিত পড়ুন</a>
                    <small class="text-muted float-end">{{ $item->published_at->format('d M Y') }}</small>
                </div>
            </div>
        @empty
            <p class="text-muted">কোনো খবর নেই</p>
        @endforelse
    </div>

    <!-- Notices Sidebar -->
    <div class="col-md-4">
        <h3 class="mb-3"><i class="fas fa-bell"></i> গুরুত্বপূর্ণ নোটিশ</h3>
        @forelse ($notices as $notice)
            <div class="alert alert-info">
                <h6 class="alert-heading">{{ app()->getLocale() === 'bn' ? $notice->title_bn : $notice->title_en }}</h6>
                <p class="mb-0 small">{{ app()->getLocale() === 'bn' ? $notice->content_bn : $notice->content_en }}</p>
            </div>
        @empty
            <p class="text-muted">কোনো নোটিশ নেই</p>
        @endforelse
    </div>
</div>

<!-- Call to Action -->
<div style="background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%); color: white; padding: 3rem; border-radius: 10px; text-align: center;">
    <h2 class="mb-3">আজই আমাদের সাথে যুক্ত হন!</h2>
    <p class="lead mb-4">আপনার আর্থিক লক্ষ্য অর্জনে আমরা আপনার সঙ্গী</p>
    <a href="/auth/register" class="btn btn-light btn-lg">এখনই নিবন্ধন করুন</a>
</div>
@endsection
