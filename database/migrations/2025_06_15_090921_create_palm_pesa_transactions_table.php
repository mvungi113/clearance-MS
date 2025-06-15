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
            $table->uuid('reference')->unique();
            $table->string('phone');
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('pending');
            $table->string('user_email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('transaction_id')->nullable();
            $table->json('palm_pesa_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('palm_pesa_transactions');
    }
};
