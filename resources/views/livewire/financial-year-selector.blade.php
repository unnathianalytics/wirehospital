<div class="d-flex align-items-between">
    <select id="financial_year" class="form-select mb-3" onchange="handleFinancialYearChange(event, this)">
        @foreach ($financialYears as $fy)
            <option value="{{ $fy->id }}" {{ $selectedFinancialYear == $fy->id ? 'selected' : '' }}>
                {{ $fy->name }}
            </option>
        @endforeach
    </select>
</div>

@push('scripts')
    <script>
        function handleFinancialYearChange(event, selectElement) {
            const newValue = event.target.value;
            const financialYearName = selectElement.options[selectElement.selectedIndex].text;
            const currentValue = @json($selectedFinancialYear);
            if (newValue && newValue !== currentValue) {
                if (confirm(`Changing the financial year to ${financialYearName} will log you out. Continue?`)) {
                    @this.call('updateAndLogout', newValue);
                } else {
                    selectElement.value = currentValue || '';
                }
            }
        }
    </script>
@endpush
