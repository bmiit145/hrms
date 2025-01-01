@extends('User.user_layout.sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
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

    .nav-link {
        color: black;
        background-color: transparent;
    }

    .nav-link.active {
        color: white;
        background-color: #8c57ff;
    }
    body.dark-mode .tablink {
        color: #d5d1ea !important;
    }

    .form-check-input:checked {
        background-color: #8c57ff !important;
        border: none !important;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">


<div class="row">
    <!-- User Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
        <!-- User Card -->
        <div class="card mb-6">
            <div class="card-body pt-12">
                <div class="user-avatar-section">
                    <div class="d-flex align-items-center flex-column">
                        @if(isset($data) && !empty($data->profile_image) && file_exists(public_path('profile_image/' . $data->profile_image)))
                            <!-- Only show the image and delete button if the file exists -->
                            <img class="toZoom" src="{{ asset('profile_image/' . $data->profile_image) }}" width="100"
                                height="100" alt="Document">
                        @else
                            <img class="img-fluid rounded mb-4" src="{{asset('assets/img/avatars/2.png')}}" height="120"
                                width="120" alt="User avatar">
                        @endif
                        <div class="user-info text-center">
                            <h5>{{$data->emo_name ?? ''}}</h5>
                        </div>
                    </div>
                </div>
                <h5 class="pb-4 border-bottom mb-4">Details</h5>
                <div class="info-container">
                    <ul class="list-unstyled mb-6">
                        <li class="mb-2">
                            <span class="h6">Full Name :</span>
                            <span>{{$data->emo_name ?? ''}}</span>
                        </li>
                        <li class="mb-2">
                            <span class="h6">Email :</span>
                            <span>{{$data->email ?? ''}}</span>
                        </li>
                        <li class="mb-2">
                            <span class="h6">Contact :</span>
                            <span>{{$data->emp_mobile_no ?? ''}}</span>
                        </li>
                        <li class="mb-2">
                            <span class="h6">Birthday Date :</span>
                            <span>{{ \Carbon\Carbon::parse($data->emp_birthday_date)->format('d-m-Y') ?? '' }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="h6">Address :</span>
                            <span>{{ $data->emp_address ?? '' }}</span>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:;" class="btn me-4 waves-effect waves-light"
                        style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;" data-bs-target="#editUser"
                            data-bs-toggle="modal">Edit</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /User Card -->
    </div>
    <!--/ User Sidebar -->


    <!-- User Content -->
    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
        <!-- User Tabs -->
        <div class="nav-align-top">
            <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
                {{-- <li class="nav-item">
                    <a class="nav-link active waves-effect waves-light tablink" href="javascript:void(0);"
                        id="defaultOpen" onclick="openPage('Account', this, '#8c57ff')">
                        <i class="ri-group-line me-1_5"></i>Account
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light tablink" href="javascript:void(0);" id="defaultOpen"
                        onclick="openPage('Security', this, '#8c57ff')" style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;">
                        <i class="ri-lock-2-line me-1_5"></i>Security
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link waves-effect waves-light tablink" href="javascript:void(0);"
                        onclick="openPage('BillingAndPlans', this, '#8c57ff')">
                        <i class="ri-bookmark-line me-1_5"></i>Billing &amp; Plans
                    </a>
                </li> -->
                {{-- <li class="nav-item">
                    <a class="nav-link waves-effect waves-light tablink" href="javascript:void(0);"
                        onclick="openPage('Notifications', this, '#8c57ff')">
                        <i class="ri-notification-4-line me-1_5"></i>Notifications
                    </a>
                </li> --}}
                <!-- <li class="nav-item">
                    <a class="nav-link waves-effect waves-light tablink" href="javascript:void(0);"
                        onclick="openPage('Connections', this, '#8c57ff')">
                        <i class="ri-link-m me-1_5"></i>Connections
                    </a>
                </li> -->
            </ul>

            <div id="Account" class="tabcontent">
                <!-- Project table -->
                <div class="card mb-6">
                    <div class="card-datatable table-responsive mb-n8">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="card-header d-flex flex-wrap row-gap-5">
                                <div class="project-head-label">
                                    <h5 class="card-title mb-0">Project List</h5>
                                </div>
                                <div class=" text-end pt-0 my-n5">
                                    <div id="DataTables_Table_0_filter" class="dataTables_filter"><label><input
                                                type="search" class="form-control form-control-sm ms-0"
                                                placeholder="Search Project"
                                                aria-controls="DataTables_Table_0"></label>
                                    </div>
                                </div>
                            </div>
                            <table
                                class="table datatable-project table-border-bottom-0 dataTable no-footer dtr-column"
                                id="DataTables_Table_0" style="width: 921px;">
                                <thead>
                                    <tr>
                                        <th class="control sorting_disabled dtr-hidden" rowspan="1" colspan="1"
                                            style="width: 0px; display: none;" aria-label=""></th>
                                        <th class="sorting sorting_desc" tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                            style="width: 350px;"
                                            aria-label="Project: activate to sort column ascending"
                                            aria-sort="descending">
                                            Project</th>
                                        <th class="text-nowrap sorting" tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                            style="width: 149px;"
                                            aria-label="Total Task: activate to sort column ascending">Total Task
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1" style="width: 134px;"
                                            aria-label="Progress: activate to sort column ascending">Progress</th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 114px;"
                                            aria-label="Hours">Hours</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd">
                                        <td class="  control" tabindex="0" style="display: none;"></td>
                                        <td class="sorting_1">
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar-wrapper">
                                                    <div class="avatar avatar-sm me-4"><img
                                                            src="../../assets/img/icons/brands/vue.png"
                                                            alt="Project Image" class="rounded-circle"></div>
                                                </div>
                                                <div class="d-flex flex-column"><span
                                                        class="text-truncate fw-medium text-heading">Vue Admin
                                                        template</span><small>Vuejs Project</small></div>
                                            </div>
                                        </td>
                                        <td><span class="text-heading">214/627</span></td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <p class="mb-0 text-heading">78%</p>
                                                <div class="progress rounded bg-label-success w-100 me-3"
                                                    style="height: 6px;">
                                                    <div class="progress-bar rounded bg-success" style="width: 78%"
                                                        aria-valuenow="78%" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>88:19h</td>
                                    </tr>
                                    <tr class="even">
                                        <td class="  control" tabindex="0" style="display: none;"></td>
                                        <td class="sorting_1">
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar-wrapper">
                                                    <div class="avatar avatar-sm me-4"><img
                                                            src="../../assets/img/icons/brands/html-label.png"
                                                            alt="Project Image" class="rounded-circle"></div>
                                                </div>
                                                <div class="d-flex flex-column"><span
                                                        class="text-truncate fw-medium text-heading">Hoffman
                                                        Website</span><small>HTML Project</small></div>
                                            </div>
                                        </td>
                                        <td><span class="text-heading">56/183</span></td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <p class="mb-0 text-heading">43%</p>
                                                <div class="progress rounded bg-label-warning w-100 me-3"
                                                    style="height: 6px;">
                                                    <div class="progress-bar rounded bg-warning" style="width: 43%"
                                                        aria-valuenow="43%" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>76h</td>
                                    </tr>
                                    <tr class="odd">
                                        <td class="  control" tabindex="0" style="display: none;"></td>
                                        <td class="sorting_1">
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar-wrapper">
                                                    <div class="avatar avatar-sm me-4"><img
                                                            src="../../assets/img/icons/brands/xamarin.png"
                                                            alt="Project Image" class="rounded-circle"></div>
                                                </div>
                                                <div class="d-flex flex-column"><span
                                                        class="text-truncate fw-medium text-heading">Foodista Mobile
                                                        App</span><small>Xamarin Project</small></div>
                                            </div>
                                        </td>
                                        <td><span class="text-heading">12/20</span></td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <p class="mb-0 text-heading">69%</p>
                                                <div class="progress rounded bg-label-info w-100 me-3"
                                                    style="height: 6px;">
                                                    <div class="progress-bar rounded bg-info" style="width: 69%"
                                                        aria-valuenow="69%" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>12:12h</td>
                                    </tr>
                                    <tr class="even">
                                        <td class="  control" tabindex="0" style="display: none;"></td>
                                        <td class="sorting_1">
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar-wrapper">
                                                    <div class="avatar avatar-sm me-4"><img
                                                            src="../../assets/img/icons/brands/sketch-label.png"
                                                            alt="Project Image" class="rounded-circle"></div>
                                                </div>
                                                <div class="d-flex flex-column"><span
                                                        class="text-truncate fw-medium text-heading">Foodista mobile
                                                        app</span><small>iPhone Project</small></div>
                                            </div>
                                        </td>
                                        <td><span class="text-heading">12/86</span></td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <p class="mb-0 text-heading">49%</p>
                                                <div class="progress rounded bg-label-warning w-100 me-3"
                                                    style="height: 6px;">
                                                    <div class="progress-bar rounded bg-warning" style="width: 49%"
                                                        aria-valuenow="49%" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>45h</td>
                                    </tr>
                                    <tr class="odd">
                                        <td class="  control" tabindex="0" style="display: none;"></td>
                                        <td class="sorting_1">
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar-wrapper">
                                                    <div class="avatar avatar-sm me-4"><img
                                                            src="../../assets/img/icons/brands/xd-label.png"
                                                            alt="Project Image" class="rounded-circle"></div>
                                                </div>
                                                <div class="d-flex flex-column"><span
                                                        class="text-truncate fw-medium text-heading">Falcon Logo
                                                        Design</span><small>UI/UX Project</small></div>
                                            </div>
                                        </td>
                                        <td><span class="text-heading">9/50</span></td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <p class="mb-0 text-heading">15%</p>
                                                <div class="progress rounded bg-label-danger w-100 me-3"
                                                    style="height: 6px;">
                                                    <div class="progress-bar rounded bg-danger" style="width: 15%"
                                                        aria-valuenow="15%" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>89h</td>
                                    </tr>
                                    <tr class="even">
                                        <td class="  control" tabindex="0" style="display: none;"></td>
                                        <td class="sorting_1">
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar-wrapper">
                                                    <div class="avatar avatar-sm me-4"><img
                                                            src="../../assets/img/icons/brands/react-info.png"
                                                            alt="Project Image" class="rounded-circle"></div>
                                                </div>
                                                <div class="d-flex flex-column"><span
                                                        class="text-truncate fw-medium text-heading">Dojo React
                                                        Project</span><small>React Project</small></div>
                                            </div>
                                        </td>
                                        <td><span class="text-heading">234/378</span></td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <p class="mb-0 text-heading">73%</p>
                                                <div class="progress rounded bg-label-info w-100 me-3"
                                                    style="height: 6px;">
                                                    <div class="progress-bar rounded bg-info" style="width: 73%"
                                                        aria-valuenow="73%" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>67:10h</td>
                                    </tr>
                                    <tr class="odd">
                                        <td class="  control" tabindex="0" style="display: none;"></td>
                                        <td class="sorting_1">
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar-wrapper">
                                                    <div class="avatar avatar-sm me-4"><img
                                                            src="../../assets/img/icons/brands/figma-label-info.png"
                                                            alt="Project Image" class="rounded-circle"></div>
                                                </div>
                                                <div class="d-flex flex-column"><span
                                                        class="text-truncate fw-medium text-heading">Dashboard
                                                        Design</span><small>Vuejs Project</small></div>
                                            </div>
                                        </td>
                                        <td><span class="text-heading">100/190</span></td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <p class="mb-0 text-heading">90%</p>
                                                <div class="progress rounded bg-label-success w-100 me-3"
                                                    style="height: 6px;">
                                                    <div class="progress-bar rounded bg-success" style="width: 90%"
                                                        aria-valuenow="90%" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>129:45h</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /Project table -->
            </div>

            <div id="Security" class="tabcontent">
                <!-- Change Password -->
                <div class="card mb-6">
                    <h5 class="card-header">Change Password</h5>
                    <div class="card-body">
                        <form action="{{route('admin.changepass')}}" id="passwordForm" method="POST"
                            class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                            @csrf
                            <input type="hidden" name="id" value="{{$data->id ?? ''}}">
                            <div class="row gx-5">
                                <div class="mb-4 col-12 col-sm-6 form-password-toggle fv-plugins-icon-container">
                                    <div class="input-group input-group-merge">
                                        <div class="form-floating form-floating-outline">
                                            <input class="form-control" type="password" id="emp_password"
                                                name="emp_password" placeholder="············">
                                            <label for="newPassword">New Password</label>
                                        </div>
                                        <span class="input-group-text cursor-pointer"><i
                                                class="ri-eye-off-line ri-20px"></i></span>
                                    </div>
                                    <label id="emp_password-error" class="error" for="emp_password"></label>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                                <div class="mb-4 col-12 col-sm-6 form-password-toggle fv-plugins-icon-container">
                                    <div class="input-group input-group-merge">
                                        <div class="form-floating form-floating-outline">
                                            <input class="form-control" type="password" name="confirm_password"
                                                id="confirm_password" placeholder="············">
                                            <label for="confirmPassword">Confirm New Password</label>
                                        </div>
                                        <span class="input-group-text cursor-pointer"><i
                                                class="ri-eye-off-line ri-20px"></i></span>
                                    </div>
                                    <label id="confirm_password-error" class="error" for="confirm_password"></label>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" class="btn me-2 waves-effect waves-light"
                                    style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;margin-top: 25px;">Change
                                        Password</button>
                                </div>
                            </div>
                            <input type="hidden">
                        </form>
                    </div>
                </div>
                <!--/ Change Password -->
            </div>

            <!-- <div id="BillingAndPlans" class="tabcontent">
                <h3>Contact</h3>
                <p>Get in touch, or swing by for a cup of coffee.</p>
            </div> -->

            <div id="Notifications" class="tabcontent">
                <div class="card mb-6">
                    <!-- Notifications -->
                    <h5 class="card-header border-bottom mb-0">Notifications</h5>
                    <div class="card-body py-4">
                        <span class="text-heading fw-medium">Change to notification settings, the user will get the
                            update</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Type</th>
                                    <th class="text-nowrap text-center">Email</th>
                                    <th class="text-nowrap text-center">Browser</th>
                                    <th class="text-nowrap text-center">App</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-nowrap text-heading">New for you</td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck1"
                                                checked="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck2"
                                                checked="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck3"
                                                checked="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap text-heading">Account activity</td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck4"
                                                checked="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck5"
                                                checked="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck6"
                                                checked="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap text-heading">A new browser used to sign in</td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck7"
                                                checked="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck8"
                                                checked="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck9">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap text-heading">A new device is linked</td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck10"
                                                checked="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck11">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck12">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary me-3 waves-effect waves-light"
                            style=" background: #7e4ee6;color: #f0f8ff;">Save
                            changes</button>
                    </div>
                    <!-- /Notifications -->
                </div>
            </div>
            <!-- <div id="Connections" class="tabcontent">
                <h3>About</h3>
                <p>Who we are and what we do.</p>
            </div> -->
            <!--/ User Tabs -->

        </div>
        <!--/ User Content -->
    </div>

    <!-- Modal -->
    <!-- Edit User Modal -->
    <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-edit-user">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-6">
                        <h4 class="mb-2">Edit {{$data->emo_name ?? ''}} Information</h4>
                    </div>
                    <form action="{{route('admin.profile.update')}}" method="post" id="editUserForm"
                        class="row g-5 fv-plugins-bootstrap5 fv-plugins-framework myForm"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="user_id" name="user_id" value="{{$data->id ?? ''}}">
                        <div class="col-12 col-md-6 fv-plugins-icon-container">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="emp_name" class="form-control" id="emp_name"
                                    placeholder="Enter Name" value="{{ $data->emo_name ?? '' }}">
                                @error('emp_name')
                                    <div class="text-danger fw-semibold">{{ $message }}</div>
                                @enderror
                                <label for="modalEditUserFirstName">Full Name</label>
                            </div>
                            <label id="emp_name-error" class="error" for="emp_name"></label>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 fv-plugins-icon-container">
                            <div class="form-floating form-floating-outline">
                                <input type="email" class="form-control emp_email" name="emp_email" id="emp_email"
                                    placeholder="Enter Email" value="{{ $data->email ?? '' }}">
                                @error('emp_email')
                                    <div class="text-danger fw-semibold">{{ $message }}</div>
                                @enderror
                                <label for="modalEditUserLastName">Email</label>
                            </div>
                            <label id="emp_email-error" class="error" for="emp_email"></label>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control mobile" name="emp_mobile_no[main]" id=""
                                    placeholder="Enter Mobile no" value="{{ $data->emp_mobile_no ?? '' }}">

                                @error('emp_mobile_no.main')
                                    <div class="text-danger fw-semibold">{{ $message }}</div>
                                @enderror
                                <label for="modalEditUserName">Mobile Number</label>
                            </div>
                            <label id="emp_mobile_no[main]-error" class="error" for="emp_mobile_no[main]"></label>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" readonly class="form-control dob-picker" name="emp_birthday_date"
                                    id="emp_birthday_date" value="{{ $data->emp_birthday_date ?? '' }}"
                                    placeholder="Select Birthday Date">
                                @error('emp_birthday_date')
                                    <div class="text-danger fw-semibold">{{ $message }}</div>
                                @enderror
                                <label for="modalEditUserEmail">Birthday Date</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-floating form-floating-outline">
                                <textarea name="address" class="form-control" row="3"
                                    placeholder="Enter Address">{{$data->emp_address ?? ''}}</textarea>
                                @error('emp_birthday_date')
                                    <div class="text-danger fw-semibold">{{ $message }}</div>
                                @enderror
                                <label for="modalEditUserEmail">Address</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="file" class="form-control" name="profile_image" id="profile_image" />
                                @error('profile_image')
                                    <div class="text-danger fw-semibold">{{ $message }}</div>
                                @enderror
                                <label for="modalEditUserEmail">Profile Picture</label>
                            </div>
                            <label id="profile_image-error" class="error" for="profile_image"></label>
                            <div class="mt-2" style="position: relative;">
                                @if(isset($data) && !empty($data->profile_image) && file_exists(public_path('profile_image/' . $data->profile_image)))
                                    <!-- Only show the image and delete button if the file exists -->
                                    <img class="toZoom" src="{{ asset('profile_image/' . $data->profile_image) }}"
                                        width="150" height="150" alt="Document">
                                    <div class="icon-container" style="position: absolute;top:1px;left:130px;">
                                        <a href="{{ asset('profile_image/' . $data->profile_image) }}"
                                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;"
                                            class="btn btn-sm" download title="Download">
                                            <i class="ri-download-2-line"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn me-3 waves-effect waves-light"
                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary waves-effect"
                                data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                        <input type="hidden">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Edit User Modal -->

    <!-- /Modal -->
</div>


{{-- datable java script --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

<script>
    function openPage(pageName, elmnt, color) {
        var i, tabcontent, tablinks;

        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        tablinks = document.getElementsByClassName("nav-link");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
            tablinks[i].style.backgroundColor = "transparent"; // Reset background color for inactive tabs
        }

        document.getElementById(pageName).style.display = "block";
        elmnt.className += " active";
        elmnt.style.backgroundColor = color; // Set background color for active tab
    }

    // Set default open tab
    document.getElementById("defaultOpen").click();        
</script>

<script>
    $(document).ready(function () {
        var deleteDocument = null;  // To store the document or image name
        var deleteId = null;        // To store the document or image ID
        var deleteRow = null;       // To store the document or image row element for removal

        // Handle delete button click for the second modal
        $(".profile-delete-btn").click(function () {
            deleteDocument = $(this).data("profile_document");
            deleteId = $(this).data("user_id");
            deleteRow = $(this).closest('.mt-2'); // Get the row that contains the image

            // Show the second modal
            $("#profileConfirmDeleteModal").show();
        });

        // Close the second modal when the user clicks "Cancel"
        $("#profileCancelDelete").click(function (event) {
            event.preventDefault();
            $("#profileConfirmDeleteModal").hide();
        });

        // Handle the confirmation of deletion in the second modal
        $("#profileConfirmDelete").click(function () {
            $.ajax({
                url: '{{route('admin.delete.emp.profile.document')}}',  // Backend route for deleting the document
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',  // CSRF token for security
                    document: deleteDocument,
                    id: deleteId
                },
                success: function (response) {
                    if (response.success) {
                        deleteRow.remove();  // Remove the image and button
                        $("#profileConfirmDeleteModal").hide();  // Hide the second modal
                    } else {
                        alert('Error deleting document');
                    }
                },
                error: function () {
                    alert('An error occurred while deleting the document.');
                }
            });
        });

        // Close the second modal when the user clicks the close button (X)
        $(".delete-close").click(function () {
            $("#profileConfirmDeleteModal").hide();
        });
    });
</script>

<script>
    $(document).ready(function () {

        // Custom validation to check for valid file types (image or pdf only)
        $.validator.addMethod("emp_document", function (value, element) {
            if (element.files && element.files.length > 0) {
                let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp|\.pdf)$/i;
                return allowedTypes.test(element.files[0].name);
            }
            return true;
        }, "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) and PDF files are allowed.");

        $.validator.addMethod("emp_bank_document", function (value, element) {
            if (element.files && element.files.length > 0) {
                let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp)$/i;
                return allowedTypes.test(element.files[0].name);
            }
            return true;
        }, "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) files are allowed.");

        $.validator.addMethod("profile_image", function (value, element) {
            if (element.files && element.files.length > 0) {
                let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp)$/i;
                return allowedTypes.test(element.files[0].name);
            }
            return true;
        }, "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) files are allowed.");

        $('.myForm').validate({ // initialize the plugin

            rules: {
                emp_name: {
                    required: true
                },
                emp_email: {
                    required: true,
                    email: true,
                    remote: {
                        url: '{{ route('admin.checkEmail') }}', // URL to the route that checks email
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            email: function () {
                                return $('.emp_email').val(); // Get the email value
                            },
                            user_id: function () {
                                return $('.user_id').val(); // Get the user_id value (e.g., from a hidden input)
                            }
                        }
                    }
                },
                "emp_mobile_no[main]": {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                profile_image: {
                    profile_image: true,
                }
            },
            messages: {
                emp_name: {
                    required: "Employee name is required"
                },
                emp_email: {
                    required: "Employee email is required",
                    email: "Please enter a valid email address",
                    remote: "This email already exists"
                },
                "emp_mobile_no[main]": {
                    required: "The mobile number is required",
                    number: "Please enter a valid mobile number",
                    minlength: "The mobile number must be exactly 10 digits",
                    maxlength: "The mobile number must be exactly 10 digits"
                },
                profile_image: {
                    profile_image: "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) files are allowed.",
                }
            },
        });

        $('#passwordForm').validate({
            rules: {
                emp_password: {
                    required: true,
                },
                confirm_password: {
                    required: true,
                    equalTo: "#emp_password"
                },
            },
            messages: {
                emp_password: {
                    required: "The password is required",
                },
                confirm_password: {
                    required: "The confirm password is required",
                    equalTo: "The confirm password must match the password"
                },
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });


</script>

@endsection