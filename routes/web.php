<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BloodSugarController;
use App\Http\Controllers\BloodTestController;
use App\Http\Controllers\AdvancedSearchController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\NotificationController;
// use App\Http\Controllers\FutureMessageController;
// use App\Http\Controllers\Admin\AdminUserController;
// use App\Http\Controllers\Admin\AdminFeedbackController;
// use App\Http\Controllers\Admin\AdminStatsController;
use App\Http\Controllers\ChartDataController;
use App\Http\Controllers\AverageController;
use App\Http\Controllers\ReadingController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\RecommendationController;
use Illuminate\Http\Request;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PdfExportController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\PaymentController;
use App\Models\FeedbackReply;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
// use App\Http\Controllers\SymptomLogController;
use App\Http\Livewire\SymptomLogs;
use App\Http\Controllers\MealLogController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Livewire\MealSuggestions;
use App\Http\Controllers\AdminMealController;





/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing page (index.blade.php)
Route::get('/', fn() => view('index'))->name('home');

// Pricing page
Route::view('/pricing', 'pricing')->name('pricing');

// Auth Routes (Login inside modal)
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', function () {
    return view('index'); // Assuming your landing page is views/index.blade.php
})->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/forgot-password', [AuthController::class, 'forgot_password']);
Route::post('/reset-password', [AuthController::class, 'reset_password']);

Route::view('/goodbye', 'DeleteAccount.goodbye')->name('goodbye');


Route::get('/ChangePassword', [PasswordController::class, 'index'])->name('ChangePassword')->middleware('auth');
Route::post('/ChangePassword', [PasswordController::class, 'update'])->name('ChangePassword')->middleware('auth');

Route::put('/Profile', [ProfileController::class, 'update'])->name('Profile')->middleware('auth');

Route::get('/export_pdf', [PdfExportController::class, 'export'])
    ->middleware('auth')
    ->name('export_pdf');

// Google Authentication
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');


Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');


// Forgot Password Routes
Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('forgot-password.request');
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->name('password.email');

Route::view('/terms', 'terms');
Route::view('/privacy', 'privacy');
Route::view('/about', 'about');
// Route::view('/how-it-works', 'how-it-works');


/*
|--------------------------------------------------------------------------
| Protected Routes (Only accessible after authentication)
|--------------------------------------------------------------------------
*/


// ✅ Email verification routes (must be outside 'verified' middleware)
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware(['auth'])->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::middleware(['auth'])->group(function () {
    // Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/send-fcm/{userId}', function ($userId, Request $request) {
        return app(NotificationController::class)->sendPushToUser($request->merge(['user_id' => $userId]));
    });
    Route::get('/send-push/{user}', [NotificationController::class, 'sendAlert']);
    Route::post('/save-fcm-token', [AuthController::class, 'storeToken']);

    // Route::get('/email/verify', function () {
    //     return view('auth.verify');
    // })->middleware(['auth'])->name('verification.notice');

    // Route::post('/email/verification-notification', function (Request $request) {
    //     $request->user()->sendEmailVerificationNotification();
    //     return back()->with('status', 'verification-link-sent');
    // })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    // Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    //     $request->fulfill();
    //     return redirect('/dashboard');
    // })->middleware(['auth', 'signed'])->name('verification.verify');

    // Blood Sugar Management
    Route::resource('/blood-sugar', BloodSugarController::class);

    Route::get('/subscription/details', [SubscriptionController::class, 'show'])->name('subscription.details');
    Route::get('/subscription/renew', [SubscriptionController::class, 'renew'])->name('subscription.renew');

    Route::get('/subscribe', [PaymentController::class, 'subscribe'])
        ->middleware('auth')
        ->name('payment.subscribe');

    // Payment Verify
    Route::get('/verify-payment', [PaymentController::class, 'verify'])
        ->middleware('auth')
        ->name('payment.verify');


    // Route::middleware('auth')->group(function () {
    //     Route::get('/symptoms', SymptomLogs::class)->name('symptoms');
    //     // Route::get('/symptoms', SymptomLogs::class);
    // });
    // Symptoms
    Route::get('/symptoms', SymptomLogs::class)->name('symptoms');

    // Meal Suggestions
    Route::get('/meal-suggestions', MealSuggestions::class)->name('meal-suggestions');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/fetch-analytics', [AnalyticsController::class, 'fetchAnalytics'])->name('analytics.fetch');

    // Route::middleware(['auth'])->group(function () {
    //     Route::get('/support', [SupportController::class, 'show'])->name('support.show');
    //     Route::post('/support/message', [SupportController::class, 'submitSupport'])->name('support.submit');
    //     Route::post('/support/feedback', [SupportController::class, 'submitFeedback'])->name('feedback.submit');
    // });

    Route::get('/support', [SupportController::class, 'show'])->name('support.show');
    Route::post('/support/message', [SupportController::class, 'submitSupport'])->name('support.submit');
    Route::post('/support/feedback', [SupportController::class, 'submitFeedback'])->name('feedback.submit');

    // Advance Search
    Route::get('/advance_search', [AdvancedSearchController::class, 'index'])->name('advance_search');
    Route::get('/export-csv', [AdvancedSearchController::class, 'exportCsv'])
        ->name('export.csv')
        ->middleware('auth');

    Route::get('/account_delete', [AccountController::class, 'confirm'])
        ->name('account_delete')
        ->middleware('auth');

    Route::delete('/account', [AccountController::class, 'destroy'])
        ->name('account.destroy')
        ->middleware('auth');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/'); // or route('home') if you have a named route
    })->name('logout')->middleware('auth');

    // Smart Recommendation
    Route::get('/Recommendations', [RecommendationController::class, 'index'])->middleware('auth')->name('Recommendations');

    // Subscription
    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription');
    Route::get('/invoice/{reference}', [InvoiceController::class, 'show'])->name('subscription.invoice');
    Route::get('/invoice/download/{reference}', [InvoiceController::class, 'download'])->name('invoice.download');

    // Profile
    Route::get('/Profile', [ProfileController::class, 'index'])->name('Profile');

    // Meal Logs
    // Route::middleware(['auth'])->group(function () {
    //     Route::get('/meals', [MealLogController::class, 'index'])->name('meals.index');
    //     Route::post('/meals', [MealLogController::class, 'store'])->name('meals.store');
    // });

    Route::get('/meal-log', [MealLogController::class, 'index'])->name('meal-log.index');
    Route::post('/meal-log', [MealLogController::class, 'store'])->name('meal-log.store');
    Route::delete('/meal-log/{meal}', [MealLogController::class, 'destroy'])->name('meal-log.destroy');

    // Notify
    Route::middleware(['auth'])->group(function () {
        Route::get('/settings', [UserSettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/user/notifications', [UserSettingsController::class, 'updateNotificationPreference'])->name('user.notifications.update');
    });

    // Conversion
    Route::post('/convert', [ConversionController::class, 'store'])->middleware('auth')->name('convert');;

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    // Chart & Reading Data
    Route::get('/seven-day-average', [AverageController::class, 'getSevenDayAverage'])->name('average.7day');
    Route::get('/latest-reading', [ReadingController::class, 'getLatestReading'])->name('reading.latest');
    Route::get('/chart-data', [ChartDataController::class, 'getChartData'])->name('chart.data');


    // Notifications System
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/dismiss/{id}', [NotificationController::class, 'dismiss'])
        ->name('notifications.dismiss');

    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/mark-all-sent', [NotificationController::class, 'markAllAsSent'])->name('notifications.read.all');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread.count');

    // Future Messages (Scheduled messaging system)
    // Route::resource('messages', FutureMessageController::class);


    // Route::post('/blood-test-alert', [BloodTestController::class, 'sendPushToUser']);
    Route::post('/blood-test-alert', [BloodTestController::class, 'sendPushToUser'])->name('blood.alert');

    Route::post('/reminders', [ReminderController::class, 'store'])->name('reminders.store');

    // Reports

    Route::get('/doctor', [ReportController::class, 'index'])->name('doctor');

    Route::get('/reports', [ReportController::class, 'generatePDF'])->name('reports');
    Route::post('/reports', [ReportController::class, 'shareSecureLink'])->name('reports.share')->middleware('auth');
    Route::match(['get', 'post'], '/report/{token}', [ReportController::class, 'viewSharedReport'])->name('reports.view');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Restricted to Admin Users)
