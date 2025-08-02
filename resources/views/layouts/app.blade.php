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
    <script>
        /*!
         * Color mode toggler for Bootstrap's docs (https://getbootstrap.com/)
         * Copyright 2011-2024 The Bootstrap Authors
         * Licensed under the Creative Commons Attribution 3.0 Unported License.
         * Modified by Simpleqode
         */

        (() => {
            'use strict';

            const getStoredTheme = () => localStorage.getItem('theme');
            const setStoredTheme = (theme) => localStorage.setItem('theme', theme);

            const getStoredNavigationPosition = () => localStorage.getItem('navigationPosition');
            const setStoredNavigationPosition = (navigationPosition) => localStorage.setItem('navigationPosition',
                navigationPosition);

            const getStoredSidenavSizing = () => localStorage.getItem('sidenavSizing');
            const setStoredSidenavSizing = (sidenavSizing) => localStorage.setItem('sidenavSizing', sidenavSizing);

            const getPreferredTheme = () => {
                const storedTheme = getStoredTheme();
                if (storedTheme) {
                    return storedTheme;
                }
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            };

            const getPreferredNavigationPosition = () => {
                const storedNavigationPosition = getStoredNavigationPosition();
                if (storedNavigationPosition) {
                    return storedNavigationPosition;
                }
                return 'sidenav';
            };

            const getPreferredSidenavSizing = () => {
                const storedSidenavSizing = getStoredSidenavSizing();
                if (storedSidenavSizing) {
                    return storedSidenavSizing;
                }
                return 'base';
            };

            const setTheme = (theme) => {
                if (theme === 'auto') {
                    document.documentElement.setAttribute('data-bs-theme', window.matchMedia(
                        '(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                } else {
                    document.documentElement.setAttribute('data-bs-theme', theme);
                }
            };

            const setNavigationPosition = (navigationPosition) => {
                document.documentElement.setAttribute('data-bs-navigation-position', navigationPosition);
            };

            const setSidenavSizing = (sidenavSizing) => {
                document.documentElement.setAttribute('data-bs-sidenav-sizing', sidenavSizing);
            };

            setTheme(getPreferredTheme());
            setNavigationPosition(getPreferredNavigationPosition());
            setSidenavSizing(getPreferredSidenavSizing());

            const showActiveTheme = (theme, settingsSwitcher) => {
                document.querySelectorAll('[data-bs-theme-value]').forEach((element) => {
                    element.classList.remove('active');
                    element.setAttribute('aria-pressed', 'false');

                    if (element.getAttribute('data-bs-theme-value') === theme) {
                        element.classList.add('active');
                        element.setAttribute('aria-pressed', 'true');
                    }
                });

                if (settingsSwitcher) {
                    settingsSwitcher.focus();
                }
            };

            const showActiveNavigationPosition = (navigationPosition, settingsSwitcher) => {
                document.querySelectorAll('[data-bs-navigation-position-value]').forEach((element) => {
                    element.classList.remove('active');
                    element.setAttribute('aria-pressed', 'false');

                    if (element.getAttribute('data-bs-navigation-position-value') === navigationPosition) {
                        element.classList.add('active');
                        element.setAttribute('aria-pressed', 'true');
                    }
                });

                if (settingsSwitcher) {
                    settingsSwitcher.focus();
                }
            };

            const showActiveSidenavSizing = (sidenavSizing, settingsSwitcher) => {
                document.querySelectorAll('[data-bs-sidenav-sizing-value]').forEach((element) => {
                    element.classList.remove('active');
                    element.setAttribute('aria-pressed', 'false');

                    if (element.getAttribute('data-bs-sidenav-sizing-value') === sidenavSizing) {
                        element.classList.add('active');
                        element.setAttribute('aria-pressed', 'true');
                    }
                });

                if (settingsSwitcher) {
                    settingsSwitcher.focus();
                }
            };

            const refreshCharts = () => {
                const charts = document.querySelectorAll('.chart-canvas');

                charts.forEach((chart) => {
                    const chartId = chart.getAttribute('id');
                    const instance = Chart.getChart(chartId);

                    if (!instance) {
                        return;
                    }

                    if (instance.options.scales.y) {
                        instance.options.scales.y.grid.color = getComputedStyle(document.documentElement)
                            .getPropertyValue('--bs-border-color');
                        instance.options.scales.y.ticks.color = getComputedStyle(document.documentElement)
                            .getPropertyValue('--bs-secondary-color');
                    }

                    if (instance.options.scales.x) {
                        instance.options.scales.x.ticks.color = getComputedStyle(document.documentElement)
                            .getPropertyValue('--bs-secondary-color');
                    }

                    if (instance.options.elements.arc) {
                        instance.options.elements.arc.borderColor = getComputedStyle(document
                            .documentElement).getPropertyValue('--bs-body-bg');
                        instance.options.elements.arc.hoverBorderColor = getComputedStyle(document
                            .documentElement).getPropertyValue('--bs-body-bg');
                    }

                    instance.update();
                });
            };

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                const storedTheme = getStoredTheme();
                if (storedTheme !== 'light' && storedTheme !== 'dark') {
                    setTheme(getPreferredTheme());
                }
            });

            window.addEventListener('DOMContentLoaded', () => {
                showActiveTheme(getPreferredTheme());
                showActiveNavigationPosition(getPreferredNavigationPosition());
                showActiveSidenavSizing(getPreferredSidenavSizing());

                document.querySelectorAll('[data-bs-theme-value]').forEach((toggle) => {
                    toggle.addEventListener('click', (e) => {
                        e.preventDefault();
                        const theme = toggle.getAttribute('data-bs-theme-value');
                        const settingsSwitcher = toggle.closest('.nav-item').querySelector(
                            '[data-bs-settings-switcher]');
                        setStoredTheme(theme);
                        setTheme(theme);
                        showActiveTheme(theme, settingsSwitcher);
                        refreshCharts();
                    });
                });

                document.querySelectorAll('[data-bs-navigation-position-value]').forEach((toggle) => {
                    toggle.addEventListener('click', (e) => {
                        e.preventDefault();
                        const navigationPosition = toggle.getAttribute(
                            'data-bs-navigation-position-value');
                        const settingsSwitcher = toggle.closest('.nav-item').querySelector(
                            '[data-bs-settings-switcher]');
                        setStoredNavigationPosition(navigationPosition);
                        setNavigationPosition(navigationPosition);
                        showActiveNavigationPosition(navigationPosition, settingsSwitcher);
                    });
                });

                document.querySelectorAll('[data-bs-sidenav-sizing-value]').forEach((toggle) => {
                    toggle.addEventListener('click', (e) => {
                        e.preventDefault();
                        const sidenavSizing = toggle.getAttribute(
                            'data-bs-sidenav-sizing-value');
                        const settingsSwitcher = toggle.closest('.nav-item').querySelector(
                            '[data-bs-settings-switcher]');
                        setStoredSidenavSizing(sidenavSizing);
                        setSidenavSizing(sidenavSizing);
                        showActiveSidenavSizing(sidenavSizing, settingsSwitcher);
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

    <script src="https://yevgenysim-turkey.github.io/dashbrd/assets/js/vendor.bundle.js"></script>

    <!-- Theme JS -->
    <script src="https://yevgenysim-turkey.github.io/dashbrd/assets/js/theme.bundle.js"></script>
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
