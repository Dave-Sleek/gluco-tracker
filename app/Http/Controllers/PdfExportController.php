<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use TCPDF;

class PdfExportController extends Controller
{
    public function export()
    {
        $user = Auth::user();

        $rows = DB::table('conversions as c')
            ->join('users as u', 'c.user_id', '=', 'u.id')
            ->where('u.id', $user->id)
            ->orderByDesc('c.converted_at')
            ->get([
                'u.full_name',
                'u.email',
                'c.original_value',
                'c.original_unit',
                'c.converted_value',
                'c.converted_unit',
                'c.type',
                'c.converted_at'
            ]);

        if ($rows->isEmpty()) {
            return redirect()->back()->with('error', 'No readings available.');
        }

        $user_info = [
            'full_name' => $rows[0]->full_name,
            'email' => $rows[0]->email,
        ];

        // Initialize PDF
        $pdf = new TCPDF();
        $pdf->SetCreator('Gluco Tracker');
        $pdf->SetAuthor('Health Tracker');
        $pdf->SetTitle('My Blood Sugar Report');
        $pdf->SetMargins(15, 20, 15);
        $pdf->AddPage();

        // Build HTML
        $html = '
        <h2 style="text-align:center;">My Blood Sugar Report</h2>
        <hr>
        <p><strong>Full Name:</strong> ' . e($user_info['full_name']) . '</p>
        <p><strong>Email:</strong> ' . e($user_info['email']) . '</p>
        <br>
        <table border="1" cellpadding="5">
        <thead>
        <tr style="background-color:#f2f2f2;">
        <th>Original</th>
        <th>Converted</th>
        <th>Type</th>
        <th>Date</th>
        </tr>
        </thead>
        <tbody>';

        foreach ($rows as $r) {
            $html .= '<tr>
                <td>' . $r->original_value . ' ' . $r->original_unit . '</td>
                <td>' . $r->converted_value . ' ' . $r->converted_unit . '</td>
                <td>' . ucfirst($r->type) . '</td>
                <td>' . $r->converted_at . '</td>
            </tr>';
        }

        $html .= '</tbody></table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('my_blood_sugar_report.pdf', 'D');

        return response()->noContent(); // TCPDF handles the output
    }
}