|--------------------------------------------------------------------------
*/

//Route::middleware(['auth', 'is_admin'])->group(function ()  {
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/stats', [AdminController::class, 'stats'])->name('admin.stats');
Route::match(['get', 'post'], '/admin/users', [AdminController::class, 'manageUsers'])
    ->name('admin.users');

Route::get('/admin/user_profile/{user}/profile', [AdminController::class, 'viewUserProfile'])
    ->name('admin.user_profile');

Route::post('/admin/users/delete', [AdminController::class, 'deleteUser'])
    ->name('admin.user_delete');

Route::get('/admin/subscriptions', [AdminController::class, 'subscriptions'])
    ->name('admin.subscriptions');

Route::post('/admin/subscriptions/export', [AdminController::class, 'exportSubscriptions'])
    ->name('admin.subscription.export');

Route::get('/admin/feedback', [AdminController::class, 'indexFeedback'])
    ->name('admin.feedback');

Route::post('/admin/feedback', [AdminController::class, 'replyToFeedback'])
    ->name('admin.feedback');

Route::get('/admin/messages', [AdminController::class, 'create'])
    ->name('admin.messages');

Route::post('/admin/messages', [AdminController::class, 'store'])
    ->name('admin.messages.store');

Route::get('/admin/logs', [AdminController::class, 'logs'])->name('admin.logs');

Route::get('/admin/users/{user}/export', [AdminController::class, 'exportReadings'])
    ->name('admin.users.export');

Route::get('/admin/logs', [AdminController::class, 'userLogs'])
    ->name('admin.logs');

Route::get('/admin/meals/manage', function () {
    return view('admin.manage-meals');
})->name('admin.meals.manage');


Route::get('/admin/add-meals', function () {
    return view('admin.add-meals');
})->name('admin.add-meals');


Route::get('/admin/meals/manage', [AdminMealController::class, 'index'])->name('admin.meals.manage');
Route::get('/admin/meals/{meal}/edit', [AdminMealController::class, 'edit'])->name('admin.meals.edit');
Route::delete('/admin/meals/{meal}', [AdminMealController::class, 'destroy'])->name('admin.meals.delete');
Route::put('/admin/meals/{meal}', [AdminMealController::class, 'update'])->name('admin.meals.update');



// if (env('APP_ENV') !== 'local') {
//     URL::forceScheme('https');
// }

// if (env('APP_ENV')) {
//     URL::forceScheme('https');
// }
//});
