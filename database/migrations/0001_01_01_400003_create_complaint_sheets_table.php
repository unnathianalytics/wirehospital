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
        Schema::create('complaint_sheets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('case_no')->unique();
            $table->foreignId('patient_id')->constrained('accounts');
            $table->date('complaint_date');
            $table->string('complaint_type')->default('OP');
            $table->date('admission_date')->nullable();
            $table->time('admission_time')->nullable();

            $table->string('ip_number')->nullable();
            $table->boolean('is_discharged')->default(true);
            $table->string('floor_number')->nullable();
            $table->string('room_number')->nullable();
            $table->string('bed_number')->nullable();
            $table->foreignId('user')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_sheets');
    }
};
