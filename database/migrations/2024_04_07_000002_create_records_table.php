<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('record_number');
            $table->string('record_type');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('purchase_type');
            $table->string('status');
            $table->text('description')->nullable();
            $table->string('unit');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('value', 10, 2);
            $table->decimal('vat', 10, 2);
            $table->decimal('value_after_vat', 10, 2);
            $table->string('mrc_number')->nullable();
            $table->string('cdn_number')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
