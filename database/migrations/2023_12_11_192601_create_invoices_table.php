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
            $table->string('invoice_number', 50);
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('sections')->cascadeOnDelete();
            $table->string('product', 50);
            $table->string('status', 50);
            $table->integer('value_status');
            $table->date('payment_date')->nullable();
            $table->text('note')->nullable();
            $table->string('user', 300);
            $table->decimal('amount_collection', 19, 2)->nullable();
            $table->decimal('amount_commission', 19, 2);
            $table->decimal('discount', 19, 2);
            $table->decimal('value_vat', 19, 2);
            $table->string('rate_vat', 999);
            $table->decimal('remaining_amount', 19, 2)->default(0.00);
            $table->decimal('total', 19, 2);
            $table->softDeletes();
            $table->timestamps();
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
