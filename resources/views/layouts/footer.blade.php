<footer class="bg-footer fixed-bottom">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <span>Wire Invoice and Accounting</span>
            <span>State: Karnataka</span>
            <span>Current {{ auth()->user()->financialYear->name }}</span>
            <span>{{ date('d-M-Y') }} (Active)</span>
            <span>Laravel {{ App::version() }} / Livewire
                {{ \Composer\InstalledVersions::getVersion('livewire/livewire') }}</span>

        </div>
    </div>
</footer>
