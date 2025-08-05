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
                    <div class="col-lg-3 mb-3">
                        <label class="form-label">State</label>
                        <select wire:model="state_id" class="form-select form-select-sm">
                            <option value="">-- Select State --</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
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

        $(function() {
            initializeDatepicker();
        });

        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('element.updated', (el, component) => {
                initializeDatepicker();
            });
        });
    </script>
@endpush
