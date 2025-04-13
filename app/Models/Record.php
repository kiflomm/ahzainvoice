<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'record_number',
        'record_type',
        'start_date',
        'end_date',
        'purchase_type',
        'status',
        'description',
        'unit',
        'quantity',
        'unit_price',
        'value',
        'vat',
        'value_after_vat',
        'mrc_number',
        'cdn_number',
        'user_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'unit_price' => 'decimal:2',
        'value' => 'decimal:2',
        'vat' => 'decimal:2',
        'value_after_vat' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Get the client for this invoice
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the user who created this invoice
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate the next invoice number
     */
    public static function generateNextInvoiceNumber(): string
    {
        $lastInvoice = self::where('record_type', 'invoice')
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastInvoice) {
            return 'AHI0001';
        }

        $currentNumber = (int) substr($lastInvoice->record_number, 3);
        $nextNumber = $currentNumber + 1;

        return 'AHI' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate the next bill number
     */
    public static function generateNextBillNumber(): string
    {
        $lastBill = self::where('record_type', 'bill')
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastBill) {
            return 'AHB0001';
        }

        $currentNumber = (int) substr($lastBill->record_number, 3);
        $nextNumber = $currentNumber + 1;

        return 'AHB' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
