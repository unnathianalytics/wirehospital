<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new
    class extends Migration {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create(
                'complaint_followups',
                function (Blueprint $table) {
                    $table->id('id');
                    $table->foreignId('complaint_sheet_id')->constrained('complaint_sheets');
                    $table->date('followup_date');
                    $table->text('previous_complaint_status')->nullable();
                    $table->text('fresh_complaints_any')->nullable();
                    $table->text('fresh_complaints_duration')->nullable();
                    $table->text('asp_naadee')->nullable();
                    $table->text('asp_mutra_day')->nullable();
                    $table->text('asp_mutra_night')->nullable();
                    $table->text('asp_mutra_frequency')->nullable();
                    $table->text('asp_mutra_color')->nullable();
                    $table->text('asp_mutra_symptoms')->nullable();
                    $table->text('asp_mutra_others')->nullable();
                    $table->text('asp_mala_times')->nullable();
                    $table->text('asp_mala_pravrutti')->nullable();
                    $table->text('asp_mala_type')->nullable();
                    $table->text('asp_mala_digetion')->nullable();
                    $table->text('asp_mala_evacuation')->nullable();
                    $table->text('asp_jihwa_color')->nullable();
                    $table->text('asp_jihwa_coating')->nullable();
                    $table->text('asp_jihwa_others')->nullable();
                    $table->text('asp_shabda')->nullable();
                    $table->text('asp_sparsha')->nullable();
                    $table->text('asp_drik_conjunctiva')->nullable();
                    $table->text('asp_drik_sclera')->nullable();
                    $table->text('asp_drik_cornea')->nullable();
                    $table->text('asp_drik_eyelid')->nullable();
                    $table->text('asp_drik_other')->nullable();
                    $table->text('eao_agni')->nullable();
                    $table->text('eao_appetite')->nullable();
                    $table->text('eao_food_intake')->nullable();
                    $table->text('eao_food_quantity')->nullable();
                    $table->text('eao_ruchi')->nullable();
                    $table->text('eao_rasa_ichha')->nullable();
                    $table->text('eao_udara')->nullable();
                    $table->text('eao_udara_if')->nullable();
                    $table->text('eao_nidraa')->nullable();
                    $table->text('eao_gaatra')->nullable();
                    $table->text('eao_gaatra_symptoms')->nullable();
                    $table->text('eao_rajah_pravritti_lmp')->nullable();
                    $table->text('eao_rajah_pravritti_cycle')->nullable();
                    $table->text('eao_rajah_pravritti_cycle_nature')->nullable();
                    $table->text('eao_rajah_pravritti_bleeding_days')->nullable();
                    $table->text('oh_no_deliveries')->nullable();
                    $table->text('oh_no_children')->nullable();
                    $table->text('oh_type')->nullable();
                    $table->text('oh_abortion')->nullable();
                    $table->text('oh_abortion_no')->nullable();
                    $table->text('oh_misscarriage')->nullable();
                    $table->text('oh_misscarriage_no')->nullable();
                    $table->text('oh_garbhini_soothika_charyaa')->nullable();
                    $table->text('oh_sterilisation')->nullable();
                    $table->text('ge_bp')->nullable();
                    $table->text('ge_pulse')->nullable();
                    $table->text('ge_heart_rate')->nullable();
                    $table->text('ge_respiratory_rate')->nullable();
                    $table->text('ge_temperature')->nullable();
                    $table->text('ge_icterus')->nullable();
                    $table->text('ge_edema')->nullable();
                    $table->text('ge_edema_other')->nullable();
                    $table->text('ge_cyanosis')->nullable();
                    $table->text('ge_lymph_node')->nullable();
                    $table->text('ge_others')->nullable();
                    $table->text('grbs')->nullable();
                    $table->text('weight')->nullable();
                    $table->text('conclusion')->nullable();
                    $table->text('tp_treatment_plan')->nullable();
                    $table->text('tp_treatment_plan_guidelines')->nullable();
                    $table->text('probable_diagnosis')->nullable();
                    $table->text('lab_reports')->nullable();
                    $table->foreignId('doctor_assigned')->constrained('accounts')->nullable();
                    $table->foreignId('user')->constrained('users');
                    $table->timestamps();
                }
            );
        }
        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('complaint_followups');
        }
    };
