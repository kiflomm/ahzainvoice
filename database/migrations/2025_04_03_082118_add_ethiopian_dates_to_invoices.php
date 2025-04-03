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
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('calendar_type')->default('G'); // G = Gregorian, E = Ethiopian
            $table->string('ethiopian_invoice_date')->nullable(); // Format: DD/MM/YYYY in Ethiopian calendar
            $table->string('ethiopian_due_date')->nullable();
            $table->string('ethiopian_payment_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('calendar_type');
            $table->dropColumn('ethiopian_invoice_date');
            $table->dropColumn('ethiopian_due_date');
            $table->dropColumn('ethiopian_payment_date');
        });
    }
};
