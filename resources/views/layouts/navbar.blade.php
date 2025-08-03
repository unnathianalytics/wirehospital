<nav class="navbar navbar-expand-lg">
    <div class="container-lg">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center fs-5 fw-bold" href="#"><svg
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                class="fs-4 text-secondary me-2 duo-icon duo-icon-box-2" data-duoicon="box-2">
                <path fill="currentColor"
                    d="m20.765 7.982.022.19.007.194v7.268a2.5 2.5 0 0 1-1.099 2.07l-.15.095-6.295 3.634-.124.067-.126.06v-8.99l7.765-4.588Z"
                    class="duoicon-secondary-layer" opacity=".3"></path>
                <path fill="currentColor"
                    d="m13.25 2.567 6.294 3.634c.05.03.1.06.148.092L12 10.838 4.308 6.293a2.81 2.81 0 0 1 .148-.092l6.294-3.634a2.498 2.498 0 0 1 2.5 0Z"
                    class="duoicon-primary-layer"></path>
                <path fill="currentColor"
                    d="M3.235 7.982 11 12.571v8.988a2.339 2.339 0 0 1-.25-.126l-6.294-3.634a2.502 2.502 0 0 1-1.25-2.165V8.366c0-.13.01-.258.03-.384h-.001Z"
                    class="duoicon-secondary-layer" opacity=".3"></path>
            </svg>{{ \Auth::user()->company->name }}</a>

        <!-- User -->
        <div class="d-flex ms-auto d-xl-none">
            <div class="dropdown my-n2">
                <a class="btn btn-link d-inline-flex align-items-center dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="avatar avatar-sm avatar-status avatar-status-success me-3">
                        <img class="avatar-img" src="./assets/img/photos/photo-6.jpg" alt="...">
                    </span>
                    <span class="d-none d-xl-block">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="./account/account.html">Account</a></li>
                    <li><a class="dropdown-item" href="./auth/password-reset.html" target="_blank">Change password</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                </ul>
            </div>

            <!-- Divider -->
            <div class="vr align-self-center bg-dark mx-2"></div>

            <!-- Notifications -->
            <div class="dropdown ">
                <button class="btn btn-link" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                    aria-expanded="false">
                    <span class="material-symbols-outlined scale-125">notifications</span>
                    <span class="position-absolute top-0 end-0 m-3 p-1 bg-warning rounded-circle">
                        <span class="visually-hidden">New notifications</span>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-end" style="width: 350px">
                    <!-- Header -->
                    <div class="row">
                        <div class="col">
                            <h6 class="dropdown-header me-auto">Notifications</h6>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-sm btn-link" type="button"><span
                                    class="material-symbols-outlined me-1">done_all</span> Mark all as read</button>
                            <button class="btn btn-sm btn-link" type="button"><span
                                    class="material-symbols-outlined">settings</span></button>
                        </div>
                    </div>

                    <!-- Items -->
                    <div class="list-group list-group-flush px-4">
                        <div class="list-group-item border-style-dashed px-0">
                            <div class="row gx-3">
                                <div class="col-auto">
                                    <div class="avatar avatar-sm">
                                        <img class="avatar-img" src="./assets/img/photos/photo-1.jpg" alt="...">
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="text-body mb-2">
                                        <span class="fw-semibold">Emily T.</span> commented on your post <br><small
                                            class="text-body-secondary">5 minutes ago</small>
                                    </p>
                                    <div class="card">
                                        <div class="card-body p-3">Love the new dashboard layout! Super clean and easy
                                            to navigate 🔥</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-style-dashed px-0">
                            <div class="row gx-3">
                                <div class="col-auto">
                                    <div class="avatar avatar-sm">
                                        <img class="avatar-img" src="./assets/img/photos/photo-2.jpg" alt="...">
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="text-body mb-2">
                                        <span class="fw-semibold">Michael J.</span> requested changes on your post <br>
                                        <small class="text-body-secondary">10 minutes ago</small>
                                    </p>
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <p class="mb-2">Could you update the revenue chart with the latest data?
                                                Thanks!</p>
                                            <p class="mb-0">
                                                <button class="btn btn-sm btn-light" type="button">Update now</button>
                                                <button class="btn btn-sm btn-link">Dismiss</button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-style-dashed px-0">
                            <div class="row gx-3 align-items-center">
                                <div class="col-auto">
                                    <div class="avatar">
                                        <span class="material-symbols-outlined">error</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="text-body mb-0">
                                        <span class="fw-semibold">System alert</span> - Build failed <br>
                                        <small class="text-body-secondary">1 hour ago</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toggler -->
        <button class="navbar-toggler ms-3" type="button" data-bs-toggle="collapse"
            data-bs-target="#topnavBaseCollapse" aria-controls="topnavBaseCollapse" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="topnavBaseCollapse">
            <!-- Search -->
            <div class="input-group d-xl-none my-4 my-xl-0">
                <input class="form-control" id="topnavSearchInputMobile" type="search" placeholder="Search"
                    aria-label="Search" aria-describedby="navbarSearchMobile">
                <span class="input-group-text" id="navbarSearchMobile">
                    <span class="material-symbols-outlined">search</span>
                </span>
            </div>

            <!-- Nav -->
            <nav class="navbar-nav nav-pills mx-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Dashboards
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item active" href="./index.html">Default</a>
                        <a class="dropdown-item " href="./dashboards/crypto.html">Crypto</a>
                        <a class="dropdown-item " href="./dashboards/saas.html">SaaS</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-expanded="false">
                        Masters
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropend">
                            <a class="dropdown-item d-flex" href="#" role="button" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" aria-expanded="false">Patint<span
                                    class="material-symbols-outlined ms-auto">chevron_right</span></a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item " wire:navigate href="{{ route('patient_create') }}">Add
                                    Patinet</a>
                                <a class="dropdown-item " wire:navigate href="{{ route('patient_index') }}">List
                                    Patients</a>
                            </div>
                        </li>
                        <li class="dropend">
                            <a class="dropdown-item d-flex" href="#" role="button" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" aria-expanded="false">Account<span
                                    class="material-symbols-outlined ms-auto">chevron_right</span></a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item " wire:navigate href="{{ route('account_create') }}">Add
                                    Account</a>
                                <a class="dropdown-item " wire:navigate href="{{ route('account_index') }}">List
                                    Accounts</a>
                            </div>
                        </li>
                        <li class="dropend">
                            <a class="dropdown-item d-flex" href="#" role="button" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" aria-expanded="false">Item<span
                                    class="material-symbols-outlined ms-auto">chevron_right</span></a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item " wire:navigate href="{{ route('item_create') }}">Add
                                    Item</a>
                                <a class="dropdown-item " wire:navigate href="{{ route('item_index') }}">List
                                    Items</a>
                            </div>
                        </li>
                        <li class="dropend">
                            <a class="dropdown-item d-flex" href="#" role="button" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" aria-expanded="false">
                                Customers <span class="material-symbols-outlined ms-auto">chevron_right</span>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item " href="./customers/customers.html">Customers</a>
                                <a class="dropdown-item " href="./customers/customer.html">Customer details</a>
                                <a class="dropdown-item " href="./customers/customer-new.html">New customer</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-expanded="false">
                        Transactions
                    </a>
                    <ul class="dropdown-menu">
                        @foreach (\App\Models\InvoiceType::orderBy('menu_order')->get() as $iType)
                            <li class="dropend">
                                <a class="dropdown-item d-flex" href="#" role="button"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                    aria-expanded="false">{{ $iType->name }} <span
                                        class="material-symbols-outlined ms-auto">chevron_right</span></a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item " wire:navigate
                                        href="{{ route('invoice_create', ['invoiceType' => $iType->slug]) }}">Add
                                        {{ $iType->name }}</a></a>
                                    <a class="dropdown-item " wire:navigate
                                        href="{{ route('invoice_index', ['invoiceType' => $iType->slug]) }}">List
                                        {{ $iType->name }}</a>
                                </div>
                            </li>
                        @endforeach
                        <li class="dropend">
                            <a class="dropdown-item d-flex" href="#" role="button" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" aria-expanded="false">
                                Customers <span class="material-symbols-outlined ms-auto">chevron_right</span>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item " href="./customers/customers.html">Customers</a>
                                <a class="dropdown-item " href="./customers/customer.html">Customer details</a>
                                <a class="dropdown-item " href="./customers/customer-new.html">New customer</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Emails</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="./emails/account-confirmation.html" target="_blank">Account
                            confirmation</a>
                        <a class="dropdown-item" href="./emails/new-post.html" target="_blank">New post</a>
                        <a class="dropdown-item" href="./emails/order-confirmation.html" target="_blank">Order
                            confirmation</a>
                        <a class="dropdown-item" href="./emails/password-reset.html" target="_blank">Password
                            reset</a>
                        <a class="dropdown-item" href="./emails/product-update.html" target="_blank">Product
                            update</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Modals</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#productModal" data-bs-toggle="offcanvas"
                            aria-controls="productModal">Product</a>
                        <a class="dropdown-item" href="#orderModal" data-bs-toggle="offcanvas"
                            aria-controls="orderModal">Order</a>
                        <a class="dropdown-item" href="#eventModal" data-bs-toggle="modal"
                            aria-controls="eventModal">Event</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Documentation
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item " href="./docs/getting-started.html">Getting started</a>
                        <a class="dropdown-item " href="./docs/components.html">Components</a>
                        <a class="dropdown-item d-flex " href="./docs/changelog.html">Changelog <span
                                class="badge text-bg-primary ms-auto">1.0.6</span></a>
                    </div>
                </div>
            </nav>

            <!-- Divider -->
            <hr class="my-4 d-xl-none">

            <!-- Nav -->
            <nav class="navbar-nav nav-pills">
                <div class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown"
                        data-bs-settings-switcher="" aria-expanded="false">
                        <span class="material-symbols-outlined">settings</span><span
                            class="d-xl-none ms-3">Settings</span>
                    </a>
                    <div class="dropdown-menu">
                        <!-- Color mode -->
                        <h6 class="dropdown-header">Color mode</h6>
                        <a class="dropdown-item d-flex active" data-bs-theme-value="light" href="#"
                            role="button" aria-pressed="true"> <span
                                class="material-symbols-outlined me-2">light_mode</span> Light </a>
                        <a class="dropdown-item d-flex" data-bs-theme-value="dark" href="#" role="button"
                            aria-pressed="false"> <span class="material-symbols-outlined me-2">dark_mode</span> Dark
                        </a>
                        <a class="dropdown-item d-flex" data-bs-theme-value="auto" href="#" role="button"
                            aria-pressed="false"> <span class="material-symbols-outlined me-2">contrast</span> Auto
                        </a>
                        <hr>
                        <h6 class="dropdown-header">Change Financial Year</h6>
                        @livewire('financial-year-selector')
                    </div>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="#" target="_blank">
                        <span class="material-symbols-outlined">local_mall</span><span class="d-xl-none ms-3">Go to
                            product page</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="material-symbols-outlined">alternate_email</span><span
                            class="d-xl-none ms-3">Contact us</span>
                    </a>
                </div>
            </nav>
        </div>
    </div>
</nav>
