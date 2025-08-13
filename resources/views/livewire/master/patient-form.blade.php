<div class="container mt-4">
    <div class="d-flex justify-content-between">
        <h2 class="mb-4 h3">
            {{ $patient ? "Edit {$patient->name}" : 'Create Patient' }}
        </h2><small><a class="btn btn-sm btn-primary" href="{{ route('patient_index') }}">List Patients</a>
        </small>
    </div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <form wire:submit="save">
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-5 mb-3">
                        <label class="form-label">Op Number</label>
                        <input type="text" wire:model="op_number" readonly
                            class="form-select form-select-sm focusable" />
                    </div>
                    <div class="col-lg-7 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" wire:model.live="name" class="form-select form-select-sm focusable" />
                    </div>
                    <div class="col-lg-12 mb-3">
                        <label class="form-label">Address</label>
                        <textarea type="text" wire:model="address" rows="4" class="form-control form-control-sm focusable"></textarea>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label class="form-label">Mobile</label>
                        <input type="text" wire:model="mobile" class="form-select form-select-sm focusable" />
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label class="form-label">EMail</label>
                        <input type="email" wire:model="email" class="form-select form-select-sm focusable" />
                    </div>
                    <div class="col-lg-3 mb-3" wire:ignore>
                        <label class="form-label">State</label>
                        <input type="text" id="state_autocomplete" class="form-select form-select-sm focusable"
                            placeholder="Type to search states..." />
                        <input type="hidden" wire:model="state_id" id="state_id_hidden" />
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="card card-body p-2">
                            <div class="row">
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label">Gender</label>
                                    <select wire:model="gender" class="form-select form-select-sm focusable">
                                        <option value="">-- Select --</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 mb-3" wire:ignore>
                                    <label class="form-label">DoB</label>
                                    <input type="text" wire:model="date_of_birth"
                                        class="form-select form-select-sm focusable date" />
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label">Occupation</label>
                                    <input type="text" wire:model="occupation"
                                        class="form-select form-select-sm focusable" />
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label">Referred By</label>
                                    <input type="text" wire:model="referred_by"
                                        class="form-select form-select-sm focusable" />
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label">Address Proof</label>
                                    <input type="text" wire:model="address_proof_id"
                                        class="form-select form-select-sm focusable" />
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label">Address Proof No.</label>
                                    <input type="text" wire:model="address_proof_number"
                                        class="form-select form-select-sm focusable" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- first column end -->
                </div>
                <button type="submit" class="btn btn-primary btn-sm focusable">
                    {{ $patient ? 'Update' : 'Create' }}
                </button>
                @if ($patient)
                    <a class="btn btn-sm btn-danger" href="{{ route('ehr_edit', ['patient' => $patient->id]) }}">Health
                        Record</a>
                @endif
            </div>


            <div class="col-lg-3">
                <div class="row">
                    <div class="col-12 mb-3">
                        <!-- third column start -->
                        @if ($errors->any())
                            <div class="alert alert-danger mt-5">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- third column end -->
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@push('scripts')
    <script>
        const statesData = @json($states->map(fn($state) => ['id' => $state->id, 'name' => $state->name]));
        const stateOptions = statesData.map(state => ({
            label: state.name,
            value: state.name,
            id: state.id
        }));

        function initializeDatepicker(root = document.body) {
            $(".date", root).each(function() {
                const $input = $(this);
                if ($input.hasClass('hasDatepicker')) {
                    return;
                }
                let minDate = '-100Y',
                    maxDate = '+0D';
                $input.datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    minDate: minDate,
                    maxDate: maxDate,
                    onSelect: function(dateText) {
                        updateLivewireDate($input, dateText);
                    },
                    onClose: function(dateText) {
                        updateLivewireDate($input, dateText);
                    }
                });
            });
        }

        function updateLivewireDate($input, dateText) {
            $input.val(dateText).trigger('input');
            if (dateText) {
                const componentId = $input.closest('[wire\\:id]').attr('wire:id');
                if (componentId) {
                    Livewire.find(componentId).set('date_of_birth', dateText);
                }
            }
        }

        function initializeStateAutocomplete(root = document.body) {
            const $autocomplete = $("#state_autocomplete", root);
            if (!$autocomplete.length || $autocomplete.hasClass('ui-autocomplete-input')) {
                return;
            }
            const $hidden = $("#state_id_hidden", root);
            let selectedItem = null;
            $autocomplete.autocomplete({
                source: function(request, response) {
                    const term = request.term.toLowerCase();
                    const matches = stateOptions
                        .filter(option => option.label.toLowerCase().includes(term))
                        .slice(0, 10);
                    response(matches);
                },
                minLength: 1,
                focus: function(event, ui) {
                    return false;
                },
                select: function(event, ui) {
                    selectedItem = ui.item;
                    $autocomplete.val(ui.item.value);
                    $hidden.val(ui.item.id);
                    updateLivewireState($hidden, ui.item.id);
                    return false;
                },
                change: function(event, ui) {
                    if (!selectedItem) {
                        const currentValue = $autocomplete.val();
                        const matchedState = stateOptions.find(option =>
                            option.label.toLowerCase() === currentValue.toLowerCase()
                        );
                        if (matchedState) {
                            $autocomplete.val(matchedState.value);
                            $hidden.val(matchedState.id);
                            updateLivewireState($hidden, matchedState.id);
                        } else {
                            $autocomplete.val('');
                            $hidden.val('');
                            updateLivewireState($hidden, '');
                        }
                    }
                    selectedItem = null;
                },
                open: function(event, ui) {
                    $(this).autocomplete("widget").css({
                        "max-height": "200px",
                        "overflow-y": "auto",
                        "overflow-x": "hidden"
                    });
                }
            });
            const currentStateId = $hidden.val();
            if (currentStateId) {
                const currentState = stateOptions.find(option => option.id == currentStateId);
                if (currentState) {
                    $autocomplete.val(currentState.value);
                    selectedItem = currentState;
                }
            }
        }

        function updateLivewireState($hidden, stateId) {
            const componentId = $hidden.closest('[wire\\:id]').attr('wire:id');
            if (componentId) {
                Livewire.find(componentId).set('state_id', stateId);
            }
        }

        $(function() {
            initializeDatepicker();
            initializeStateAutocomplete();
        });

        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('element.updated', (el, component) => {
                initializeDatepicker(el);
                initializeStateAutocomplete(el);
            });
        });
    </script>
@endpush
