@extends('layouts.app')

@section('title', 'আবেদন ট্র্যাক করুন')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-search"></i> আবেদন ট্র্যাক করুন</h4>
            </div>
            <div class="card-body p-4">
                <p class="text-muted mb-4">আপনার ট্র্যাকিং কোড দিয়ে আবেদনের অবস্থা জানুন</p>

                <form id="tracking-form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">ট্র্যাকিং কোড</label>
                        <input type="text" class="form-control form-control-lg" id="tracking_code" name="tracking_code" placeholder="উদাহরণ: SMT-2025-ABX92" required>
                        <small class="text-muted">আপনার নিবন্ধনের সময় পাঠানো কোড দিন</small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-search"></i> খুঁজুন
                    </button>
                </form>

                <div id="result" style="display: none;">
                    <hr class="my-4">
                    <div id="result-content"></div>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-4">
            <h5 class="alert-heading"><i class="fas fa-info-circle"></i> ট্র্যাকিং কোড কী?</h5>
            <p class="mb-0">আপনার ট্র্যাকিং কোড হল একটি অনন্য আইডেন্টিফায়ার যা আপনার নিবন্ধনের সময় স্বয়ংক্রিয়ভাবে তৈরি হয়। এটি ব্যবহার করে আপনি আপনার আবেদনের অবস্থা, ঋণের স্ট্যাটাস এবং ডিপিএস সম্পর্কে তথ্য পেতে পারেন।</p>
        </div>
    </div>
</div>

<script>
    document.getElementById('tracking-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const trackingCode = document.getElementById('tracking_code').value;

        try {
            const response = await fetch('/tracking/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ tracking_code: trackingCode })
            });

            const result = await response.json();

            if (result.success) {
                displayResult(result.data);
            } else {
                showError(result.message);
            }
        } catch (error) {
            showError('ত্রুটি ঘটেছে: ' + error.message);
        }
    });

    function displayResult(data) {
        const resultEl = document.getElementById('result');
        const statusColors = {
            'pending': 'warning',
            'approved': 'success',
            'rejected': 'danger'
        };

        let html = `
            <h5>ট্র্যাকিং ফলাফল</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>নাম:</strong></p>
                    <p>${data.name}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>সদস্য ID:</strong></p>
                    <p>${data.member_id || 'পেন্ডিং'}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>ইমেল:</strong></p>
                    <p>${data.email}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>আবেদনের তারিখ:</strong></p>
                    <p>${data.applied_at}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <p class="mb-2"><strong>অবস্থা:</strong></p>
                    <span class="badge bg-${statusColors[data.status] || 'secondary'} p-2">
                        ${getStatusText(data.status)}
                    </span>
                </div>
            </div>
        `;

        if (data.approved_at) {
            html += `
                <div class="row">
                    <div class="col-md-12">
                        <p class="mb-1"><strong>অনুমোদিত তারিখ:</strong></p>
                        <p>${data.approved_at}</p>
                    </div>
                </div>
            `;
        }

        document.getElementById('result-content').innerHTML = html;
        resultEl.style.display = 'block';
    }

    function showError(message) {
        const resultEl = document.getElementById('result');
        document.getElementById('result-content').innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-times-circle"></i> ${message}
            </div>
        `;
        resultEl.style.display = 'block';
    }

    function getStatusText(status) {
        const texts = {
            'pending': 'অপেক্ষমান',
            'approved': 'অনুমোদিত',
            'rejected': 'প্রত্যাখ্যান করা হয়েছে'
        };
        return texts[status] || status;
    }
</script>
@endsection
