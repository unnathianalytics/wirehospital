<div class="container mt-4">
    <h2 class="mb-4 h3">
        {{ $patient ? "Edit {$patient->name}" : 'Create Patient' }}
    </h2>
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
                        <select wire:model="state_id" class="form-select form-select-sm focusable">
                            <option value="">-- Select State --</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">({{ $state->code }}) {{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- first column end -->
                </div>
                <button {{ $is_editable ? '' : 'disabled' }} type="submit" class="btn btn-primary focusable">
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
