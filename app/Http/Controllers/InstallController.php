<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Setting;
use Exception;

class InstallController extends Controller
{
    public function index()
    {
        if (file_exists(base_path('storage/installed'))) {
            return redirect('/');
        }

        return view('install.index');
    }

    public function database(Request $request)
    {
        try {
            $validated = $request->validate([
                'db_host' => 'required|string',
                'db_name' => 'required|string',
                'db_user' => 'required|string',
                'db_password' => 'nullable|string',
                'db_port' => 'required|integer',
            ]);

            // Test connection
            $connection = @mysqli_connect(
                $validated['db_host'],
                $validated['db_user'],
                $validated['db_password'] ?? '',
                '',
                $validated['db_port']
            );

            if (!$connection) {
                return response()->json([
                    'success' => false,
                    'message' => __('install.db_connection_failed')
                ], 422);
            }

            // Create database if not exists
            mysqli_query($connection, "CREATE DATABASE IF NOT EXISTS `{$validated['db_name']}`");
            mysqli_select_db($connection, $validated['db_name']);

            // Update .env
            $env = file_get_contents(base_path('.env'));
            $env = preg_replace('/DB_HOST=.*/i', "DB_HOST={$validated['db_host']}", $env);
            $env = preg_replace('/DB_DATABASE=.*/i', "DB_DATABASE={$validated['db_name']}", $env);
            $env = preg_replace('/DB_USERNAME=.*/i', "DB_USERNAME={$validated['db_user']}", $env);
            $env = preg_replace('/DB_PASSWORD=.*/i', "DB_PASSWORD={$validated['db_password']}", $env);
            $env = preg_replace('/DB_PORT=.*/i', "DB_PORT={$validated['db_port']}", $env);

            file_put_contents(base_path('.env'), $env);

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function admin(Request $request)
    {
        try {
            $validated = $request->validate([
                'admin_name' => 'required|string|min:3',
                'admin_email' => 'required|email|unique:users,email',
                'admin_mobile' => 'required|string|min:10',
                'admin_password' => 'required|string|min:6|confirmed',
            ]);

            // Create Admin User
            $admin = User::create([
                'name' => $validated['admin_name'],
                'email' => $validated['admin_email'],
                'mobile' => $validated['admin_mobile'],
                'password' => bcrypt($validated['admin_password']),
                'is_admin' => 1,
                'status' => 'approved',
                'tracking_code' => User::generateTrackingCode(),
            ]);

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function complete(Request $request)
    {
        try {
            $validated = $request->validate([
                'site_name' => 'required|string',
                'site_email' => 'required|email',
                'language' => 'required|in:bn,en',
            ]);

            // Create settings
            Setting::set('site_name', $validated['site_name']);
            Setting::set('site_email', $validated['site_email']);
            Setting::set('default_language', $validated['language']);

            // Mark as installed
            if (!is_dir(base_path('storage'))) {
                mkdir(base_path('storage'), 0755, true);
            }
            touch(base_path('storage/installed'));

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
