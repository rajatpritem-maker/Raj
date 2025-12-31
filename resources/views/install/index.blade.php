<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>সমিতি ম্যানেজমেন্ট - ইনস্টলেশন</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .installer-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 600px;
            margin: 0 auto;
        }

        .installer-header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px 15px 0 0;
            text-align: center;
        }

        .installer-header h1 {
            font-size: 1.5rem;
            margin-bottom: 0;
        }

        .installer-body {
            padding: 2rem;
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .progress-step {
            text-align: center;
            padding: 1rem 0;
        }

        .progress-step .number {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: #ecf0f1;
            border-radius: 50%;
            line-height: 40px;
            font-weight: bold;
            color: #7f8c8d;
            margin-bottom: 0.5rem;
        }

        .progress-step.completed .number {
            background: #27ae60;
            color: white;
        }

        .progress-step.active .number {
            background: #3498db;
            color: white;
        }

        .form-control, .form-select {
            border: 1px solid #ddd;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .btn-next, .btn-prev {
            padding: 10px 30px;
            margin-right: 10px;
        }

        .alert {
            border-radius: 8px;
        }

        .loading {
            display: none;
            text-align: center;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="installer-container">
        <div class="installer-header">
            <h1><i class="fas fa-rocket"></i> সমিতি ম্যানেজমেন্ট সিস্টেম</h1>
            <p class="mb-0">ইনস্টলেশন উইজার্ড</p>
        </div>

        <div class="installer-body">
            <div class="row mb-4">
                <div class="col-4 progress-step completed">
                    <div class="number"><i class="fas fa-check"></i></div>
                    <small>স্বাগত</small>
                </div>
                <div class="col-4 progress-step active">
                    <div class="number">1</div>
                    <small>ডাটাবেস</small>
                </div>
                <div class="col-4 progress-step">
                    <div class="number">2</div>
                    <small>অ্যাডমিন</small>
                </div>
                <div class="col-4 progress-step">
                    <div class="number">3</div>
                    <small>সম্পন্ন</small>
                </div>
            </div>

            <!-- Step 1: Database Configuration -->
            <div class="step active" id="step-1">
                <h4 class="mb-3"><i class="fas fa-database"></i> ডাটাবেস কনফিগারেশন</h4>
                <div id="db-message"></div>
                <form id="db-form">
                    <div class="mb-3">
                        <label class="form-label">হোস্ট নেম</label>
                        <input type="text" class="form-control" name="db_host" value="localhost" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">পোর্ট</label>
                        <input type="number" class="form-control" name="db_port" value="3306" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ব্যবহারকারীর নাম</label>
                        <input type="text" class="form-control" name="db_user" value="root" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">পাসওয়ার্ড</label>
                        <input type="password" class="form-control" name="db_password" placeholder="(ফাঁক থাকলে ছেড়ে দিন)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ডাটাবেস নাম</label>
                        <input type="text" class="form-control" name="db_name" value="somiti_db" required>
                    </div>
                </form>
            </div>

            <!-- Step 2: Admin Account -->
            <div class="step" id="step-2">
                <h4 class="mb-3"><i class="fas fa-user-shield"></i> অ্যাডমিন অ্যাকাউন্ট তৈরি করুন</h4>
                <div id="admin-message"></div>
                <form id="admin-form">
                    <div class="mb-3">
                        <label class="form-label">নাম</label>
                        <input type="text" class="form-control" name="admin_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ইমেল</label>
                        <input type="email" class="form-control" name="admin_email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">মোবাইল নম্বর</label>
                        <input type="tel" class="form-control" name="admin_mobile" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">পাসওয়ার্ড</label>
                        <input type="password" class="form-control" name="admin_password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">পাসওয়ার্ড নিশ্চিত করুন</label>
                        <input type="password" class="form-control" name="admin_password_confirmation" required>
                    </div>
                </form>
            </div>

            <!-- Step 3: Site Settings -->
            <div class="step" id="step-3">
                <h4 class="mb-3"><i class="fas fa-cog"></i> সাইট সেটিংস</h4>
                <div id="settings-message"></div>
                <form id="settings-form">
                    <div class="mb-3">
                        <label class="form-label">সাইট নাম</label>
                        <input type="text" class="form-control" name="site_name" value="সমিতি ম্যানেজমেন্ট সিস্টেম" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ইমেল ঠিকানা</label>
                        <input type="email" class="form-control" name="site_email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ডিফল্ট ভাষা</label>
                        <select class="form-select" name="language" required>
                            <option value="bn">বাংলা</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                </form>
            </div>

            <!-- Completion Message -->
            <div class="step" id="step-4">
                <div class="text-center py-4">
                    <i class="fas fa-check-circle" style="font-size: 3rem; color: #27ae60;"></i>
                    <h4 class="mt-3">ইনস্টলেশন সম্পন্ন!</h4>
                    <p class="text-muted">আপনার সমিতি ম্যানেজমেন্ট সিস্টেম প্রস্তুত।</p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-4">
                <button type="button" class="btn btn-secondary btn-prev" onclick="previousStep()">
                    <i class="fas fa-arrow-left"></i> পূর্ববর্তী
                </button>
                <button type="button" class="btn btn-primary btn-next" onclick="nextStep()">
                    পরবর্তী <i class="fas fa-arrow-right"></i>
                </button>
                <button type="button" class="btn btn-success" id="complete-btn" style="display: none;" onclick="completeInstall()">
                    <i class="fas fa-check"></i> ইনস্টলেশন শেষ করুন
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 4;

        function showStep(step) {
            document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));
            document.getElementById('step-' + step).classList.add('active');

            document.querySelectorAll('.progress-step').forEach(el => el.classList.remove('active', 'completed'));

            document.querySelectorAll('.progress-step').forEach((el, idx) => {
                if (idx < step - 1) {
                    el.classList.add('completed');
                } else if (idx === step - 1) {
                    el.classList.add('active');
                }
            });

            document.querySelector('.btn-prev').style.display = step > 1 ? 'inline-block' : 'none';
            document.querySelector('.btn-next').style.display = step < totalSteps ? 'inline-block' : 'none';
            document.getElementById('complete-btn').style.display = step === totalSteps ? 'inline-block' : 'none';
        }

        async function nextStep() {
            if (currentStep === 1) {
                await submitDatabaseConfig();
            } else if (currentStep === 2) {
                await submitAdminConfig();
            } else if (currentStep === 3) {
                await completeInstall();
            }
        }

        function previousStep() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        }

        async function submitDatabaseConfig() {
            const form = document.getElementById('db-form');
            const formData = new FormData(form);

            try {
                const response = await fetch('/install/database', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content
                    }
                });

                const result = await response.json();
                if (result.success) {
                    currentStep++;
                    showStep(currentStep);
                } else {
                    showError('db-message', result.message);
                }
            } catch (error) {
                showError('db-message', 'ত্রুটি: ' + error.message);
            }
        }

        async function submitAdminConfig() {
            const form = document.getElementById('admin-form');
            const formData = new FormData(form);

            try {
                const response = await fetch('/install/admin', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content
                    }
                });

                const result = await response.json();
                if (result.success) {
                    currentStep++;
                    showStep(currentStep);
                } else {
                    showError('admin-message', result.message);
                }
            } catch (error) {
                showError('admin-message', 'ত্রুটি: ' + error.message);
            }
        }

        async function completeInstall() {
            const form = document.getElementById('settings-form');
            const formData = new FormData(form);

            try {
                const response = await fetch('/install/complete', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content
                    }
                });

                const result = await response.json();
                if (result.success) {
                    currentStep++;
                    showStep(currentStep);
                    setTimeout(() => {
                        window.location.href = '/auth/login';
                    }, 2000);
                } else {
                    showError('settings-message', result.message);
                }
            } catch (error) {
                showError('settings-message', 'ত্রুটি: ' + error.message);
            }
        }

        function showError(elementId, message) {
            const msgEl = document.getElementById(elementId);
            msgEl.innerHTML = '<div class="alert alert-danger"><i class="fas fa-times-circle"></i> ' + message + '</div>';
        }

        showStep(currentStep);
    </script>
</body>
</html>
