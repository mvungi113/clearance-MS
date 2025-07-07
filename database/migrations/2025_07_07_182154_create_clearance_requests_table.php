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
            $table->unsignedBigInteger('student_id');
            $table->string('student_name');
            $table->string('department');
            $table->string('course')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('remarks')->nullable();

            // Department statuses and remarks
            $table->string('library_status')->nullable();
            $table->text('library_remarks')->nullable();

            $table->string('hostel_status')->nullable();
            $table->text('hostel_remarks')->nullable();

            $table->string('financial_status')->nullable();
            $table->text('financial_remarks')->nullable();

            $table->string('sports_status')->nullable();
            $table->text('sports_remarks')->nullable();

            $table->string('hod_status')->nullable();
            $table->text('hod_remarks')->nullable();

            $table->string('estate_status')->nullable();
            $table->text('estate_remarks')->nullable();

            $table->string('computer_lab_status')->nullable();
            $table->text('computer_lab_remarks')->nullable();

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
