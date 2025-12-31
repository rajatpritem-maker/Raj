@extends('layouts.app')

@section('title', 'দান করুন')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-heart"></i> আমাদের কাজে অবদান রাখুন</h5>
            </div>
            <div class="card-body p-4">
                <p class="lead mb-4">আপনার দান আমাদের সম্প্রদায়ের উন্নয়নে সহায়তা করবে।</p>

                <form action="/donations/store" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">দানের পরিমাণ</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text">৳</span>
                            <input type="number" class="form-control" name="amount" step="100" min="100" placeholder="পরিমাণ লিখুন" required>
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm me-2" onclick="setAmount(500)">৳500</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm me-2" onclick="setAmount(1000)">৳1000</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm me-2" onclick="setAmount(2000)">৳2000</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setAmount(5000)">৳5000</button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">আপনার নাম</label>
                        <input type="text" class="form-control" name="donor_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ইমেল ঠিকানা</label>
                        <input type="email" class="form-control" name="donor_email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">বার্তা (ঐচ্ছিক)</label>
                        <textarea class="form-control" name="message" rows="3" placeholder="আপনার মন্তব্য..."></textarea>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="anonymous" name="anonymous">
                        <label class="form-check-label" for="anonymous">
                            নাম প্রকাশ করবেন না
                        </label>
                    </div>

                    <button type="submit" class="btn btn-danger btn-lg w-100">
                        <i class="fas fa-heart"></i> দান করুন
                    </button>
                </form>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-lock" style="font-size: 2rem; color: #27ae60;"></i>
                        <h6 class="mt-2">নিরাপদ পেমেন্ট</h6>
                        <p class="mb-0 small text-muted">আপনার তথ্য সম্পূর্ণ সুরক্ষিত</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-certificate" style="font-size: 2rem; color: #3498db;"></i>
                        <h6 class="mt-2">স্বচ্ছতা</h6>
                        <p class="mb-0 small text-muted">সব দান প্রকাশ করা হয়</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function setAmount(amount) {
        document.querySelector('input[name="amount"]').value = amount;
        document.querySelector('input[name="amount"]').focus();
    }
</script>
@endsection
