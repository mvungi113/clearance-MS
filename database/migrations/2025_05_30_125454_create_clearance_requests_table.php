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
        Schema::create('clearance_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id'); // references users table
            $table->string('department'); // e.g., Library, Hostel, etc.
            $table->string('student_name'); // for convenience
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('remarks')->nullable();
            $table->string('library_status')->nullable();
            $table->string('hostel_status')->nullable();
            $table->string('financial_status')->nullable();
            $table->string('sports_status')->nullable();
            $table->string('hod_status')->nullable();
            $table->string('estate_status')->nullable();         // <-- Add here
            $table->string('computer_lab_status')->nullable();   // <-- Add here
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clearance_requests');
    }
};
