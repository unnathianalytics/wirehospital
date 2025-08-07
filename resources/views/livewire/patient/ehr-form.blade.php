<div class="container">

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-9">
                <h2 class="mb-4">Medical History Form</h2>
                <ul class="nav nav-pills" id="medicalFormTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="complaints-tab" data-bs-toggle="tab"
                            data-bs-target="#complaints" type="button" role="tab" aria-controls="complaints"
                            aria-selected="true">Complaints</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history"
                            type="button" role="tab" aria-controls="history" aria-selected="false">Medical
                            History</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="lifestyle-tab" data-bs-toggle="tab" data-bs-target="#lifestyle"
                            type="button" role="tab" aria-controls="lifestyle"
                            aria-selected="false">Lifestyle</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="eating-tab" data-bs-toggle="tab" data-bs-target="#eating"
                            type="button" role="tab" aria-controls="eating" aria-selected="false">Eating
                            Habits</button>
                    </li>
                    @if ($ehr->patient->gender == 'Female')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reproductive-tab" data-bs-toggle="tab"
                                data-bs-target="#reproductive" type="button" role="tab"
                                aria-controls="reproductive" aria-selected="false">Reproductive
                                Health</button>
                        </li>
                    @endif
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="physical-tab" data-bs-toggle="tab" data-bs-target="#physical"
                            type="button" role="tab" aria-controls="physical" aria-selected="false">Physical
                            Examination</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="diagnosis-tab" data-bs-toggle="tab" data-bs-target="#diagnosis"
                            type="button" role="tab" aria-controls="diagnosis" aria-selected="false">Diagnosis &
                            Plan</button>
                    </li>
                </ul>
                <form class="tab-content mt-3" id="medicalForm" wire:submit='update'>
                    <div class="tab-pane fade show active" id="complaints" role="tabpanel"
                        aria-labelledby="complaints-tab">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="present_complaints" class="form-label">Present Complaints</label>
                                <textarea class="form-select form-select-sm" id="present_complaints" wire:model="present_complaints" rows="4"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="past_complaints" class="form-label">Past Complaints</label>
                                <textarea class="form-select form-select-sm" id="past_complaints" wire:model="past_complaints" rows="4"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="present_complaint_duration" class="form-label">Duration of Present
                                    Complaints</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="present_complaint_duration" wire:model="present_complaint_duration">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="past_complaint_duration" class="form-label">Duration of Past
                                    Complaints</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="past_complaint_duration" wire:model="past_complaint_duration">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="course_of_complaints" class="form-label">Course of Complaints</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="course_of_complaints" wire:model="course_of_complaints">
                            </div>

                        </div>

                    </div>
                    <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="history_bp" class="form-label">History of Blood Pressure</label>
                                <select class="form-select form-select-sm focusable" id="history_bp"
                                    wire:model="history_bp">
                                    <option value="hyper">Hyper</option>
                                    <option value="hypo">Hypo</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="bp_duration" class="form-label">BP Duration</label>
                                <input type="text" class="form-select form-select-sm focusable" id="bp_duration"
                                    wire:model="bp_duration">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="history_sugar" class="form-label">History of Diabetes</label>
                                <select class="form-select form-select-sm focusable" id="history_bp"
                                    wire:model="history_sugar">
                                    <option value="Diabetes Mellitus">Diabetes Mellitus</option>
                                    <option value="Diabetes Insipidus">Diabetes Insipidus</option>
                                </select>

                            </div>
                            <div class="col-md-6">
                                <label for="sugar_duration" class="form-label">Diabetes Duration</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="sugar_duration" wire:model="sugar_duration">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="history_thyroid" class="form-label">History of Thyroid</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="history_thyroid" wire:model="history_thyroid">
                            </div>
                            <div class="col-md-6">
                                <label for="thyroid_duration" class="form-label">Thyroid Duration</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="thyroid_duration" wire:model="thyroid_duration">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="others_history" class="form-label">Other Medical History</label>
                                <textarea class="form-select form-select-sm" id="others_history" wire:model="others_history" rows="4"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="family_history" class="form-label">Family History</label>
                                <textarea class="form-select form-select-sm" id="family_history" wire:model="family_history" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="treatment_history_type" class="form-label">Treatment History Type</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="treatment_history_type" wire:model="treatment_history_type">
                            </div>
                            <div class="col-md-6">
                                <label for="treatment_history_medications" class="form-label">Medications</label>
                                <textarea class="form-select form-select-sm" id="treatment_history_medications"
                                    wire:model="treatment_history_medications" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="treatment_history_treatments" class="form-label">Treatments</label>
                                <textarea class="form-select form-select-sm" id="treatment_history_treatments"
                                    wire:model="treatment_history_treatments" rows="4"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="surgical_history" class="form-label">Surgical History</label>
                                <textarea class="form-select form-select-sm" id="surgical_history" wire:model="surgical_history" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="lifestyle" role="tabpanel" aria-labelledby="lifestyle-tab">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="wakesup_at" class="form-label">Wake Up Time</label>
                                <input type="time" class="form-select form-select-sm focusable" id="wakesup_at"
                                    wire:model="wakesup_at">
                            </div>
                            <div class="col-md-6">
                                <label for="ushapana" class="form-label">Ushapana</label>
                                <input type="text" class="form-select form-select-sm focusable" id="ushapana"
                                    wire:model="ushapana">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ushapana_quantity" class="form-label">Ushapana Quantity</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="ushapana_quantity" wire:model="ushapana_quantity">
                            </div>
                            <div class="col-md-6">
                                <label for="exercise" class="form-label">Exercise</label>
                                <input type="text" class="form-select form-select-sm focusable" id="exercise"
                                    wire:model="exercise">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="exercise_duration" class="form-label">Exercise Duration</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="exercise_duration" wire:model="exercise_duration">
                            </div>
                            <div class="col-md-6">
                                <label for="bath" class="form-label">Bath</label>
                                <input type="text" class="form-select form-select-sm focusable" id="bath"
                                    wire:model="bath">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="breakfast" class="form-label">Breakfast</label>
                                <input type="text" class="form-select form-select-sm focusable" id="breakfast"
                                    wire:model="breakfast">
                            </div>
                            <div class="col-md-6">
                                <label for="nature_of_work" class="form-label">Nature of Work</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="nature_of_work" wire:model="nature_of_work">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nature_of_work_timings" class="form-label">Work Timings</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="nature_of_work_timings" wire:model="nature_of_work_timings">
                            </div>
                            <div class="col-md-6">
                                <label for="lunch" class="form-label">Lunch</label>
                                <input type="text" class="form-select form-select-sm focusable" id="lunch"
                                    wire:model="lunch">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="snacks" class="form-label">Snacks</label>
                                <input type="text" class="form-select form-select-sm focusable" id="snacks"
                                    wire:model="snacks">
                            </div>
                            <div class="col-md-6">
                                <label for="evening_exercise" class="form-label">Evening Exercise</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="evening_exercise" wire:model="evening_exercise">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="evening_exercise_nature_duration" class="form-label">Evening Exercise
                                    Nature &
                                    Duration</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="evening_exercise_nature_duration"
                                    wire:model="evening_exercise_nature_duration">
                            </div>
                            <div class="col-md-6">
                                <label for="dinner" class="form-label">Dinner</label>
                                <input type="text" class="form-select form-select-sm focusable" id="dinner"
                                    wire:model="dinner">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="bedtime" class="form-label">Bedtime</label>
                                <input type="time" class="form-select form-select-sm focusable" id="bedtime"
                                    wire:model="bedtime">
                            </div>
                            <div class="col-md-6">
                                <label for="vyasana" class="form-label">Vyasana</label>
                                <input type="text" class="form-select form-select-sm focusable" id="vyasana"
                                    wire:model="vyasana">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="vyasana_duration" class="form-label">Vyasana Duration</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="vyasana_duration" wire:model="vyasana_duration">
                            </div>
                            <div class="col-md-6">
                                <label for="vyasana_frequency" class="form-label">Vyasana Frequency</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="vyasana_frequency" wire:model="vyasana_frequency">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="eating" role="tabpanel" aria-labelledby="eating-tab">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="eao_agni" class="form-label">Agni</label>
                                <input type="text" class="form-select form-select-sm focusable" id="eao_agni"
                                    wire:model="eao_agni">
                            </div>
                            <div class="col-md-6">
                                <label for="eao_appetite" class="form-label">Appetite</label>
                                <input type="text" class="form-select form-select-sm focusable" id="eao_appetite"
                                    wire:model="eao_appetite">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="eao_food_intake" class="form-label">Food Intake</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="eao_food_intake" wire:model="eao_food_intake">
                            </div>
                            <div class="col-md-6">
                                <label for="eao_food_quantity" class="form-label">Food Quantity</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="eao_food_quantity" wire:model="eao_food_quantity">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="eao_ruchi" class="form-label">Ruchi</label>
                                <input type="text" class="form-select form-select-sm focusable" id="eao_ruchi"
                                    wire:model="eao_ruchi">
                            </div>
                            <div class="col-md-6">
                                <label for="eao_rasa_ichha" class="form-label">Rasa Ichha</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="eao_rasa_ichha" wire:model="eao_rasa_ichha">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="eao_nature" class="form-label">Nature of Food</label>
                                <input type="text" class="form-select form-select-sm focusable" id="eao_nature"
                                    wire:model="eao_nature">
                            </div>
                            <div class="col-md-6">
                                <label for="eao_nature_frequency" class="form-label">Nature Frequency</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="eao_nature_frequency" wire:model="eao_nature_frequency">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="eao_temperature_food_preferred_to_eat" class="form-label">Preferred Food
                                    Temperature</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="eao_temperature_food_preferred_to_eat"
                                    wire:model="eao_temperature_food_preferred_to_eat">
                            </div>
                            <div class="col-md-6">
                                <label for="eao_udara" class="form-label">Udara</label>
                                <input type="text" class="form-select form-select-sm focusable" id="eao_udara"
                                    wire:model="eao_udara">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="eao_udara_if" class="form-label">Udara If</label>
                                <input type="text" class="form-select form-select-sm focusable" id="eao_udara_if"
                                    wire:model="eao_udara_if">
                            </div>
                            <div class="col-md-6">
                                <label for="eao_water_intake_per_day" class="form-label">Water Intake Per Day</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="eao_water_intake_per_day" wire:model="eao_water_intake_per_day">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="eao_water_intake_relation_with_food" class="form-label">Water Intake
                                    Relation with
                                    Food</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="eao_water_intake_relation_with_food"
                                    wire:model="eao_water_intake_relation_with_food">
                            </div>
                            <div class="col-md-6">
                                <label for="eao_allergy_food" class="form-label">Food Allergies</label>
                                <textarea class="form-select form-select-sm" id="eao_allergy_food" wire:model="eao_allergy_food" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="eao_allergy_medicine" class="form-label">Medicine Allergies</label>
                                <textarea class="form-select form-select-sm" id="eao_allergy_medicine" wire:model="eao_allergy_medicine"
                                    rows="4"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="eao_allergy_dust" class="form-label">Dust Allergies</label>
                                <textarea class="form-select form-select-sm" id="eao_allergy_dust" wire:model="eao_allergy_dust" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="eao_allergy_pollen_grains" class="form-label">Pollen Allergies</label>
                                <textarea class="form-select form-select-sm" id="eao_allergy_pollen_grains" wire:model="eao_allergy_pollen_grains"
                                    rows="4"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="eao_allergy_others" class="form-label">Other Allergies</label>
                                <textarea class="form-select form-select-sm" id="eao_allergy_others" wire:model="eao_allergy_others" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="eao_nidraa" class="form-label">Nidraa</label>
                                <input type="text" class="form-select form-select-sm focusable" id="eao_nidraa"
                                    wire:model="eao_nidraa">
                            </div>
                            <div class="col-md-6">
                                <label for="eao_nidra_timings" class="form-label">Nidraa Timings</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="eao_nidra_timings" wire:model="eao_nidra_timings">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="eao_day_sleep" class="form-label">Day Sleep</label>
                                <input type="text" class="form-select form-select-sm focusable" id="eao_day_sleep"
                                    wire:model="eao_day_sleep">
                            </div>
                            <div class="col-md-6">
                                <label for="eao_day_sleep_duration" class="form-label">Day Sleep Duration</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="eao_day_sleep_duration" wire:model="eao_day_sleep_duration">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="eao_gaatra" class="form-label">Gaatra</label>
                                <input type="text" class="form-select form-select-sm focusable" id="eao_gaatra"
                                    wire:model="eao_gaatra">
                            </div>
                            <div class="col-md-6">
                                <label for="eao_gaatra_symptoms" class="form-label">Gaatra Symptoms</label>
                                <textarea class="form-select form-select-sm" id="eao_gaatra_symptoms" wire:model="eao_gaatra_symptoms"
                                    rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    @if ($ehr->patient->gender == 'Female')
                        <div class="tab-pane fade" id="reproductive" role="tabpanel"
                            aria-labelledby="reproductive-tab">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="eao_rajah_pravritti_menarche" class="form-label">Menarche</label>
                                    <input type="text" class="form-select form-select-sm focusable"
                                        id="eao_rajah_pravritti_menarche" wire:model="eao_rajah_pravritti_menarche">
                                </div>
                                <div class="col-md-6">
                                    <label for="eao_rajah_pravritti_lmp" class="form-label">Last Menstrual
                                        Period</label>
                                    <input type="date" class="form-select form-select-sm focusable"
                                        id="eao_rajah_pravritti_lmp" wire:model="eao_rajah_pravritti_lmp">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="eao_rajah_pravritti_cycle" class="form-label">Menstrual Cycle</label>
                                    <input type="text" class="form-select form-select-sm focusable"
                                        id="eao_rajah_pravritti_cycle" wire:model="eao_rajah_pravritti_cycle">
                                </div>
                                <div class="col-md-6">
                                    <label for="eao_rajah_pravritti_cycle_nature" class="form-label">Cycle
                                        Nature</label>
                                    <input type="text" class="form-select form-select-sm focusable"
                                        id="eao_rajah_pravritti_cycle_nature"
                                        wire:model="eao_rajah_pravritti_cycle_nature">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="eao_rajah_pravritti_bleeding_days" class="form-label">Bleeding
                                        Days</label>
                                    <input type="text" class="form-select form-select-sm focusable"
                                        id="eao_rajah_pravritti_bleeding_days"
                                        wire:model="eao_rajah_pravritti_bleeding_days">
                                </div>
                                <div class="col-md-6">
                                    <label for="eao_perimenopause" class="form-label">Perimenopause</label>
                                    <input type="text" class="form-select form-select-sm focusable"
                                        id="eao_perimenopause" wire:model="eao_perimenopause">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="eao_menopause" class="form-label">Menopause</label>
                                    <input type="text" class="form-select form-select-sm focusable"
                                        id="eao_menopause" wire:model="eao_menopause">
                                </div>
                                <div class="col-md-6">
                                    <label for="eao_postmenopause" class="form-label">Postmenopause</label>
                                    <input type="text" class="form-select form-select-sm focusable"
                                        id="eao_postmenopause" wire:model="eao_postmenopause">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="oh_no_deliveries" class="form-label">Number of Deliveries</label>
                                    <input type="number" class="form-select form-select-sm focusable"
                                        id="oh_no_deliveries" wire:model="oh_no_deliveries">
                                </div>
                                <div class="col-md-6">
                                    <label for="oh_no_children" class="form-label">Number of Children</label>
                                    <input type="number" class="form-select form-select-sm focusable"
                                        id="oh_no_children" wire:model="oh_no_children">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="oh_type" class="form-label">Type of Delivery</label>
                                    <input type="text" class="form-select form-select-sm focusable" id="oh_type"
                                        wire:model="oh_type">
                                </div>
                                <div class="col-md-6">
                                    <label for="oh_abortion" class="form-label">Abortion</label>
                                    <input type="text" class="form-select form-select-sm focusable"
                                        id="oh_abortion" wire:model="oh_abortion">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="oh_abortion_no" class="form-label">Number of Abortions</label>
                                    <input type="number" class="form-select form-select-sm focusable"
                                        id="oh_abortion_no" wire:model="oh_abortion_no">
                                </div>
                                <div class="col-md-6">
                                    <label for="oh_misscarriage" class="form-label">Miscarriage</label>
                                    <input type="text" class="form-select form-select-sm focusable"
                                        id="oh_misscarriage" wire:model="oh_misscarriage">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="oh_misscarriage_no" class="form-label">Number of Miscarriages</label>
                                    <input type="number" class="form-select form-select-sm focusable"
                                        id="oh_misscarriage_no" wire:model="oh_misscarriage_no">
                                </div>
                                <div class="col-md-6">
                                    <label for="oh_garbhini_soothika_charyaa" class="form-label">Garbhini Soothika
                                        Charyaa</label>
                                    <input type="text" class="form-select form-select-sm focusable"
                                        id="oh_garbhini_soothika_charyaa" wire:model="oh_garbhini_soothika_charyaa">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="oh_sterilisation" class="form-label">Sterilisation</label>
                                    <input type="text" class="form-select form-select-sm focusable"
                                        id="oh_sterilisation" wire:model="oh_sterilisation">
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="tab-pane fade" id="physical" role="tabpanel" aria-labelledby="physical-tab">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="asp_naadee" class="form-label">Naadee</label>
                                <input type="text" class="form-select form-select-sm focusable" id="asp_naadee"
                                    wire:model="asp_naadee">
                            </div>
                            <div class="col-md-6">
                                <label for="asp_mutra_day" class="form-label">Mutra Day</label>
                                <input type="text" class="form-select form-select-sm focusable" id="asp_mutra_day"
                                    wire:model="asp_mutra_day">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="asp_mutra_night" class="form-label">Mutra Night</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_mutra_night" wire:model="asp_mutra_night">
                            </div>
                            <div class="col-md-6">
                                <label for="asp_mutra_frequency" class="form-label">Mutra Frequency</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_mutra_frequency" wire:model="asp_mutra_frequency">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="asp_mutra_color" class="form-label">Mutra Color</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_mutra_color" wire:model="asp_mutra_color">
                            </div>
                            <div class="col-md-6">
                                <label for="asp_mutra_symptoms" class="form-label">Mutra Symptoms</label>
                                <textarea class="form-select form-select-sm" id="asp_mutra_symptoms" wire:model="asp_mutra_symptoms" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="asp_mutra_others" class="form-label">Other Mutra Observations</label>
                                <textarea class="form-select form-select-sm" id="asp_mutra_others" wire:model="asp_mutra_others" rows="4"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="asp_mala_times" class="form-label">Mala Times</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_mala_times" wire:model="asp_mala_times">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="asp_mala_pravrutti" class="form-label">Mala Pravrutti</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_mala_pravrutti" wire:model="asp_mala_pravrutti">
                            </div>
                            <div class="col-md-6">
                                <label for="asp_mala_type" class="form-label">Mala Type</label>
                                <input type="text" class="form-select form-select-sm focusable" id="asp_mala_type"
                                    wire:model="asp_mala_type">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="asp_mala_digetion" class="form-label">Mala Digestion</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_mala_digetion" wire:model="asp_mala_digetion">
                            </div>
                            <div class="col-md-6">
                                <label for="asp_mala_evacuation" class="form-label">Mala Evacuation</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_mala_evacuation" wire:model="asp_mala_evacuation">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="asp_jihwa_color" class="form-label">Jihwa Color</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_jihwa_color" wire:model="asp_jihwa_color">
                            </div>
                            <div class="col-md-6">
                                <label for="asp_jihwa_coating" class="form-label">Jihwa Coating</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_jihwa_coating" wire:model="asp_jihwa_coating">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="asp_jihwa_others" class="form-label">Other Jihwa Observations</label>
                                <textarea class="form-select form-select-sm" id="asp_jihwa_others" wire:model="asp_jihwa_others" rows="4"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="asp_shabda" class="form-label">Shabda</label>
                                <input type="text" class="form-select form-select-sm focusable" id="asp_shabda"
                                    wire:model="asp_shabda">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="asp_sparsha" class="form-label">Sparsha</label>
                                <input type="text" class="form-select form-select-sm focusable" id="asp_sparsha"
                                    wire:model="asp_sparsha">
                            </div>
                            <div class="col-md-6">
                                <label for="asp_drik_conjunctiva" class="form-label">Drik Conjunctiva</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_drik_conjunctiva" wire:model="asp_drik_conjunctiva">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="asp_drik_sclera" class="form-label">Drik Sclera</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_drik_sclera" wire:model="asp_drik_sclera">
                            </div>
                            <div class="col-md-6">
                                <label for="asp_drik_cornea" class="form-label">Drik Cornea</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_drik_cornea" wire:model="asp_drik_cornea">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="asp_drik_eyelid" class="form-label">Drik Eyelid</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_drik_eyelid" wire:model="asp_drik_eyelid">
                            </div>
                            <div class="col-md-6">
                                <label for="asp_drik_other" class="form-label">Other Drik Observations</label>
                                <textarea class="form-select form-select-sm" id="asp_drik_other" wire:model="asp_drik_other" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="asp_akruthi_built" class="form-label">Akruthi Built</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_akruthi_built" wire:model="asp_akruthi_built">
                            </div>
                            <div class="col-md-6">
                                <label for="asp_akruthi_height" class="form-label">Height</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_akruthi_height" wire:model="asp_akruthi_height">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="asp_akruthi_weight" class="form-label">Weight</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_akruthi_weight" wire:model="asp_akruthi_weight">
                            </div>
                            <div class="col-md-6">
                                <label for="asp_akruthi_bmi" class="form-label">BMI</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="asp_akruthi_bmi" wire:model="asp_akruthi_bmi">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ge_bp" class="form-label">Blood Pressure</label>
                                <input type="text" class="form-select form-select-sm focusable" id="ge_bp"
                                    wire:model="ge_bp">
                            </div>
                            <div class="col-md-6">
                                <label for="ge_pulse" class="form-label">Pulse</label>
                                <input type="text" class="form-select form-select-sm focusable" id="ge_pulse"
                                    wire:model="ge_pulse">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ge_heart_rate" class="form-label">Heart Rate</label>
                                <input type="text" class="form-select form-select-sm focusable" id="ge_heart_rate"
                                    wire:model="ge_heart_rate">
                            </div>
                            <div class="col-md-6">
                                <label for="ge_respiratory_rate" class="form-label">Respiratory Rate</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="ge_respiratory_rate" wire:model="ge_respiratory_rate">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ge_temperature" class="form-label">Temperature</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="ge_temperature" wire:model="ge_temperature">
                            </div>
                            <div class="col-md-6">
                                <label for="ge_icterus" class="form-label">Icterus</label>
                                <input type="text" class="form-select form-select-sm focusable" id="ge_icterus"
                                    wire:model="ge_icterus">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ge_edema" class="form-label">Edema</label>
                                <input type="text" class="form-select form-select-sm focusable" id="ge_edema"
                                    wire:model="ge_edema">
                            </div>
                            <div class="col-md-6">
                                <label for="ge_edema_other" class="form-label">Other Edema Observations</label>
                                <textarea class="form-select form-select-sm" id="ge_edema_other" wire:model="ge_edema_other" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ge_cyanosis" class="form-label">Cyanosis</label>
                                <input type="text" class="form-select form-select-sm focusable" id="ge_cyanosis"
                                    wire:model="ge_cyanosis">
                            </div>
                            <div class="col-md-6">
                                <label for="ge_lymph_node" class="form-label">Lymph Node</label>
                                <input type="text" class="form-select form-select-sm focusable" id="ge_lymph_node"
                                    wire:model="ge_lymph_node">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ge_others" class="form-label">Other General Examination</label>
                                <textarea class="form-select form-select-sm" id="ge_others" wire:model="ge_others" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="diagnosis" role="tabpanel" aria-labelledby="diagnosis-tab">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="dvp_desha" class="form-label">Desha</label>
                                <input type="text" class="form-select form-select-sm focusable" id="dvp_desha"
                                    wire:model="dvp_desha">
                            </div>
                            <div class="col-md-6">
                                <label for="dvp_dooshya" class="form-label">Dooshya</label>
                                <input type="text" class="form-select form-select-sm focusable" id="dvp_dooshya"
                                    wire:model="dvp_dooshya">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="dvp_bala_roga" class="form-label">Bala Roga</label>
                                <input type="text" class="form-select form-select-sm focusable" id="dvp_bala_roga"
                                    wire:model="dvp_bala_roga">
                            </div>
                            <div class="col-md-6">
                                <label for="dvp_bala_rogi" class="form-label">Bala Rogi</label>
                                <input type="text" class="form-select form-select-sm focusable" id="dvp_bala_rogi"
                                    wire:model="dvp_bala_rogi">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="dvp_kaala" class="form-label">Kaala</label>
                                <input type="text" class="form-select form-select-sm focusable" id="dvp_kaala"
                                    wire:model="dvp_kaala">
                            </div>
                            <div class="col-md-6">
                                <label for="dvp_anala" class="form-label">Anala</label>
                                <input type="text" class="form-select form-select-sm focusable" id="dvp_anala"
                                    wire:model="dvp_anala">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="dvp_prakruti" class="form-label">Prakruti</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="dvp_prakruti" wire:model="dvp_prakruti">
                            </div>
                            <div class="col-md-6">
                                <label for="dvp_vaya" class="form-label">Vaya</label>
                                <input type="text" class="form-select form-select-sm focusable" id="dvp_vaya"
                                    wire:model="dvp_vaya">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="dvp_satva" class="form-label">Satva</label>
                                <input type="text" class="form-select form-select-sm focusable" id="dvp_satva"
                                    wire:model="dvp_satva">
                            </div>
                            <div class="col-md-6">
                                <label for="dvp_satva_stress" class="form-label">Satva Stress</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="dvp_satva_stress" wire:model="dvp_satva_stress">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="dvp_saatmya" class="form-label">Saatmya</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="dvp_saatmya" wire:model="dvp_saatmya">
                            </div>
                            <div class="col-md-6">
                                <label for="dvp_vihaara_vyayama" class="form-label">Vihaara Vyayama</label>
                                <input type="text" class="form-select form-select-sm focusable"
                                    id="dvp_vihaara_vyayama" wire:model="dvp_vihaara_vyayama">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="dvp_others" class="form-label">Other Observations</label>
                                <textarea class="form-select form-select-sm" id="dvp_others" wire:model="dvp_others" rows="4"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="probable_diagnosis" class="form-label">Probable Diagnosis</label>
                                <textarea class="form-select form-select-sm" id="probable_diagnosis" wire:model="probable_diagnosis"
                                    rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tp_treatment_plan" class="form-label">Treatment Plan</label>
                                <textarea class="form-select form-select-sm" id="tp_treatment_plan" wire:model="tp_treatment_plan"
                                    rows="4"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="tp_treatment_plan_guidelines" class="form-label">Treatment Plan
                                    Guidelines</label>
                                <textarea class="form-select form-select-sm" id="tp_treatment_plan_guidelines"
                                    wire:model="tp_treatment_plan_guidelines" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="lab_reports" class="form-label">Lab Reports</label>
                                <textarea class="form-select form-select-sm" id="lab_reports" wire:model="lab_reports" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 mb-3">Submit</button>
                </form>
                <hr>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body mb-3">
                        <h6>{{ $ehr->patient->name }}</h6>
                    </div>
                    @if ($errors->any())
                        <div class="card-body mb-3">
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div class="card-body mb-3">
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
