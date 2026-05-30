<?php

namespace App\Http\Controllers;

use App\Models\WaterBilling;
use App\Models\WaterRate;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReceiptController extends Controller
{
    public function download(Request $request, $billingId)
    {
        $billing = WaterBilling::with('tenant')->findOrFail($billingId);

        if ($billing->payment_status !== 'paid') {
            abort(403, 'Receipt is only available for paid billing records.');
        }

        $tenant = $billing->tenant;

        $rate = WaterRate::where(
            'effective_month',
            Carbon::parse($billing->billing_month)->format('Y-m-01')
        )->first();

        $ratePerM3   = $rate?->rate_per_m3 ?? 0;
        $consumption = max(0, $billing->curr_reading - $billing->prev_reading);

        $receiptNumber = 'RCP-' . Carbon::parse($billing->billing_month)->format('Y') . '-' . str_pad($billing->billing_id, 5, '0', STR_PAD_LEFT);

        $data = [
            'receipt_number'      => $receiptNumber,
            'date_issued'         => now()->format('M d, Y'),
            'tenant_name'         => trim($tenant->first_name . ' ' . $tenant->last_name),
            'room_number'         => $tenant->room_number ?? '-',
            'floor'               => $billing->floor,
            'billing_month_label' => Carbon::parse($billing->billing_month)->format('F Y'),
            'due_date'            => $billing->due_date
                ? Carbon::parse($billing->due_date)->format('M d, Y')
                : '-',
            'prev_reading'        => number_format((float) $billing->prev_reading, 2),
            'curr_reading'        => number_format((float) $billing->curr_reading, 2),
            'consumption'         => number_format($consumption, 2),
            'rate_per_m3'         => number_format((float) $ratePerM3, 4),
            'rooms_sharing'       => $billing->rooms_sharing ?? '-',
            'total_floor_bill'    => number_format((float) $billing->total_floor_bill, 2),
            'amount_paid'         => number_format((float) $billing->room_share, 2),
            'reference_code'      => $billing->payment_reference_code ?? '',
            'payment_method'      => 'Online Transfer',
            'confirmed_at'        => $billing->payment_submitted_at
                ? Carbon::parse($billing->payment_submitted_at)->format('M d, Y h:i A')
                : now()->format('M d, Y h:i A'),
        ];

        $html = $this->buildReceiptHtml($data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'receipt-' . str_replace('/', '-', $receiptNumber) . '-' . str_replace(' ', '-', strtolower($tenant->first_name . '-' . $tenant->last_name)) . '.pdf';

        $pdfContent = $dompdf->output();

        return response($pdfContent, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length'      => strlen($pdfContent),
        ]);
    }

    private function buildReceiptHtml(array $d): string
    {
        $refRow = !empty($d['reference_code']) ? '
            <tr>
                <td class="label">Payment Reference</td>
                <td class="value">' . htmlspecialchars($d['reference_code']) . '</td>
            </tr>
            <tr>
                <td class="label">Payment Method</td>
                <td class="value">' . htmlspecialchars($d['payment_method']) . '</td>
            </tr>
        ' : '';

        return '<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #1a1a2e; background: #fff; }

    .header {
        background: #E8175D;
        color: #fff;
        padding: 28px 32px 22px;
        position: relative;
    }
    .header-top {
        display: table;
        width: 100%;
        margin-bottom: 18px;
    }
    .header-left { display: table-cell; vertical-align: top; }
    .header-right { display: table-cell; vertical-align: top; text-align: right; }
    .logo-text { font-size: 22px; font-weight: bold; color: #fff; letter-spacing: -0.5px; }
    .logo-sub { font-size: 10px; color: rgba(255,255,255,0.75); margin-top: 3px; }
    .receipt-label { font-size: 13px; font-weight: bold; color: #fff; letter-spacing: 1px; text-transform: uppercase; }
    .receipt-sub { font-size: 10px; color: rgba(255,255,255,0.75); margin-top: 3px; }

    .header-bottom { display: table; width: 100%; }
    .header-pill {
        display: table-cell;
        width: 48%;
    }
    .header-pill-right {
        display: table-cell;
        width: 48%;
        text-align: right;
    }
    .pill-box {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.35);
        border-radius: 8px;
        padding: 8px 14px;
        display: inline-block;
    }
    .pill-label { font-size: 9px; color: rgba(255,255,255,0.7); text-transform: uppercase; letter-spacing: 1px; font-weight: bold; }
    .pill-value { font-size: 13px; font-weight: bold; color: #fff; margin-top: 2px; }

    .billed-section {
        background: #fdf0f5;
        border: 1px solid #fce4ec;
        border-radius: 10px;
        padding: 16px 20px;
        margin: 20px 32px;
        display: table;
        width: calc(100% - 64px);
    }
    .billed-left { display: table-cell; vertical-align: middle; }
    .billed-right { display: table-cell; vertical-align: middle; text-align: right; }
    .billed-to-label { font-size: 9px; color: #7a5f6e; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; margin-bottom: 4px; }
    .billed-name { font-size: 16px; font-weight: bold; color: #1a1a2e; }
    .billed-room { font-size: 11px; color: #7a5f6e; margin-top: 3px; }
    .period-label { font-size: 9px; color: #7a5f6e; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; margin-bottom: 4px; }
    .period-value { font-size: 15px; font-weight: bold; color: #1a1a2e; }
    .period-due { font-size: 11px; color: #7a5f6e; margin-top: 3px; }

    .section-label {
        font-size: 9px;
        font-weight: bold;
        color: #E8175D;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        padding: 0 32px;
        margin-bottom: 6px;
    }
    .divider {
        border: none;
        border-top: 1.5px solid #E8175D;
        margin: 0 32px 12px;
    }

    table.details {
        width: calc(100% - 64px);
        margin: 0 32px;
        border-collapse: collapse;
    }
    table.details tr td {
        padding: 7px 10px;
        font-size: 11.5px;
    }
    table.details tr:nth-child(even) td {
        background: #fff8fb;
    }
    table.details td.label { color: #7a5f6e; width: 55%; }
    table.details td.value { color: #1a1a2e; font-weight: 600; text-align: right; }
    table.details td.section-row { font-weight: bold; color: #1a1a2e; font-size: 12px; }

    .total-box {
        background: #E8175D;
        margin: 16px 32px 0;
        border-radius: 10px;
        padding: 14px 20px;
        display: table;
        width: calc(100% - 64px);
    }
    .total-left { display: table-cell; vertical-align: middle; }
    .total-right { display: table-cell; vertical-align: middle; text-align: right; }
    .total-label { font-size: 11px; font-weight: bold; color: #fff; letter-spacing: 0.5px; }
    .total-amount { font-size: 20px; font-weight: bold; color: #fff; }

    .meta-section {
        margin: 14px 32px 0;
        display: table;
        width: calc(100% - 64px);
    }
    .meta-box {
        background: #fdf0f5;
        border: 1px solid #fce4ec;
        border-radius: 8px;
        padding: 10px 14px;
        margin-bottom: 8px;
    }
    table.meta { width: 100%; border-collapse: collapse; }
    table.meta td { padding: 4px 0; font-size: 11px; }
    table.meta td.label { color: #7a5f6e; width: 45%; }
    table.meta td.value { color: #1a1a2e; font-weight: 600; text-align: right; }

    .status-box {
        background: #e8faf5;
        border: 1px solid #8ce0bb;
        border-radius: 8px;
        padding: 10px 14px;
        margin: 8px 32px 0;
        display: table;
        width: calc(100% - 64px);
    }
    .status-left { display: table-cell; vertical-align: middle; }
    .status-right { display: table-cell; vertical-align: middle; text-align: right; }
    .status-label { font-size: 11px; font-weight: bold; color: #1f9d69; }
    .status-confirmed { font-size: 10px; color: #7a5f6e; margin-top: 2px; }
    .status-badge { background: #1f9d69; color: #fff; font-size: 10px; font-weight: bold; padding: 3px 10px; border-radius: 999px; }

    .footer {
        margin-top: 24px;
        border-top: 1px solid #E5ECF6;
        padding: 14px 32px 10px;
        text-align: center;
    }
    .footer-note { font-size: 9.5px; color: #7a5f6e; line-height: 1.6; }
    .footer-bar {
        background: #E8175D;
        height: 5px;
        margin-top: 14px;
        border-radius: 0 0 4px 4px;
    }
</style>
</head>
<body>

<div class="header">
    <div class="header-top">
        <div class="header-left">
            <div class="logo-text">DormEase</div>
            <div class="logo-sub">Sanctissimo Rosario Ladies Dormitory</div>
        </div>
        <div class="header-right">
            <div class="receipt-label">Official Receipt</div>
            <div class="receipt-sub">Water Billing Payment</div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="header-pill">
            <div class="pill-box">
                <div class="pill-label">Receipt No.</div>
                <div class="pill-value">' . htmlspecialchars($d['receipt_number']) . '</div>
            </div>
        </div>
        <div class="header-pill-right">
            <div class="pill-box">
                <div class="pill-label">Date Issued</div>
                <div class="pill-value">' . htmlspecialchars($d['date_issued']) . '</div>
            </div>
        </div>
    </div>
</div>

<div class="billed-section">
    <div class="billed-left">
        <div class="billed-to-label">Billed To</div>
        <div class="billed-name">' . htmlspecialchars($d['tenant_name']) . '</div>
        <div class="billed-room">Room ' . htmlspecialchars($d['room_number']) . ' &middot; Floor ' . htmlspecialchars($d['floor']) . '</div>
    </div>
    <div class="billed-right">
        <div class="period-label">Billing Period</div>
        <div class="period-value">' . htmlspecialchars($d['billing_month_label']) . '</div>
        <div class="period-due">Due: ' . htmlspecialchars($d['due_date']) . '</div>
    </div>
</div>

<div class="section-label">Billing Breakdown</div>
<hr class="divider">

<table class="details">
    <tr><td class="label section-row" colspan="2">Floor ' . htmlspecialchars($d['floor']) . ' Water Consumption</td></tr>
    <tr><td class="label">&nbsp;&nbsp;Previous Reading</td><td class="value">' . htmlspecialchars($d['prev_reading']) . ' m&sup3;</td></tr>
    <tr><td class="label">&nbsp;&nbsp;Current Reading</td><td class="value">' . htmlspecialchars($d['curr_reading']) . ' m&sup3;</td></tr>
    <tr><td class="label">&nbsp;&nbsp;Consumption</td><td class="value">' . htmlspecialchars($d['consumption']) . ' m&sup3;</td></tr>
    <tr><td class="label">&nbsp;&nbsp;Rate per m&sup3;</td><td class="value">PHP ' . htmlspecialchars($d['rate_per_m3']) . '</td></tr>
    <tr><td class="label">&nbsp;&nbsp;Rooms Sharing</td><td class="value">' . htmlspecialchars($d['rooms_sharing']) . ' room(s)</td></tr>
    <tr><td class="label">&nbsp;&nbsp;Total Floor Bill</td><td class="value">PHP ' . htmlspecialchars($d['total_floor_bill']) . '</td></tr>
</table>

<div class="total-box">
    <div class="total-left">
        <div class="total-label">AMOUNT PAID</div>
    </div>
    <div class="total-right">
        <div class="total-amount">PHP ' . htmlspecialchars($d['amount_paid']) . '</div>
    </div>
</div>

<div class="meta-section">
    <div class="meta-box">
        <table class="meta">
            ' . $refRow . '
            <tr>
                <td class="label">Confirmed On</td>
                <td class="value">' . htmlspecialchars($d['confirmed_at']) . '</td>
            </tr>
        </table>
    </div>
</div>

<div class="status-box">
    <div class="status-left">
        <div class="status-label">Payment Status</div>
        <div class="status-confirmed">Verified and recorded by DormEase</div>
    </div>
    <div class="status-right">
        <span class="status-badge">PAID</span>
    </div>
</div>

<div class="footer">
    <div class="footer-note">
        This is an official receipt generated by DormEase. Please keep this for your records.<br>
        Sanctissimo Rosario Ladies Dormitory &nbsp;&middot;&nbsp; Generated: ' . htmlspecialchars($d['date_issued']) . '
    </div>
    <div class="footer-bar"></div>
</div>

</body>
</html>';
    }
}