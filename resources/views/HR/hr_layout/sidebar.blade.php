<!doctype html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Place Code</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 5" />
    <meta name="keywords"
        content="dashboard, material, material design, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://themeselection.com/item/materio-bootstrap-html-admin-template/">


    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/logo2.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/remixicon/remixicon.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />

    <!-- Time Picker CSS -->

    <link rel="stylesheet" href="{{ asset('assets/css/timepicker.css') }}">


    <!-- Core CSS -->

    <style>
        /* Excel button styling */
        .btn-excel {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
            /* Light red background */
            border-color: linear-gradient(270deg, #8c57ff 0%, #c3a8ff 100%) !important;
            /* Red border */
            color: #ffff !important;
            border-radius: .375rem !important;
            outline: red !important;
            width: 80px !important;
        }

        .btn-excel:hover {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
            border-color: linear-gradient(270deg, #8c57ff 0%, #c3a8ff 100%) !important;
        }

        /* PDF button styling */
        .btn-pdf {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
            /* Light red background */
            border-color: linear-gradient(270deg, #8c57ff 0%, #c3a8ff 100%) !important;
            /* Red border */
            color: #ffff !important;
            border-radius: .375rem !important;
            outline: red !important;
            width: 80px !important;
            /* Red text */
        }

        .btn-pdf:hover {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
            /* Darker red on hover */
            border-color: linear-gradient(270deg, #8c57ff 0%, #c3a8ff 100%) !important;
        }

        .bg-menu-theme .menu-item.active>.menu-link:not(.menu-toggle) {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
        }

        .create-new {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
        }

        div.dataTables_wrapper {
            position: relative;
            padding: 1.5%;
        }

        .light-style table.table-bordered.dataTable th,
        .light-style table.table-bordered.dataTable td {
            border-color: #E6E59C !important;
        }

        table.dataTable.no-footer {
            border-bottom: 0px solid #e6e5e8;
        }

        body.dark-mode table.dataTable.no-footer {
            border-bottom: 0px solid #474360;
        }

        body.dark-mode .list-btn {
            color: #b0acc7 !important;
        }

        .list-btn {
            color: #8b8693;
        }

        a.paginate_button.current {
            border-radius: 50% !important;
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
            color: #000000 !important;
            border: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            color: #fff !important;
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
        }



        .btn-secondary:hover {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
        }

        .current:hover {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
            border-radius: 50% !important;
            color: #8c57ff !important;
            border: none !important;
        }

        a#example_previous {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
            border-radius: 5% !important;
            margin-right: 5px !important;
            color: white !important;
        }

        a#example_next {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
            border-radius: 5% !important;
            margin-left: 5px !important;
            color: white !important;
        }

        div.dataTables_wrapper {
            position: relative;
            padding: 1.5%;
        }

        .light-style table.table-bordered.dataTable th,
        .light-style table.table-bordered.dataTable td {
            border-color: #E6E59C !important;
        }

        table.dataTable.no-footer {
            border-bottom: 0px solid #e6e5e8;
        }

        body.dark-mode table.dataTable.no-footer {
            border-bottom: 0px solid #474360;
        }

        body.dark-mode .list-btn {
            color: #b0acc7 !important;
        }


        .list-btn {
            color: #8b8693;
        }


        .timepicker_div {
            text-align: center;
            padding: 40px;
        }

        .dataTables_filter input {
            outline: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: 0 !important;
        }

        .datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-top {
            border: 1px solid #d1cfd4;
            padding: 10px;
        }

        .datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom {
            border: 1px solid #d1cfd4;
            padding: 10px;
        }
        div.dt-buttons>.dt-button, div.dt-buttons>div.dt-button-split .dt-button{
            border : none !important;
        }
    </style>




    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" /> --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/form-validation.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-user-view.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />

    {{-- data-table css --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" />

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    {{--
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script> --}}
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <link id="themeStylesheet" rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the toggle button and the current theme from localStorage
            const toggleBtn = document.getElementById('toggleBtn');
            const currentTheme = localStorage.getItem('theme') || 'light';

            // Function to update the CSS link dynamically
            function updateThemeStylesheet(theme) {
                const linkElement = document.getElementById('themeStylesheet');
                if (linkElement) { // Check if the element exists
                    if (theme === 'dark') {
                        linkElement.setAttribute('href', "{{ asset('assets/vendor/css/rtl/core-dark.css') }}");
                    } else {
                        linkElement.setAttribute('href', "{{ asset('assets/vendor/css/rtl/core.css') }}");
                    }
                } else {
                    console.error("Theme stylesheet link element not found.");
                }
            }

            // Apply the saved theme and update the stylesheet on page load
            document.body.className = currentTheme + '-mode';
            updateThemeStylesheet(currentTheme);

            // Toggle theme on button click
            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    const isDarkMode = document.body.classList.contains('dark-mode');
                    const newTheme = isDarkMode ? 'light' : 'dark';
                    document.body.className = newTheme + '-mode';
                    localStorage.setItem('theme', newTheme); // Save theme preference
                    updateThemeStylesheet(newTheme); // Update CSS
                    location.reload();
                });
            } else {
                console.error("Toggle button not found.");
            }
        });
    </script>
    <style>
        #template-customizer {
            visibility: hidden;
            /* Hide by default */
        }

        #template-customizer.visible {
            visibility: visible;
            /* Show when 'visible' class is added */
        }
    </style>
    <style>
        body.dark-mode {
            background-color: #28243d;
            color: #ffffff;
        }

        .toggle-btn {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        body.dark-mode .bg-menu-theme {
            background-color: #28243d !important;
        }

        body.dark-mode .bg-menu-theme .menu-link {
            color: #cac5de;
        }

        body.dark-mode .demo {
            color: #cac5de;
        }

        .input-group {
            padding-bottom: 15px;
        }

        form .error:not(li):not(input) {
            position: absolute;
            bottom: -10px;
            left: 10px;
        }

        .fv-plugins-icon-container {
            position: relative;
        }
    </style>
</head>

<body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('admin.dahsboard') }}" class="app-brand-link">
                        <span class="app-brand-logo demo me-1">
                            <img src="{{ asset('assets/img/favicon/logo2.png') }}" alt="Brand Logo"
                                style="width: 36px;" />
                        </span>
                        <span class="app-brand-text demo menu-text fw-semibold ms-2">Place Code</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="menu-toggle-icon d-xl-block align-middle"></i>
                    </a>
                </div>


                <div class="menu-inner-shadow"></div>
                <ul class="menu-inner py-1">
                    <!-- Dashboards -->
                    <li class="menu-item {{ Route::currentRouteName() == 'hr.dahsboard' ? 'active' : '' }}">
                        <a href="{{ route('hr.dahsboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons ri-home-smile-line"></i>
                            <div>Dashboards</div>
                        </a>
                    </li>

                    <li
                        class="menu-item {{ Route::currentRouteName() == 'hr.department_view' || Route::currentRouteName() == 'hr.employee_view' || Route::currentRouteName() == 'hr.employee' ? 'open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon ri-group-line"></i>
                            <div>Employee</div>
                        </a>
                        <ul class="menu-sub">
                            <li
                                class="menu-item {{ Route::currentRouteName() == 'hr.department_view' ? 'active' : '' }}">
                                <a href="{{ route('hr.department_view') }}" class="menu-link">
                                    <div>Add Department</div>
                                </a>
                            </li>
                            <li
                                class="menu-item {{ Route::currentRouteName() == 'hr.employee' || Route::currentRouteName() == 'hr.employee_view' || Route::currentRouteName() == 'admin.employee.edit' ? 'active' : '' }}">
                                <a href="{{ route('hr.employee') }}" class="menu-link">
                                    <div>Add Employee Details</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item {{ Route::currentRouteName() == 'hr.Add_holiday' ? 'active' : '' }}">
                        <a href="{{ route('hr.Add_holiday') }}" class="menu-link">
                            <i class="menu-icon tf-icons ri-sun-line"></i>
                            <div>Holiday</div>
                        </a>
                    </li>

                    <li class="menu-item {{ Route::currentRouteName() == 'hr.upcoming_festival' ? 'active' : '' }}">
                        <a href="{{ route('hr.upcoming_festival') }}" class="menu-link">
                            <i class="menu-icon tf-icons ri-cake-line"></i>
                            <div>Festival</div>
                        </a>
                    </li>

                    <li
                        class="menu-item {{ Route::currentRouteName() == 'hr.today.attendance' || Route::currentRouteName() == 'hr.employee_attendance' || Route::currentRouteName() == 'hr.index.overtime' || Route::currentRouteName() == 'hr.index.benefits' ? 'active' : '' }} {{ Route::currentRouteName() == 'hr.today.attendance' || Route::currentRouteName() == 'hr.employee_attendance' || Route::currentRouteName() == 'hr.index.overtime' || Route::currentRouteName() == 'hr.index.benefits' ? 'open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ri-checkbox-circle-line"></i>
                            <div>Attendance</div>
                        </a>
                        <ul class="menu-sub">
                            <li
                                class="menu-item {{ Route::currentRouteName() == 'hr.today.attendance' ? 'active' : '' }}">
                                <a href="{{ route('hr.today.attendance') }}" class="menu-link">
                                    <div>Today's Attendance</div>
                                </a>
                            </li>
                            <li
                                class="menu-item {{ Route::currentRouteName() == 'hr.employee_attendance' ? 'active' : '' }}">
                                <a href="{{ route('hr.employee_attendance') }}" class="menu-link">
                                    <div>Employee Attendance</div>
                                </a>
                            </li>
                            <li
                                class="menu-item {{ Route::currentRouteName() == 'hr.index.overtime' ? 'active' : '' }}">
                                <a href="{{ route('hr.index.overtime') }}" class="menu-link">
                                    <div>Over Time</div>
                                </a>
                            </li>
                            <li
                                class="menu-item {{ Route::currentRouteName() == 'hr.index.benefits' ? 'active' : '' }}">
                                <a href="{{ route('hr.index.benefits') }}" class="menu-link">
                                    <div>Benefits</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item {{ Route::currentRouteName() == 'hr.leave_request_list' ? 'open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ri-calendar-line"></i>
                            <div>Leave Management</div>
                        </a>
                        <ul class="menu-sub">
                            <li
                                class="menu-item {{ Route::currentRouteName() == 'hr.leave_request_list' ? 'active' : '' }}">
                                <a href="{{ route('hr.leave_request_list') }}" class="menu-link">
                                    <div>All Leave Requests</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if (optional(Auth::user()->page_role)->client_data == 1 || optional(Auth::user()->page_role)->client_income == 1)
                        <li
                            class="menu-item {{ Route::currentRouteName() == 'hr.Client_view' ? 'active' : '' }} {{ Route::currentRouteName() == 'hr.Client_view' || Route::currentRouteName() == 'hr.Clinetincome' ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons ri-user-line"></i>
                                <div>Client</div>
                            </a>
                            @if (optional(Auth::user()->page_role)->client_data == 1)
                                <ul class="menu-sub">
                                    <li
                                        class="menu-item {{ Route::currentRouteName() == 'hr.Client_view' ? 'active' : '' }}">
                                        <a href="{{ route('hr.Client_view') }}" class="menu-link">
                                            <div>Client Data</div>
                                        </a>
                                    </li>
                                </ul>
                            @endif
                            @if (optional(Auth::user()->page_role)->client_income == 1)
                                <ul class="menu-sub">
                                    <li
                                        class="menu-item {{ Route::currentRouteName() == 'hr.Clinetincome' ? 'active' : '' }}">
                                        <a href="{{ route('hr.Clinetincome') }}" class="menu-link">
                                            <div>Client Income</div>
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        </li>
                    @endif

                    @if (optional(Auth::user()->page_role)->project_data == 1)
                        <li class="menu-item {{ Route::currentRouteName() == 'hr.project_index' ? 'active' : '' }}">
                            <a href="{{ route('hr.project_index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ri-node-tree"></i>
                                <div>Project </div>
                            </a>
                        </li>
                    @endif


                    @if (optional(Auth::user()->page_role)->invoice == 1)
                        <li
                            class="menu-item 
                        {{ in_array(Route::currentRouteName(), ['hr.invoice.index', 'hr.invoice.create', 'hr.invoice.update', 'hr.invoice.deleted']) ? 'active' : '' }} 
                        {{ in_array(Route::currentRouteName(), ['hr.invoice.index', 'hr.invoice.create', 'hr.invoice.update', 'hr.invoice.deleted']) ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon ri-group-line"></i>
                                <div>Invoice</div>
                            </a>
                            <ul class="menu-sub">
                                <!-- Only activate Invoice List when on hr.invoice.index -->
                                <li
                                    class="menu-item {{ in_array(Route::currentRouteName(), ['hr.invoice.index', 'hr.invoice.create' ,'hr.invoice.update']) ? 'active' : '' }}">
                                    <a href="{{ route('hr.invoice.index') }}" class="menu-link">
                                        <div>Invoice Index</div>
                                    </a>
                                </li>
                            </ul>
                            <!-- Deleted Invoices Menu -->
                            <ul class="menu-sub">
                                <li
                                    class="menu-item {{ Route::currentRouteName() == 'hr.invoice.deleted' ? 'active' : '' }}">
                                    <a href="{{ route('hr.invoice.deleted') }}" class="menu-link">
                                        <div>Restore Invoices</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (optional(Auth::user()->page_role)->company_progress == 1)
                        <li
                            class="menu-item {{ Route::currentRouteName() == 'hr.company_progress' ? 'active' : '' }}">
                            <a href="{{ route('hr.company_progress') }}" class="menu-link">
                                <i class="menu-icon ri-line-chart-fill"></i>
                                <div>Company Progress</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </aside>
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="ri-menu-fill ri-24px"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <!-- <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="ri-search-line ri-22px me-2"></i>
                                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                                    aria-label="Search..." />
                            </div>
                        </div> -->
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto" style="gap:5px">
                            <li>
                                <a id="toggleBtn"
                                    class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow waves-effect waves-light show"
                                    href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true"
                                    style="width: 50px;height: 44px;">
                                    <i class="ri-22px ri-moon-clear-line"></i>
                                </a>
                            </li>


                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        @php
                                            $data = Auth::user();
                                            $filePath = public_path('profile_image/' . $data->profile_image);
                                        @endphp
                                        @if (!empty($data->profile_image) && file_exists($filePath))
                                            <img src="{{ asset('profile_image/' . $data->profile_image) }}" alt
                                                class="w-px-40 h-auto rounded-circle">
                                        @else
                                            <img src="{{ asset('assets/img/avatars/2.png') }}" alt
                                                class="w-px-40 h-auto rounded-circle" />
                                        @endif
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <div class="avatar avatar-online">
                                                        @php
                                                            $data = Auth::user();
                                                            $filePath = public_path(
                                                                'profile_image/' . $data->profile_image,
                                                            );
                                                        @endphp
                                                        @if (!empty($data->profile_image) && file_exists($filePath))
                                                            <img src="{{ asset('profile_image/' . $data->profile_image) }}"
                                                                alt class="w-px-40 h-auto rounded-circle">
                                                        @else
                                                            <img src="{{ asset('assets/img/avatars/2.png') }}" alt
                                                                class="w-px-40 h-auto rounded-circle" />
                                                        @endif

                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0 small">{{ Auth::user()->emo_name }}</h6>
                                                    <small class="text-muted">
                                                        @if (Auth::user()->role == 0)
                                                            Admin
                                                        @elseif(Auth::user()->role == 1)
                                                            Team Head
                                                        @elseif(Auth::user()->role == 2)
                                                            Employee
                                                        @elseif(Auth::user()->role == 3)
                                                            HR
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('hr.profile.edit') }}">
                                            <i class="ri-user-3-line ri-22px me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <!-- <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="ri-settings-4-line ri-22px me-2"></i>
                                            <span class="align-middle">Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <span class="d-flex align-items-center align-middle">
                                                <i class="flex-shrink-0 ri-file-text-line ri-22px me-3"></i>
                                                <span class="flex-grow-1 align-middle">Billing</span>
                                                <span
                                                    class="flex-shrink-0 badge badge-center rounded-pill bg-danger h-px-20 d-flex align-items-center justify-content-center">4</span>
                                            </span>
                                        </a>
                                    </li> -->
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <div class="d-grid px-4 pt-2 pb-1">
                                            <a class="btn btn-danger d-flex" href="{{ route('admin.logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <small class="align-middle">Logout</small>
                                                <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                                            </a>
                                            <form id="logout-form" action="{{ route('admin.logout') }}"
                                                method="get" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    @yield('content')
                    <!-- / Content -->

                    <!-- Footer -->

                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script> -->

    <!-- <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script> -->
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    {{--
    <script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script> --}}
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>


    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>

    {{--
    <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script> --}}
    {{--
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script> --}}

    <!-- Flat Picker -->
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        // flatpickr('.dob-picker', {
        //     enableTime: false,
        //     dateFormat: "d-m-Y",
        // });
        // $(function() {
        //     $('.dob-picker').datepicker({
        //         dateFormat: "d-m-Y",
        //     });
        // });
        $(function() {
            $(".dob-picker").datepicker({
                autoclose: true,
                todayHighlight: true,
                dateFormat: "d-m-Y",
            }).datepicker();
        });
    </script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/dashboards-0.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

    <script src="{{ asset('assets/js/modal-edit-user.js') }}"></script>
    <script src="{{ asset('assets/js/app-user-view.js') }}"></script>
    <script src="{{ asset('assets/js/app-user-view-account.js') }}"></script>

    <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script>
    <script src="{{ asset('assets/js/app-invoice-edit.js') }}"></script>

    {{--
    <script src="{{asset('assets/js/tables-datatables-advanced.js')}}"></script> --}}

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <!-- Select2 JS -->
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>

    <script>
        $(".select2").select2({});
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "processing": true,
                "serverside": true,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<span>Excel</span>', // Custom text and color
                        className: 'btn-excel', // Add a custom class for additional styling
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<span >PDF</span>', // Custom text and color
                        className: 'btn-pdf', // Add a custom class for additional styling
                    },
                ]
            });
        });
    </script>


    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    {{--
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script> --}}

    <script>
        $(document).ready(function() {
            // When the open/close button is clicked
            $(".template-customizer-open-btn").on("click", function() {
                // Toggle the visibility of the template customizer
                $("#template-customizer").toggleClass("template-customizer-open");
            });
        });
    </script>

    <!-- Timepicker JS -->
    <script src="{{ asset('assets/js/timepicker.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.timepicker').mdtimepicker();
        });

        $('.btn-close').click(function() {
            $('.remove-error').hide();
        });
    </script>


</body>

</html>
