<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Query\Builder;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory, LogsActivity;
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()
            ->logAll()
            ->useLogName('Invoice');
    }
    protected $fillable = [
        'financial_year_id',
        'voucher_series_id',
        'invoice_type_id',
        'store_id',
        'destination_store_id',
        'tax_type_id',
        'invoice_number',
        'invoice_date',
        'invoice_time',
        'account_id',
        'einvoice_ack_date',
        'einvoice_ack_no',
        'einvoice_irn',
        'einvoice_qrcode',
        'einvoice_qrcode_ksa',
        'einvoice_required',
        'eway_bill_date_gst',
        'eway_bill_no_gst',
        'eway_bill_required',
        'description',
        'user',
    ];

    public function financialYear(): BelongsTo
    {
        return $this->belongsTo(FinancialYear::class, 'financial_year_id');
    }
    public function invoiceType()
    {
        return $this->belongsTo(InvoiceType::class, 'invoice_type_id');
    }
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    public function invoiceSundries()
    {
        return $this->hasMany(InvoiceSundry::class);
    }
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
    public function series()
    {
        return $this->belongsTo(VoucherSeries::class, 'voucher_series_id');
    }
    public function taxType(): BelongsTo
    {
        return $this->belongsTo(TaxType::class, 'tax_type_id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
    public function destinationStore()
    {
        return $this->belongsTo(Store::class, 'destination_store_id');
    }
    public function invoiceItemTotal(): float
    {
        return collect($this->items)->sum('item_amount');
    }

    public function invoiceSundryTotal(): float
    {
        return $this->invoiceSundries->sum(function ($s) {
            $tempAmount = (float) ($s['sundry_amount'] ?? 0);
            $adjustment = $s['amount_adjustment'] === '-' ? -1 : 1;
            return $adjustment * $tempAmount;
        });
    }
    public function getInvoiceTotal()
    {
        return $this->invoiceItemTotal() + $this->invoiceSundryTotal();
    }

    /**
     * Generate a unique invoice number based on voucher series, invoice type, and invoice date.
     *
     * @param int $voucherSeriesId
     * @param int $invoiceTypeId
     * @param string|null $invoiceDate
     * @return string
     */
    public static function generateInvoiceNumber(int $voucherSeriesId, int $invoiceTypeId, ?string $invoiceDate = null): string
    {
        $voucherSeries = VoucherSeries::find($voucherSeriesId);

        if (!$voucherSeries || $voucherSeries->vn_type === 'manual') {
            return '';
        }

        $invoiceDate = $invoiceDate ? Carbon::parse($invoiceDate) : now();
        $financialYearData = getUserFinancialYearDates();
        $fromDate = Carbon::parse($financialYearData['from_date'])->startOfDay();
        $toDate = Carbon::parse($financialYearData['to_date'])->endOfDay();
        $financialYear = $fromDate->format('y') . '-' . $toDate->format('y');

        $prefix = $voucherSeries->vn_prefix ?? '';
        $sep1 = $voucherSeries->vn_sep_1 ?? '';
        $sep2 = $voucherSeries->vn_sep_2 ?? '/';
        $suffix = $voucherSeries->vn_sufix ?? '';
        $startNumber = (int) ($voucherSeries->vn_from ?? 1);

        $lastInvoice = self::where('voucher_series_id', $voucherSeriesId)
            ->where('invoice_type_id', $invoiceTypeId)
            ->whereBetween('invoice_date', [$fromDate->toDateString(), $toDate->toDateString()])
            ->orderByDesc('id')
            ->first();

        $nextNumber = $startNumber;
        if ($lastInvoice && preg_match(
            '/' . preg_quote($prefix . $sep1 . '', '/') . '(\d+)' . preg_quote($sep2 . $financialYear . $suffix, '/') . '/',
            $lastInvoice->invoice_number,
            $matches
        )) {
            $nextNumber = ((int) $matches[1]) + 1;
        }

        // 6. Generate and check for uniqueness
        do {
            $formattedNumber = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            $invoiceNumber = "$prefix$sep1$formattedNumber$sep2$financialYear$suffix";
            $nextNumber++;
        } while (
            self::where('invoice_number', $invoiceNumber)
            ->where('voucher_series_id', $voucherSeriesId)
            ->where('invoice_type_id', $invoiceTypeId)
            ->exists()
        );

        return $invoiceNumber;
    }
}
