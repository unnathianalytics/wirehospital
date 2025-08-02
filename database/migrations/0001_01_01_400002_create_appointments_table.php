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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('id');
            $table->string('type')->default('Physical');
            $table->string('appointment_number');
            $table->foreignId('patient_id')->constrained('accounts');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->tinyText('description');
            $table->string('status')->default('Open');
            $table->foreignId('doctor_id')->nullable()->constrained('accounts');
            $table->foreignId('user')->default(1)->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
