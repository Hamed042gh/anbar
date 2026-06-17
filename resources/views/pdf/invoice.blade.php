<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
<meta charset="UTF-8">
<style>
    @font-face {
        font-family: 'Vazirmatn';
        src: url('{{ public_path("fonts/vazirmatn/Vazirmatn-Regular.ttf") }}');
    }
    @font-face {
        font-family: 'Vazirmatn';
        font-weight: bold;
        src: url('{{ public_path("fonts/vazirmatn/Vazirmatn-Bold.ttf") }}');
    }

    /* فونت تو فایل اصلی تعریف شده بود ولی هیچ‌جا apply نشده بود */
    body {
        font-family: 'Vazirmatn', sans-serif;
        margin: 0;
        background-color: #eef1f8;
        color: #1e293b;
    }

    /* ===== کارت اصلی صفحه (افکت شناور روی پس‌زمینه) ===== */
    .page-card {
        max-width: 760px;
        margin: 24px auto;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(49, 46, 129, 0.08);
        overflow: hidden;
    }

    .ribbon {
        height: 6px;
        background: linear-gradient(90deg, #f59e0b, #fbbf24, #f59e0b);
    }

    /* ===== هدر ===== */
    .header {
        position: relative;
        background: linear-gradient(135deg, #4338ca 0%, #312e81 100%);
        color: white;
        padding: 26px 32px 22px;
    }
    .header-table { width: 100%; }
    .brand-table td { vertical-align: middle; }
    .monogram {
        width: 42px;
        height: 42px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.35);
        border-radius: 10px;
        text-align: center;
        line-height: 42px;
        font-size: 20px;
        font-weight: bold;
        color: #fbbf24;
    }
    .brand-text { padding-right: 12px; }
    .logo-title { font-size: 19px; font-weight: bold; }
    .logo-sub { font-size: 11px; opacity: 0.7; margin-top: 3px; }

    .meta-cell { text-align: left; vertical-align: middle; }
    .inv-pill {
        display: inline-block;
        background: rgba(255,255,255,0.14);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 8px;
        padding: 6px 16px;
        font-size: 16px;
        font-weight: bold;
    }
    .inv-date { font-size: 11px; opacity: 0.75; margin-top: 6px; }
    .status-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: bold;
        margin-top: 8px;
    }
    .status-confirmed { background: #dcfce7; color: #16a34a; }
    .status-cancelled { background: #fee2e2; color: #dc2626; }
    .status-draft     { background: #fef9c3; color: #ca8a04; }

    /* واترمارک فقط برای وضعیت‌های غیرنهایی */
    .watermark {
        position: absolute;
        top: 280px;
        left: 50%;
        transform: translateX(-50%) rotate(-25deg);
        font-size: 84px;
        font-weight: bold;
        white-space: nowrap;
        z-index: 0;
    }

    /* ===== کارت‌های اطلاعات ===== */
    .info-section { padding: 22px 32px 0; }
    .info-section table { width: 100%; border-collapse: separate; border-spacing: 12px 0; }
    .info-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 18px;
        vertical-align: top;
        width: 50%;
    }
    .info-card.accent-primary { border-top: 3px solid #4338ca; }
    .info-card.accent-gold    { border-top: 3px solid #f59e0b; }
    .info-card h4 {
        font-size: 11px;
        font-weight: bold;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e2e8f0;
    }
    .info-card.accent-primary h4 { color: #4338ca; }
    .info-card.accent-gold h4    { color: #b45309; }
    .info-card p { margin-bottom: 5px; font-size: 13px; color: #334155; }
    .info-card .label { color: #64748b; font-size: 12px; }

    /* ===== جدول اقلام ===== */
    .table-section { padding: 20px 32px 0; }
    .table-wrap { border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; }
    .items-table { width: 100%; border-collapse: collapse; }
    .items-table thead tr { background: linear-gradient(90deg, #4338ca, #312e81); color: white; }
    .items-table thead th {
        padding: 11px 12px;
        font-size: 12px;
        font-weight: bold;
        text-align: right;
    }
    .items-table tbody tr { border-bottom: 1px solid #f1f5f9; }
    .items-table tbody tr.even { background-color: #f8fafc; }
    .items-table tbody td {
        padding: 10px 12px;
        font-size: 13px;
        color: #334155;
    }
    .text-left  { text-align: left; }
    .text-right { text-align: right; }
    .font-bold  { font-weight: bold; }

    /* ===== جمع کل ===== */
    .summary-section { padding: 20px 32px 0; }
    .summary-wrap {
        width: 280px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        background: #f8fafc;
    }
    .summary-table { width: 100%; border-collapse: collapse; }
    .summary-table td {
        padding: 8px 14px;
        font-size: 13px;
        color: #475569;
        border-bottom: 1px dashed #e2e8f0;
    }
    .summary-table .total-row td {
        background: #312e81;
        color: #ffffff;
        font-size: 15px;
        font-weight: bold;
        padding: 14px;
        border-bottom: none;
    }

    /* ===== مهر و امضا ===== */
    .signature-section { padding: 26px 32px 0; }
    .signature-table { width: 100%; }
    .sig-box { width: 50%; text-align: center; }
    .stamp-circle {
        width: 88px;
        height: 88px;
        margin: 0 auto 8px;
        border: 1.5px dashed #cbd5e1;
        border-radius: 50%;
        text-align: center;
        line-height: 1.4;
        font-size: 10px;
        color: #94a3b8;
        padding-top: 28px;
    }
    .sig-label { font-size: 12px; color: #475569; font-weight: bold; }

    /* ===== فوتر ===== */
    .footer {
        margin: 28px 32px 28px;
        background: #f8fafc;
        border-radius: 10px;
        padding: 14px 20px;
        border-top: 3px solid #4338ca;
    }
    .footer-table { width: 100%; }
    .tracking-code { font-size: 11px; color: #64748b; }
    .tracking-code strong { color: #312e81; }
    .print-date { font-size: 11px; color: #94a3b8; text-align: left; }
    .legal-note { font-size: 10px; color: #cbd5e1; margin-top: 8px; text-align: center; }
</style>
</head>
<body>

<div class="page-card">

    <div class="ribbon"></div>

    {{-- ===== هدر ===== --}}
    <div class="header">

        @if(in_array($invoice->status, ['cancelled', 'draft']))
            <div class="watermark"
                 style="color: {{ $invoice->status === 'cancelled' ? 'rgba(254,255,255,0.10)' : 'rgba(255,255,255,0.10)' }};">
                {{ $invoice->status === 'cancelled' ? 'لغو شده' : 'پیش‌نویس' }}
            </div>
        @endif

        <table class="header-table">
            <tr>
                <td>
                    <table class="brand-table">
                        <tr>
                            <td><div class="monogram">س</div></td>
                            <td class="brand-text">
                                <div class="logo-title">سیستم انبارداری</div>
                                <div class="logo-sub">نرم‌افزار مدیریت انبار و فروش</div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="meta-cell">
                    <span class="inv-pill">{{ $invoice->number }}</span>
                    <div class="inv-date">
                        تاریخ: {{ \Morilog\Jalali\Jalalian::fromDateTime($invoice->issued_at)->format('Y/m/d') }}
                    </div>
                    <div>
                        <span class="status-badge status-{{ $invoice->status }}">
                            {{ match($invoice->status) {
                                'confirmed' => '● تایید شده',
                                'cancelled' => '● لغو شده',
                                default     => '● پیش‌نویس',
                            } }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ===== اطلاعات مشتری و فاکتور ===== --}}
    <div class="info-section">
        <table>
            <tr>
                <td class="info-card accent-primary">
                    <h4>اطلاعات مشتری</h4>
                    <p><strong>{{ $invoice->customer->name }}</strong></p>
                    <p><span class="label">تلفن: </span>{{ $invoice->customer->phone ?? '—' }}</p>
                    <p><span class="label">آدرس: </span>{{ $invoice->customer->address ?? '—' }}</p>
                </td>
                <td class="info-card accent-gold">
                    <h4>اطلاعات فاکتور</h4>
                    <p><span class="label">شماره: </span><strong>{{ $invoice->number }}</strong></p>
                    <p><span class="label">انبار: </span>{{ $invoice->warehouse->name }}</p>
                    <p><span class="label">صادرکننده: </span>{{ $invoice->user->name }}</p>
                </td>
            </tr>
        </table>
    </div>

    {{-- ===== جدول اقلام ===== --}}
    <div class="table-section">
        <div class="table-wrap">
            <table class="items-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نام کالا</th>
                        <th>SKU</th>
                        <th class="text-left">تعداد</th>
                        <th class="text-left">قیمت واحد</th>
                        <th class="text-left">تخفیف</th>
                        <th class="text-left">جمع</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $i => $item)
                    <tr class="{{ $i % 2 === 1 ? 'even' : '' }}">
                        <td>{{ $i + 1 }}</td>
                        <td class="font-bold">{{ $item->variant->product->name }}</td>
                        <td>{{ $item->variant->sku }}</td>
                        <td class="text-left">{{ number_format($item->quantity) }}</td>
                        <td class="text-left">{{ number_format($item->unit_price) }} ت</td>
                        <td class="text-left">{{ number_format($item->discount_amount) }} ت</td>
                        <td class="text-left font-bold">{{ number_format($item->total_price) }} ت</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== جمع کل ===== --}}
    <div class="summary-section">
        <div class="summary-wrap">
            <table class="summary-table">
                <tr>
                    <td>جمع کل اقلام</td>
                    <td class="text-left">{{ number_format($invoice->total_amount) }} تومان</td>
                </tr>
                <tr>
                    <td>تخفیف</td>
                    <td class="text-left">{{ number_format($invoice->discount_amount) }} تومان</td>
                </tr>
                <tr>
                    <td>مالیات (۹٪)</td>
                    <td class="text-left">{{ number_format($invoice->tax_amount) }} تومان</td>
                </tr>
                <tr class="total-row">
                    <td>مبلغ قابل پرداخت</td>
                    <td class="text-left">{{ number_format($invoice->payable_amount) }} تومان</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ===== مهر و امضا ===== --}}
    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td class="sig-box">
                    <div class="stamp-circle">محل مهر<br>و امضا</div>
                    <div class="sig-label">امضای فروشنده</div>
                </td>
                <td class="sig-box">
                    <div class="stamp-circle">محل مهر<br>و امضا</div>
                    <div class="sig-label">امضای خریدار</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ===== فوتر ===== --}}
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td class="tracking-code">
                    کد پیگیری: <strong>{{ strtoupper(substr(md5($invoice->number.$invoice->id), 0, 8)) }}</strong>
                </td>
                <td class="print-date">
                    تاریخ چاپ: {{ \Morilog\Jalali\Jalalian::now()->format('Y/m/d H:i') }}
                </td>
            </tr>
        </table>
        <div class="legal-note">این فاکتور به صورت سیستمی صادر شده و بدون مهر و امضا فاقد ارزش رسمی است</div>
    </div>

</div>

</body>
</html>