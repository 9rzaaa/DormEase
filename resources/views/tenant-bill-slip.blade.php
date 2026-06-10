<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Bill Slip &mdash; {{ $tenant->first_name }} {{ $tenant->last_name }}</title>
<style>
    @page { size: 80mm auto; margin: 0; }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #fff;
        width: 80mm;
        padding: 0;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .slip {
        width: 80mm;
        padding: 7mm 7mm 8mm;
        display: flex;
        flex-direction: column;
        gap: 0;
    }
    .header {
        background: #E8175D;
        color: #fff;
        text-align: center;
        padding: 5mm 4mm 4mm;
        border-radius: 5px 5px 0 0;
        margin: -7mm -7mm 4mm;
    }
    .header .dorm {
        font-size: 6.5pt;
        font-weight: 700;
        opacity: .88;
        letter-spacing: .04em;
        text-transform: uppercase;
    }
    .header .title {
        font-size: 11pt;
        font-weight: 800;
        margin-top: 1mm;
        letter-spacing: -.01em;
    }
    .header .subtitle {
        font-size: 7pt;
        opacity: .82;
        margin-top: .5mm;
    }
    .tenant-block {
        background: #fff5f9;
        border: 1.5px solid #f4b8d0;
        border-radius: 5px;
        padding: 3mm 3.5mm;
        margin-bottom: 3.5mm;
    }
    .tenant-name {
        font-size: 10.5pt;
        font-weight: 800;
        color: #3a0e22;
        line-height: 1.2;
    }
    .tenant-meta {
        font-size: 7pt;
        color: #a0405e;
        margin-top: 1mm;
        display: flex;
        flex-direction: column;
        gap: .8mm;
    }
    .tenant-meta span {
        display: flex;
        align-items: center;
        gap: 1.5mm;
    }
    .section-label {
        font-size: 6.5pt;
        font-weight: 800;
        color: #E8175D;
        text-transform: uppercase;
        letter-spacing: .07em;
        margin-bottom: 2mm;
        padding-bottom: 1.5mm;
        border-bottom: 1px dashed #f4b8d0;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 3mm;
    }
    thead th {
        font-size: 6pt;
        font-weight: 800;
        color: #E8175D;
        text-transform: uppercase;
        letter-spacing: .05em;
        padding: 1.5mm 1mm;
        border-bottom: 1.5px solid #f4b8d0;
        text-align: left;
    }
    thead th:last-child { text-align: right; }
    tbody td {
        font-size: 7.5pt;
        color: #3a0e22;
        padding: 2mm 1mm;
        border-bottom: 1px dashed #fce8f1;
        vertical-align: top;
    }
    tbody td:last-child {
        text-align: right;
        font-weight: 700;
        white-space: nowrap;
    }
    tbody tr:last-child td { border-bottom: none; }
    .due-badge {
        display: inline-block;
        font-size: 5.5pt;
        font-weight: 700;
        padding: .5mm 1.5mm;
        border-radius: 3px;
        margin-top: .8mm;
    }
    .due-overdue {
        background: #ffe9ee;
        color: #e04867;
        border: 1px solid #ff9db0;
    }
    .due-unpaid {
        background: #fff6dc;
        color: #c58a00;
        border: 1px solid #f2cd63;
    }
    .total-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 3mm 3.5mm;
        background: #E8175D;
        border-radius: 5px;
        margin-bottom: 3.5mm;
    }
    .total-label {
        font-size: 8pt;
        font-weight: 700;
        color: rgba(255,255,255,.88);
    }
    .total-amount {
        font-size: 13pt;
        font-weight: 800;
        color: #fff;
        letter-spacing: -.02em;
    }
    .clear-block {
        text-align: center;
        padding: 4mm 3mm;
        background: #f0faf6;
        border: 1.5px solid #8ce0bb;
        border-radius: 5px;
        margin-bottom: 3.5mm;
    }
    .clear-block .clear-title {
        font-size: 10pt;
        font-weight: 800;
        color: #1f9d69;
    }
    .clear-block .clear-sub {
        font-size: 7pt;
        color: #2e9e68;
        margin-top: 1mm;
    }
    .note {
        background: #fff9e6;
        border: 1px solid #f0c040;
        border-radius: 4px;
        padding: 2mm 2.5mm;
        font-size: 6.5pt;
        color: #7a5400;
        line-height: 1.45;
        margin-bottom: 3.5mm;
    }
    .footer {
        padding-top: 3mm;
        border-top: 1px dashed #f4b8d0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .footer-date { font-size: 6pt; color: #b06080; }
    .footer-brand { font-size: 6pt; color: #E8175D; font-weight: 700; letter-spacing: .04em; }
    .sig-block {
        margin-bottom: 3.5mm;
        display: flex;
        flex-direction: column;
        gap: 5mm;
    }
    .sig-line {
        display: flex;
        flex-direction: column;
        gap: 1mm;
    }
    .sig-line-bar {
        width: 100%;
        height: 1px;
        background: #d0a0b8;
    }
    .sig-line-label {
        font-size: 6pt;
        color: #b06080;
        text-align: center;
        letter-spacing: .04em;
    }
    @media print {
        body { margin: 0; }
    }
</style>
</head>
<body>
<div class="slip">

    <div class="header">
        <div class="dorm">Sanctissimo Rosario Ladies Dormitory</div>
        <div class="title">Outstanding Bill Slip</div>
        <div class="subtitle">DormEase Billing System</div>
    </div>

    <div class="tenant-block">
        <div class="tenant-name">{{ $tenant->first_name }} {{ $tenant->last_name }}</div>
        <div class="tenant-meta">
            <span>Account ID: <strong>{{ $tenant->account_id }}</strong></span>
            <span>Room: <strong>{{ $tenant->floor && $tenant->room_number ? $tenant->floor . '-' . $tenant->room_number : ($tenant->room_number ?? 'N/A') }}</strong> &nbsp;&middot;&nbsp; {{ $tenant->stay_type ?? 'N/A' }}</span>
            <span>Status: <strong>{{ ucfirst($tenant->status) }}</strong></span>
        </div>
    </div>

    @if($bills->isEmpty())
        <div class="clear-block">
            <div class="clear-title">No Outstanding Balance</div>
            <div class="clear-sub">All water bills have been settled.</div>
        </div>
    @else
        <div class="section-label">Unpaid / Overdue Bills</div>
        <table>
            <thead>
                <tr>
                    <th>Billing Period</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bills as $bill)
                <tr>
                    <td>
                        {{ \Carbon\Carbon::parse($bill->billing_month)->format('F Y') }}
                        <br>
                        <span class="due-badge {{ $bill->payment_status === 'overdue' ? 'due-overdue' : 'due-unpaid' }}">
                            {{ ucfirst($bill->payment_status) }}
                        </span>
                    </td>
                    <td style="white-space:nowrap;">
                        {{ $bill->due_date ? \Carbon\Carbon::parse($bill->due_date)->format('M d, Y') : '—' }}
                    </td>
                    <td>&#8369;{{ number_format($bill->room_share, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-row">
            <span class="total-label">Total Outstanding</span>
            <span class="total-amount">&#8369;{{ number_format($total, 2) }}</span>
        </div>

        <div class="note">
            Please settle your outstanding balance at the admin office. Bring this slip as reference. Continued non-payment may affect your tenancy status.
        </div>
    @endif

    <div class="sig-block">
        <div class="sig-line">
            <div class="sig-line-bar"></div>
            <div class="sig-line-label">Tenant Signature over Printed Name</div>
        </div>
        <div class="sig-line">
            <div class="sig-line-bar"></div>
            <div class="sig-line-label">Admin / Staff Signature &amp; Date</div>
        </div>
    </div>

    <div class="footer">
        <div class="footer-date">Issued: {{ now()->format('F d, Y') }}</div>
        <div class="footer-brand">DormEase</div>
    </div>

</div>
</html>