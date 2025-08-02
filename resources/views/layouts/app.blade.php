<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        @if (Auth::check())
            {{ auth()->user()->company->name }}
        @else
            Login
        @endif - Wire Accounting
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Billing software for small businesses">
    @livewireStyles
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
    <link rel="stylesheet" href="https://yevgenysim-turkey.github.io/dashbrd/assets/css/libs.bundle.css" />
    <!-- Theme CSS -->
    <link rel="stylesheet" href="https://yevgenysim-turkey.github.io/dashbrd/assets/css/theme.bundle.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}?v={{ date('YmdHis') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}?v={{ date('YmdHis') }}">
    <script>
        (() => {
            'use strict';

            const getStoredTheme = () => localStorage.getItem('theme');
            const setStoredTheme = (theme) => localStorage.setItem('theme', theme);
            const getPreferredTheme = () => {
                const storedTheme = getStoredTheme();
                if (storedTheme) return storedTheme;
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            };

            const setTheme = (theme) => {
                const value = theme === 'auto' ?
                    (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') :
                    theme;
                document.documentElement.setAttribute('data-bs-theme', value);
            };

            const showActiveTheme = (theme, settingsSwitcher) => {
                document.querySelectorAll('[data-bs-theme-value]').forEach((element) => {
                    element.classList.remove('active');
                    element.setAttribute('aria-pressed', 'false');
                    if (element.getAttribute('data-bs-theme-value') === theme) {
                        element.classList.add('active');
                        element.setAttribute('aria-pressed', 'true');
                    }
                });
                if (settingsSwitcher) settingsSwitcher.focus();
            };

            // Expose to global so Livewire can call later
            window.setTheme = setTheme;
            window.showActiveTheme = showActiveTheme;
            window.getPreferredTheme = getPreferredTheme;

            setTheme(getPreferredTheme());

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                const storedTheme = getStoredTheme();
                if (storedTheme !== 'light' && storedTheme !== 'dark') {
                    setTheme(getPreferredTheme());
                }
            });

            window.addEventListener('DOMContentLoaded', () => {
                showActiveTheme(getPreferredTheme());
                document.querySelectorAll('[data-bs-theme-value]').forEach((toggle) => {
                    toggle.addEventListener('click', (e) => {
                        e.preventDefault();
                        const theme = toggle.getAttribute('data-bs-theme-value');
                        const settingsSwitcher = toggle.closest('.nav-item')?.querySelector(
                            '[data-bs-settings-switcher]');
                        setStoredTheme(theme);
                        setTheme(theme);
                        showActiveTheme(theme, settingsSwitcher);
                        if (typeof refreshCharts === 'function') refreshCharts();
                    });
                });
            });
        })();
    </script>

    @stack('body-styles')
</head>

<body>
    @if (Auth::check())
        @include('layouts.navbar')
    @endif
    <div class="container-fluid mt-3">
        @yield('content')
    </div>
    @if (Auth::check())
        @include('layouts.footer')
    @endif

    <script data-navigate-once="true" src="https://yevgenysim-turkey.github.io/dashbrd/assets/js/vendor.bundle.js"></script>

    <!-- Theme JS -->
    <script data-navigate-once="true" src="https://yevgenysim-turkey.github.io/dashbrd/assets/js/theme.bundle.js"></script>
    </script>
    <script data-navigate-once="true" src="{{ asset('assets/js/jquery.js') }}?v={{ date('YmdHis') }}"></script>
    <script data-navigate-once="true" src="{{ asset('assets/js/jquery-ui.min.js') }}?v={{ date('YmdHis') }}"></script>
    <script data-navigate-once="true" src="{{ asset('/assets/js/app.js') }}?v={{ date('YmdHis') }}"></script>
    <script>
        window.financialYearDates = @json(getUserFinancialYearDates() ?? ['start_date' => null, 'end_date' => null]);
    </script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
