<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'total_amount',
        'subtotal_amount',
        'tax_amount',
        'tax_rate',
        'amount_in_words',
        'status',
        'payment_date',
        'payment_method',
        'cheque_number',
        'approver_name',
        'cashier_name',
        'notes',
        'category_id',
        'user_id',
        'file_path',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'payment_date' => 'date',
        'total_amount' => 'decimal:2',
        'subtotal_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'tax_rate' => 'decimal:2',
    ];

    /**
     * Get the vendor for this invoice
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get the category for this invoice
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user who created this invoice
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all items for this invoice
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
