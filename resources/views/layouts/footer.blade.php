<footer class="footer">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-4">
                <h5 class="mb-3">{{ config('app.name') }}</h5>
                <p class="text-muted">{{ __('app.app_name') }} - একটি আধুনিক সমাধান সম্প্রদায় পরিচালনার জন্য।</p>
            </div>
            <div class="col-md-4">
                <h5 class="mb-3">দ্রুত লিঙ্ক</h5>
                <ul class="list-unstyled">
                    <li><a href="/" class="footer-link">হোম</a></li>
                    <li><a href="/members" class="footer-link">সদস্যরা</a></li>
                    <li><a href="/news" class="footer-link">খবর</a></li>
                    <li><a href="/tracking" class="footer-link">ট্র্যাকিং</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="mb-3">যোগাযোগ করুন</h5>
                <p class="text-muted">
                    <i class="fas fa-envelope"></i> {{ Setting::get('site_email', 'info@somiti.local') }}<br>
                    <i class="fas fa-phone"></i> +880 1234-567890
                </p>
            </div>
        </div>
        <hr class="bg-light">
        <div class="text-center text-muted py-3">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. সর্বাধিকার সংরক্ষিত।</p>
        </div>
    </div>
</footer>
