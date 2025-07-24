<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Display a web view of a user's subscription invoice.
     */
    public function show($reference)
    {
        $invoice = DB::table('invoices')->where('reference', $reference)->first();

        if (! $invoice) {
            abort(404, 'Invoice not found.');
        }

        $user = DB::table('users')->find($invoice->user_id);

        return view('subscription.invoice', [
            'user' => $user,
            'plan' => $invoice->plan,
            'amount' => $invoice->amount,
            'reference' => $invoice->reference,
            'date' => Carbon::parse($invoice->issued_at)->format('M d, Y h:i A'),
        ]);
    }

    /**
     * Download the invoice as a PDF.
     */
    public function download($reference)
    {
        $invoice = DB::table('invoices')->where('reference', $reference)->first();

        if (! $invoice) {
            abort(404, 'Invoice not found.');
        }

        $user = DB::table('users')->find($invoice->user_id);
        $date = Carbon::parse($invoice->issued_at)->format('M d, Y h:i A');

        $pdf = Pdf::loadView('invoices.pdf', [
            'user' => $user,
            'plan' => $invoice->plan,
            'amount' => $invoice->amount,
            'reference' => $invoice->reference,
            'date' => $date,
        ]);

        return $pdf->download("Invoice-{$invoice->reference}.pdf");
    }
}
