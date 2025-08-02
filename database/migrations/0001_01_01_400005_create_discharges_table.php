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
        Schema::create('discharges', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('complaint_sheet_id')->constrained('complaint_sheets');
            $table->date('discharge_date')->nullable();
            $table->boolean('status')->default(true)->comment('dischargered by default');
            //other fields



            $table->foreignId('doctor_assigned')->constrained('accounts')->nullable();
            $table->foreignId('user')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discharges');
    }
};
