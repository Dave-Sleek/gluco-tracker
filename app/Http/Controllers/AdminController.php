<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Subscription;
use App\Mail\FeedbackResponse;
use App\Models\Feedback;
use App\Models\FeedbackReply;
use Illuminate\Support\Facades\Mail;
use App\Models\Message;
use App\Models\UserLog;
use App\Models\Notification;
// use Illuminate\Support\Facades\Notification;
use App\Notifications\SendPushNotification;
use App\Notifications\ContactSubmitted;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard'); // assuming your Blade view is at resources/views/admin/dashboard.blade.php
    }

    public function stats()
    {
        // Ensure only admins can see this
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, '⛔ Access Denied. Admins only.');
        }

        return view('admin.stats', [
            'total_users'      => DB::table('users')->count(),
            'total_reminders'  => DB::table('reminders')->count(),
            'total_logs'       => DB::table('conversions')->count(),
            'total_meals'      => DB::table('meals')->count(),
        ]);
    }

    public function manageUsers(Request $request)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, '⛔ Access Denied. Admins only.');
        }

        // Handle POST Actions
        if ($request->isMethod('post')) {
            $user = User::findOrFail($request->input('user_id'));

            if ($request->has('ban_user')) {
                $user->is_banned = 1;
                $user->save();
            }

            if ($request->has('reset_password')) {
                $user->password = Hash::make('123456');
                $user->save();
            }

            return redirect()->back()->with('status', 'Action completed.');
        }

        // Filters
        $search = $request->input('search');
        $from = $request->input('from', '1970-01-01');
        $to = $request->input('to', now()->toDateString());

        $query = User::query()
            ->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->whereBetween(DB::raw('DATE(created_at)'), [$from, $to])
            ->orderByDesc('id');

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users', compact('users', 'search', 'from', 'to'));
    }

    public function viewUserProfile(User $user)
    {
        if (!Auth::user()->is_admin) {
            abort(403, '⛔ Access Denied. Admins only.');
        }

        $conversions = $user->conversions()
            ->orderByDesc('converted_at')
            ->get([
                'original_value',
                'original_unit',
                'converted_value',
                'converted_unit',
                'type',
                'converted_at',
            ]);

        $csvData = $conversions->map(function ($c) {
            return [
                $c->original_value . ' ' . $c->original_unit,
                $c->converted_value . ' ' . $c->converted_unit,
                ucfirst($c->type),
                \Carbon\Carbon::parse($c->converted_at)->format('Y-m-d H:i:s'),
            ];
        });

        return view('admin.user_profile', compact('user', 'conversions', 'csvData'));
    }

    public function deleteUser(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $user = User::find($validated['user_id']);

        // Optional: prevent deleting admin accounts
        if ($user->is_admin) {
            return response()->json([
                'status' => 'error',
                'message' => '⚠️ Cannot delete an admin account.',
            ]);
        }

        try {
            $user->delete();

            return response()->json([
                'status' => 'success',
                'message' => '✅ User deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => '❌ Failed to delete user.',
            ]);
        }
    }

    public function exportReadings(User $user): StreamedResponse
    {
        $filename = "user_{$user->id}_readings.csv";

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        // Fetch conversions ahead of time to avoid Eloquent inside stream
        $conversions = $user->conversions()
            ->orderByDesc('converted_at')
            ->get([
                'original_value',
                'original_unit',
                'converted_value',
                'converted_unit',
                'type',
                'converted_at',
            ]);

        $callback = function () use ($conversions) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Original Value', 'Original Unit', 'Converted Value', 'Converted Unit', 'Type', 'Timestamp']);

            foreach ($conversions as $row) {
                fputcsv($handle, [
                    $row->original_value,
                    $row->original_unit,
                    $row->converted_value,
                    $row->converted_unit,
                    ucfirst($row->type),
                    \Carbon\Carbon::parse($row->converted_at)->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function subscriptions(Request $request)
    {
        $query = Subscription::with('user')->orderByDesc('start_date');

        // Filters
        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('start_date', [$request->from_date, $request->to_date]);
        }

        $subscriptions = $query->paginate(10)->withQueryString();

        // Revenue calculation
        $revenue = Subscription::where('status', 'active')->sum(DB::raw("
        CASE
            WHEN plan = 'monthly' THEN 3000
            WHEN plan = 'annual' THEN 30000
            WHEN plan = 'lifetime' THEN 75000
            ELSE 0
        END
    "));

        return view('admin.subscriptions', compact('subscriptions', 'revenue'));
    }

    public function exportSubscriptions(Request $request)
    {
        $query = DB::table('subscriptions')
            ->join('users', 'subscriptions.user_id', '=', 'users.id')
            ->select('users.full_name', 'users.email', 'subscriptions.plan', 'subscriptions.amount_paid', 'subscriptions.start_date', 'subscriptions.end_date', 'subscriptions.status');

        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
        }

        if ($request->filled('amount_paid')) {
            $query->where('amount_paid', $request->amount_paid);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('subscriptions.start_date', [$request->from_date, $request->to_date]);
        }

        $subscriptions = $query->get();

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="subscriptions_export.csv"',
        ];

        $callback = function () use ($subscriptions) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Name', 'Email', 'Plan', 'Amount Paid', 'Start Date', 'End Date', 'Status']);

            foreach ($subscriptions as $row) {
                fputcsv($handle, [
                    $row->full_name,
                    $row->email,
                    ucfirst($row->plan),
                    $row->amount_paid,
                    $row->start_date,
                    $row->end_date,
                    ucfirst($row->status),
                ]);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }


    public function indexFeedback()
    {
        $feedbacks = Feedback::with('user')->latest()->get();

        return view('admin.feedback', compact('feedbacks'));
    }

    public function replyToFeedback(Request $request)
    {
        $request->validate([
            'feedback_id' => 'required|exists:feedbacks,id', // ✅ corrected table name
            'user_id' => 'required|exists:users,id',
            'reply' => 'required|string|min:5',
        ]);

        $user = User::findOrFail($request->user_id);
        $feedback = Feedback::findOrFail($request->feedback_id);
        // $admin = auth()->user();
        $admin = auth('admin')->user();


        // Send email
        Mail::to($user->email)->send(
            new FeedbackResponse($feedback->id, $user->full_name, $request->reply)
        );

        // Store reply in DB
        FeedbackReply::create([
            'feedback_id' => $feedback->id,
            'admin_id' => $admin->id,
            'reply' => $request->reply,
        ]);

        return redirect()->route('admin.feedback')->with('success', '✅ Reply sent successfully.');
    }


    public function create()
    {
        $users = User::select('id', 'full_name')->get();
        return view('admin.messages', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|min:3',
            'target' => 'required',
        ]);

        $title = 'New Admin Notification';
        $type = 'email'; // or dynamically choose based on logic

        if ($request->target === 'all') {
            $users = User::select('id')->get();
            foreach ($users as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'type' => 'email',
                    'title' => 'System Message',
                    'message' => $request->message,
                    'status' => 'pending',
                    'sent_at' => now(),
                ]);
            }
        } else {
            $user = User::findOrFail($request->target);
            Notification::create([
                'user_id' => $user->id,
                'type' => 'email',
                'title' => 'System Message',
                'message' => $request->message,
                'status' => 'pending',
                'sent_at' => now(),
            ]);
        }

        return back()->with('success', 'Notification saved successfully.');
    }


    public function userLogs()
    {
        $logs = UserLog::with('user')
            ->latest('timestamp')
            ->limit(100)
            ->get();
        $logs = UserLog::with('user')->orderByDesc('timestamp')->paginate(20); // 20 per page
        return view('admin.logs', compact('logs'));
    }

    public function sendAlert($userId)
    {
        $user = User::findOrFail($userId);

        $user->notify(new SendPushNotification([
            'message' => 'Your sugar level is higher than normal. Take a quick check!',
            'id' => 999,
        ]));

        return response()->json(['success' => true]);
    }
}
