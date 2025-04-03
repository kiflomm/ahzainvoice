<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'item_number',
        'description',
        'unit',
        'quantity',
        'unit_price',
        'amount',
        'tax_rate',
        'tax_amount',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'amount' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];

    /**
     * Get the invoice that owns this item
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
