<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        return view('doctor.index');
    }

    public function shareLink(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:4',
        ]);

        $user = Auth::user();
        $token = Str::random(32);

        DB::table('shared_links')->insert([
            'user_id' => $user->id,
            'token' => $token,
            'password' => bcrypt($request->password),
            'expires_at' => now()->addDays(7),
            'created_at' => now()
        ]);

        $link = route('reports.view', ['token' => $token]);

        return response()->json(['link' => $link]);
    }

    public function generatePDF()
    {
        $user = Auth::user(); 

        $data = [
            'user' => $user,
            'readings' => $user->conversions()->orderBy('converted_at', 'desc')->take(30)->get()
        ];

        $pdf = Pdf::loadView('reports.blood-sugar', $data);
        return $pdf->download('blood_sugar_report.pdf');
    }

    public function shareSecureLink(Request $request)
{
    $request->validate([
        'password' => 'required|string|min:4'
    ]);

    $user = Auth::user();

    $token = Str::random(32);

    DB::table('report_links')->insert([
        'user_id' => $user->id,
        'token' => $token,
        'password_hash' => bcrypt($request->password),
        'created_at' => now(),
    ]);

    $link = route('reports.view', ['token' => $token]);

    return response()->json(['link' => $link]);
}

public function viewSharedReport(Request $request, $token)
{
    $record = DB::table('report_links')->where('token', $token)->first();

    if (!$record) {
        return response("Invalid or expired link.", 404);
    }

    if ($request->isMethod('post')) {
        if (password_verify($request->password, $record->password_hash)) {
            $user = User::find($record->user_id);
            $readings = DB::table('conversions')
                ->where('user_id', $user->id)
                ->orderByDesc('converted_at')
                ->limit(30)
                ->get();

            return view('reports.view', [
                'user' => $user,
                'readings' => $readings,
                'authorized' => true
            ]);
        }

        return back()->withErrors(['password' => '❌ Incorrect password.'])->withInput();
    }

    return view('reports.view', [
        'token' => $token,
        'authorized' => false
    ]);
}


}
