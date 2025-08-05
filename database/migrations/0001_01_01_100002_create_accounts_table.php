<?php

use App\Models\Account;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new
    class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('accounts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('group_id')->constrained('account_groups')->cascadeOnDelete();
                $table->string('name', 55);
                $table->string('address', 255)->nullable();
                $table->string('mobile', 10)->nullable();
                $table->string('email', 55)->nullable();
                $table->boolean('is_registered')->default(false);
                $table->foreignId('state_id')->constrained()->nullable();
                $table->string('gstin', 15)->nullable();
                $table->string('pan', 10)->nullable();
                $table->boolean('is_additive')->default(true);
                $table->decimal('op_balance')->default('0.00');
                $table->string('cr_dr')->default('dr');
                $table->boolean('is_editable')->default(true);
                $table->boolean('is_deletable')->default(true);

                $table->string('op_number')->unique()->nullable();
                $table->enum('gender', ['Male', 'Female'])->nullable();
                $table->date('date_of_birth')->nullable();
                $table->string('occupation')->nullable();
                $table->string('referred_by', 55)->nullable();
                $table->string('address_proof_id')->nullable();
                $table->string('address_proof_number')->nullable();
                $table->boolean('is_updated')->default(false)->comment('for Patients only');
                $table->boolean('admission_status')->default('0')->comment('0-OP, 1=IP');

                $table->tinyText('image')->nullable();
                $table->foreignId('user')->default(1);
                $table->timestamps();
            });
        }


        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('accounts');
        }
    };
