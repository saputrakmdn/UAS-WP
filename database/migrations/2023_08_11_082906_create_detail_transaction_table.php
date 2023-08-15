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
        Schema::create('detail_transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('detail_transaction_qty');
            $table->date('detail_transaction_return_date');
            $table->date('detail_transaction_actual_return_date')->nullable();
            $table->integer('detail_transaction_fine_days')->nullable();
            $table->integer('detail_transaction_fine')->nullable();
            $table->foreignId('detail_transaction_book_id')
                ->constrained('book', 'id')
                ->onDelete('cascade');
            $table->foreignId('detail_transaction_transaction_id')
                ->constrained('transaction', 'id')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaction');
    }
};
