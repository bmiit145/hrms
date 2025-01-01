<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact " dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">


<!-- Mirrored from demos.themeselection.com/sneat-bootstrap-html-admin-template-free/html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 04 Dec 2023 06:59:05 GMT -->

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Place Code</title>


    <meta name="description"
        content="Most Powerful &amp; Comprehensive Bootstrap 5 HTML Admin Dashboard Template built for developers!" />
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://themeselection.com/item/sneat-bootstrap-html-admin-template/">


    <!-- ? PROD Only: Google Tag Manager (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                '../../../www.googletagmanager.com/gtm5445.html?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5DDHKGP');
    </script>
    <style>
        .layout-page,
        .content-wrapper,
        .content-wrapper>*,
        .layout-menu {
            padding: 20px;
        }
        
    </style>
    <!-- End Google Tag Manager -->

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/avatars/logo2.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap"
        rel="stylesheet">


    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/boxicons.css')}}" />


    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}" />

    <!-- Page CSS -->


    <!-- Helpers -->
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('assets/js/config.js')}}"></script>

</head>

<body>


    <!-- ?PROD Only: Google Tag Manager (noscript) (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0"
            style="display: none; visibility: hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar  ">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">


                <div class="app-brand demo ">
                    <a href="index.html" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="{{asset('assets/img/avatars/logo.png')}}" alt="profile Pic" style="width:175px;">
                        </span>

                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>



                <ul class="menu-inner py-1">

                    <!-- Dashboards -->
                    <li class="menu-item active open">
                            <li class="menu-item">
                                <a href="{{route('user.dahsboard')}}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                                    <div data-i18n="Email">Dashboards</div>
                                </a>
                            </li>

                      {{-- User attendeance role  --}}
                        <li class="menu-item">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-calendar"></i>
                                <div data-i18n="Layouts">Attendance</div>
                            </a>

                            <ul class="menu-sub">

                                <li class="menu-item">
                                    <a href="{{route('user.user_attendance_list')}}" class="menu-link">
                                        <div data-i18n="Without menu">Attendance List</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{route('user.user_attendance_sheet')}}" class="menu-link">
                                        <div data-i18n="Without menu">Attendance Sheet</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-list-check"></i>
                                <div data-i18n="Layouts">Leave Management</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item">
                                    <a href="{{route('user.leave_request_create')}}" class="menu-link">
                                        <div data-i18n="Without menu">Leave Requests</div>
                                    </a>
                                </li>  
                            </ul>
                        </li>
                    </li>

                </ul>

            </aside>
            <!-- / Menu -->
            
            <!-- Layout container -->
            <div class="layout-page">

                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>



                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

 
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search fs-4 lh-0"></i>
                                <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2"
                                    placeholder="Search..." aria-label="Search...">
                            </div>
                        </div>
                        <!-- /Search -->
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                  <i class="bx bx-bell bx-sm"></i>
                                  <span class="badge bg-danger rounded-pill badge-notifications" style="margin-left: -13px;height: 18px;width: 18px;padding: 4px;">0</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end py-0" style="width: 800%;">
                                  <li class="dropdown-menu-header border-bottom">
                                    <div class="dropdown-header d-flex align-items-center py-3">
                                      <h5 class="text-body mb-0 me-auto">Notification</h5>
                                      <a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i class="bx fs-4 bx-envelope-open"></i></a>
                                    </div>
                                  </li>
                                 
                                  <li class="dropdown-menu-footer border-top p-3">
                                    <button class="btn btn-primary text-uppercase w-100">view all notifications</button>
                                  </li>
                                </ul>
                              </li>
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar">
                                    @php
                                        $data = Auth::user();
                                        $filePath = public_path('profile_image/' . $data->profile_image);
                                    @endphp
                                    @if(!empty($data->profile_image) && file_exists($filePath)) 
                                        <img src="{{asset('profile_image/'.$data->profile_image)}}" alt
                                            class="w-px-40 h-auto rounded-circle">
                                    @else
                                        <img src="{{asset('assets/img/avatars/1.png')}}" alt
                                            class="w-px-40 h-auto rounded-circle">
                                    @endif
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                    @php
                                                        $data = Auth::user();
                                                        $filePath = public_path('profile_image/' . $data->profile_image);
                                                    @endphp
                                                    @if(!empty($data->profile_image) && file_exists($filePath)) 
                                                        <img src="{{asset('profile_image/'.$data->profile_image)}}" alt
                                                            class="w-px-40 h-auto rounded-circle">
                                                    @else
                                                        <img src="{{asset('assets/img/avatars/1.png')}}" alt
                                                            class="w-px-40 h-auto rounded-circle">
                                                    @endif
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-medium d-block">{{Auth::user()->emo_name}}</span>
                                                     @if(Auth::user()->role == 0)
                                                     <small class="text-muted">Admin</small>
                                                     @elseif(Auth::user()->role == 1)
                                                     <small class="text-muted">user</small>
                                                     @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{route('User.profile.edit',Auth::user()->id)}}">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bx bx-power-off me-2 text-danger"></i>
                                            <span class="align-middle text-danger">Log Out</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('admin.logout') }}" method="get"
                                             class="d-none">
                                        @csrf
                                    </form>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->

                        </ul>
                    </div>
                </nav>




                <!-- Content wrapper -->
                <div class="content-wrapper">
                    @yield('content')
                    <div class="content-backdrop fade"> </div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>





        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>


    </div>


    {{-- <script src="../assets/vendor/libs/jquery/jquery.js"></script> --}}
    <script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('assets/vendor/js/menu.js')}}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

    <!-- Main JS -->
    <script src="{{asset('assets/js/main.js')}}"></script>


    <!-- Page JS -->
    <script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <!-- <script async defer src="{{asset('buttons.github.io/buttons.js')}}"></script> -->

</body>


<!-- Mirrored from demos.themeselection.com/sneat-bootstrap-html-admin-template-free/html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 04 Dec 2023 06:59:08 GMT -->

</html>

<!-- beautify ignore:end -->
