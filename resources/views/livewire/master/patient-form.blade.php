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
                        <input type="text" wire:model="address" class="form-select form-select-sm focusable" />
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
        // States data for autocomplete
        const statesData = @json(
            $states->map(function ($state) {
                return ['id' => $state->id, 'name' => $state->name];
            }));

        function initializeDatepicker() {
            $(".date").each(function() {
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
                        // Update the Livewire property directly
                        $input.val(dateText);
                        $input.trigger('input');

                        // Dispatch Livewire event to update the component
                        Livewire.find($input.closest('[wire\\:id]').attr('wire:id')).set(
                            'date_of_birth', dateText);
                    },
                    onClose: function(dateText) {
                        $input.val(dateText);
                        $input.trigger('input');

                        // Dispatch Livewire event to update the component
                        if (dateText) {
                            Livewire.find($input.closest('[wire\\:id]').attr('wire:id')).set(
                                'date_of_birth', dateText);
                        }
                    }
                });
            });
        }

        function initializeStateAutocomplete() {
            const $autocomplete = $("#state_autocomplete");
            const $hidden = $("#state_id_hidden");

            if ($autocomplete.hasClass('ui-autocomplete-input')) {
                return;
            }

            let selectedItem = null;

            $autocomplete.autocomplete({
                source: statesData.map(state => ({
                    label: state.name,
                    value: state.name,
                    id: state.id
                })),
                minLength: 1,
                focus: function(event, ui) {
                    // Prevent the input from being updated on focus
                    return false;
                },
                select: function(event, ui) {
                    selectedItem = ui.item;
                    $autocomplete.val(ui.item.value);
                    $hidden.val(ui.item.id);
                    // Update Livewire component
                    Livewire.find($hidden.closest('[wire\\:id]').attr('wire:id')).set('state_id', ui.item.id);
                    return false; // Prevent default behavior
                },
                change: function(event, ui) {
                    // Check if a valid item was selected
                    if (!selectedItem) {
                        // Check if the current value matches any state
                        const currentValue = $autocomplete.val();
                        const matchedState = statesData.find(state =>
                            state.name.toLowerCase() === currentValue.toLowerCase()
                        );

                        if (matchedState) {
                            // Valid match found
                            $hidden.val(matchedState.id);
                            $autocomplete.val(matchedState.name);
                            Livewire.find($hidden.closest('[wire\\:id]').attr('wire:id')).set('state_id',
                                matchedState.id);
                        } else {
                            // No valid match, clear everything
                            $hidden.val('');
                            $autocomplete.val('');
                            Livewire.find($hidden.closest('[wire\\:id]').attr('wire:id')).set('state_id', '');
                        }
                    }
                    selectedItem = null; // Reset for next interaction
                }
            });

            // Handle keyboard events specifically
            $autocomplete.on('keydown', function(event) {
                if (event.keyCode === 13) { // Enter key
                    event.preventDefault();
                    const menu = $autocomplete.autocomplete('widget');
                    const active = menu.find('.ui-state-active');
                    if (active.length) {
                        active.click();
                    }
                }
            });

            // Set initial value if editing
            const currentStateId = $hidden.val();
            if (currentStateId) {
                const currentState = statesData.find(state => state.id == currentStateId);
                if (currentState) {
                    $autocomplete.val(currentState.name);
                    selectedItem = {
                        label: currentState.name,
                        value: currentState.name,
                        id: currentState.id
                    };
                }
            }
        }

        $(function() {
            initializeDatepicker();
            initializeStateAutocomplete();
        });

        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('element.updated', (el, component) => {
                initializeDatepicker();
                initializeStateAutocomplete();
            });
        });
    </script>
@endpush
