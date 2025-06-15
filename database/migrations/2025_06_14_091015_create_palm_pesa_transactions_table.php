<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePalmPesaTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('palm_pesa_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('phone');
            $table->decimal('amount', 12, 2);
            $table->string('transaction_id')->nullable();
            $table->string('status')->default('pending');
            $table->json('palm_pesa_response')->nullable();
            $table->timestamps();

            $table->index('reference');
            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('palm_pesa_transactions');
    }
}
