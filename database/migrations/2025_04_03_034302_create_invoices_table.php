<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained();
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('subtotal_amount', 10, 2); // Before tax
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(15.00); // 15% VAT in Ethiopia
            $table->string('amount_in_words')->nullable(); // Amount in words (e.g., "Six hundred fifty")
            $table->string('status')->default('pending'); // pending, paid, overdue, cancelled
            $table->date('payment_date')->nullable();
            $table->string('payment_method')->nullable(); // cash, cheque
            $table->string('cheque_number')->nullable(); // If payment by cheque
            $table->string('approver_name')->nullable(); // Person who approved the payment
            $table->string('cashier_name')->nullable(); // Cashier who processed the payment
            $table->text('notes')->nullable();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->foreignId('user_id')->constrained(); // who created this record
            $table->string('file_path')->nullable(); // for pdf/image uploads
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
