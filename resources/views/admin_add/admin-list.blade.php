@extends('admin_layout.sidebar')
@section('content')
    <style>
        table.dataTable.no-footer {
            border-bottom: 0px solid #e6e5e8;
        }

        body.dark-mode table.dataTable.no-footer {
            border-bottom: 0px solid #474360;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            color: #fff !important;
        }

        label.error {
            display: block;
        }

        body.dark-mode select.add-role {
            background: #312d4b;
        }

        body.dark-mode select.team-head {
            background: #312d4b;
        }

        body.dark-mode select.add_emp_department_name {
            background: #312d4b;
        }

        .emp_document_preview_info {
            display: flex;
            flex-wrap: wrap;
        }

        .document-preview {
            width: 33.33%;
            padding: 0 7px;
        }

        .document-inner-container {
            position: relative;
        }

        a.btn.btn-sm.btn-outline-primary {
            position: absolute;
            top: 4px;
            right: 4px;
            padding: 0;
            margin: 0 !important;
            color: #8c57ff;
            background: #fff;
        }

        a.btn.btn-sm.btn-outline-danger.delete-doc {
            position: absolute;
            bottom: 4px;
            right: 4px;
            padding: 0;
            margin: 0;
            background: #fff0f0;
        }

        .img-thumbnail {
            height: 100px;
            width: 100px;
            object-fit: cover;
            background: #00000026;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 1px 0px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Admin List</h5>
                        </div>
                    </div>
                    <hr class="my-0">
                    <table class="datatables-basic table table-bordered dataTable no-footer dtr-column" id="example"
                        aria-describedby="DataTables_Table_0_info" style="width: 1395px;">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Name</th>
                                <th>Mobile No.</th>
                                <th>Email</th>
                                <th>Birthday Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emp_details as $item)
                                <tr>
                                    <td> {{ $loop->index + 1 }}</td>
                                    <td>{{ $item->emo_name }}</td>
                                    <td>{{ $item->emp_mobile_no }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ optional($item->emp_birthday_date) ? \Carbon\Carbon::parse($item->emp_birthday_date)->format('d-m-Y  ') : '' }}
                                    </td>
                                    <td>
                                        <a class="edit" href="#" data-id='{{ $item->id }}'
                                            data-emp_name='{{ $item->emo_name }}' data-emp_email='{{ $item->email }}'
                                            data-emp_mobile_no='{{ $item->emp_mobile_no }}'
                                            data-emp_address='{{ $item->emp_address }}'
                                            data-emp_father_mobile_no='{{ $item->emp_father_mobile_no }}'
                                            data-emp_mother_mobile_no='{{ $item->emp_mother_mobile_no }}'
                                            data-emp_brother_sister_mobile_no='{{ $item->emp_brother_sister_mobile_no }}'
                                            data-bank_name='{{ $item->bank_name }}' data-bank_no='{{ $item->bank_no }}'
                                            data-emp_department_name='{{ $item->emp_department_name }}'
                                            data-joining_date='{{ $item->joining_date }}'
                                            data-emp_document='{{ $item->emp_document }}'
                                            data-emp_bank_document='{{ $item->emp_bank_document }}'
                                            data-emp_birthday_date='{{ $item->emp_birthday_date }}'
                                            data-monthly_selery='{{ $item->monthly_selery }}'
                                            data-emp_notes='{{ $item->emp_notes }}'
                                            data-profile_image='{{ $item->profile_image }}'
                                            data-role='{{ $item->role }}'
                                            data-emp_team_head_id='{{ $item->emp_team_head_id }}'>
                                            <!-- <i class="fa fa-edit" style="font-size:24px;color:#36a50b"></i> -->
                                            <i class="ri-edit-box-line ri-22px list-btn"></i>
                                        </a>
                                        <a href="#" class="editpassword" data-id='{{ $item->id }}'
                                            data-emp_password='{{ $item->password }}'>
                                            <!-- <i class="fa fa-key" style="font-size:24px"></i> -->
                                            <i class="ri-key-2-line ri-22px list-btn"></i>
                                        </a>
                                        <a href="#" class="delete" data-id='{{ $item->id }}'>
                                            <!-- <i class="fa fa-trash-o" style="font-size:24px;color:red"></i> -->
                                            <i class="ri-delete-bin-7-line ri-22px list-btn"></i>
                                        </a>
                                        {{-- <i class="fa fa-lock" aria-hidden="true"></i> --}}
                                        @if ($item->is_lock == 0)
                                            <a href="#" class="lock" data-id='{{ $item->id }}'
                                                data-is_lock='{{ $item->is_lock }}'>
                                                <!-- <i class="fa fa-unlock-alt" style="font-size: 24px;color:#163048"></i> -->
                                                <i class="ri-lock-unlock-line ri-22px list-btn"></i>
                                            </a>
                                        @else
                                            <a href="#" class="lock" data-id='{{ $item->id }}'
                                                data-is_lock='{{ $item->is_lock }}'>
                                                <!-- <i class="fa fa-lock" style="font-size: 24px;color:#163048"></i> -->
                                                <i class="ri-git-repository-private-line ri-22px list-btn"></i>
                                            </a>
                                        @endif

                                        <a href="{{ route('admin.employee_view', $item->id) }}" class="view">
                                            <i class="ri-eye-line ri-22px list-btn"></i>
                                        </a>


                                        <!-- <a href="#" class="view">
                                                                                                                                                                                                                                                                                                                                                                                                <i class="fa fa-eye" style="font-size:24px;color:gray"></i>
                                                                                                                                                                                                                                                                                                                                                                                            </a> -->
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add modal -->
        <div class="offcanvas offcanvas-end" id="addEmployee" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="addEmployee">Add Employee</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="{{ route('admin.employee.store') }}" method="post" id="admin_form_store"
                    enctype="multipart/form-data"
                    class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework myForm">
                    @csrf
                    <!-- Full Name -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-user-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="add_emp_name" class="form-control" id="add_emp_name"
                                    placeholder="Enter Employee Name">
                                <label for="basicFullname">Full Name</label>
                            </div>
                        </div>
                        <label id="add_emp_name-error" class="error remove-error" for="add_emp_name"></label>
                    </div>

                    <!-- Email -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-mail-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="email" class="form-control emp_email" name="add_emp_email"
                                    id="add_emp_email" placeholder="Enter Employee Email">
                                <label for="basicFullname">Email</label>
                            </div>
                        </div>
                        <label id="add_emp_email-error" class="error remove-error" for="add_emp_email"></label>
                    </div>

                    <!-- Mobile Number -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-phone-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel" class="form-control" name="add_emp_mobile_no[main]"
                                    id="add_emp_mobile_no" placeholder="Enter Employee Mobile Number"
                                    oninput="this.value = this.value.replace(/\D+/g, '')">
                                <label for="basicFullname">Mobile Number</label>
                            </div>
                        </div>
                        <label id="add_emp_mobile_no-error" class="error remove-error" for="add_emp_mobile_no"></label>
                    </div>

                    <!-- Address -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-map-pin-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="add_emp_address" id="add_emp_address"
                                    placeholder="Enter Employee Address">
                                <label for="basicFullname">Address</label>
                            </div>
                        </div>
                        <label id="add_emp_address-error" class="error remove-error" for="add_emp_address"></label>
                    </div>

                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-phone-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel" class="form-control mobile" name="emp_father_mobile_no"
                                    placeholder="Enter Employee Father Mobile Number"
                                    oninput="this.value = this.value.replace(/\D+/g, '')">
                                <label for="basicFullname">Father Mobile Number </label>
                            </div>
                        </div>
                        <label id="emp_father_mobile_no-error" class="error remove-error" for="emp_father_mobile_no">
                        </label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-phone-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel" class="form-control mobile" name="emp_mother_mobile_no"
                                    placeholder="Enter Employee Mother Mobile Number"
                                    oninput="this.value = this.value.replace(/\D+/g, '')">
                                <label for="basicFullname">Mother Mobile Number </label>
                            </div>
                        </div>
                        <label id="emp_mother_mobile_no-error" class="error remove-error" for="emp_mother_mobile_no">
                        </label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-phone-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel" class="form-control mobile" name="emp_brother_sister_mobile_no"
                                    placeholder="Enter Employee Brother / Sister Mobile Number"
                                    oninput="this.value = this.value.replace(/\D+/g, '')">
                                <label for="basicFullname">Brother / Sister Mobile Number </label>
                            </div>
                        </div>
                        <label id="emp_brother_sister_mobile_no-error" class="error remove-error"
                            for="emp_brother_sister_mobile_no">
                        </label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-bank-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel" class="form-control mobile" name="bank_no"
                                    placeholder="Enter Bank Number "
                                    oninput="this.value = this.value.replace(/\D+/g, '')">
                                <label for="basicFullname">Bank Number </label>
                            </div>
                        </div>
                        <label id="bank_no-error" class="error remove-error" for="bank_no"> </label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-bank-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="bank_name"
                                    placeholder="Enter Bank Name">
                                <label for="basicFullname">Bank Name</label>
                            </div>
                        </div>
                        <label id="bank_name-error" class="error remove-error" for="bank_name"></label>
                    </div>

                    <!-- Department Name -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ri-building-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select class="form-control add_emp_department_name" name="add_emp_department_name"
                                    id="add_emp_department_name" style="color:#6D6777;">
                                    <option value="">Select Department Name</option>
                                    @foreach ($department_name as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="emp_department_name">Department Name</label>
                            </div>
                        </div>
                        <label id="add_emp_department_name-error" class="error remove-error"
                            for="add_emp_department_name"></label>
                    </div>

                    <!-- Joining Date -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-calendar-schedule-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" readonly class="form-control dob-picker" name="add_joining_date"
                                    id="add_joining_date" placeholder="">
                                <label for="basicFullname">Joining Date</label>
                            </div>
                        </div>
                        <label id="add_joining_date-error" class="error remove-error" for="add_joining_date"></label>
                    </div>

                    <!-- Empolyee Salary -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-money-rupee-circle-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel" class="form-control mobile" name="add_monthly_selery"
                                    placeholder="Enter Monthly Salary" id="add_monthly_selery"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                <label for="basicFullname">Monthly Salary</label>
                            </div>
                        </div>
                        <label id="add_monthly_selery-error" class="error remove-error" for="add_monthly_selery">
                        </label>
                    </div>

                    <!-- Uploade Employee -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"> <i class="ri-file-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="file" class="form-control" name="add_emp_document[]"
                                    id="add_emp_document" placeholder="" multiple>
                                <label for="basicFullname">Uplode Employee Document</label>
                            </div>
                        </div>
                        <label id="add_emp_document-error" class="error remove-error" for="add_emp_document"></label>
                    </div>
                    <!-- emp_bank_document Employee -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"> <i class="ri-file-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="file" class="form-control" name="add_emp_bank_document"
                                    id="add_emp_bank_document" placeholder="">
                                <label for="basicFullname">Uplode Employee Bank Document</label>
                            </div>
                        </div>
                        <label id="add_emp_bank_document-error" class="error remove-error"
                            for="add_emp_bank_document"></label>
                    </div>
                    <!--  Birthday Date Employee -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" readonly class="form-control dob-picker"
                                    name="add_emp_birthday_date" id="add_emp_birthday_date"
                                    placeholder="Enter Employee Birthday Date">
                                <label for="basicFullname">Birthday Date</label>
                            </div>
                        </div>
                        <label id="add_emp_birthday_date-error" class="error remove-error"
                            for="add_emp_birthday_date"></label>
                    </div>
                    <!-- emp_bank_document Employee -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-sticky-note-add-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="add_Notes" id="Notes"
                                    placeholder="">
                                <label for="basicFullname">Notes</label>
                            </div>
                        </div>
                    </div>
                    <!-- emp_bank_document Employee -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"> <i
                                    class="ri-lock-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="password" class="form-control" name="add_emp_password"
                                    id="add_emp_password" placeholder="············">
                                <label for="basicFullname">Password </label>
                            </div>
                        </div>
                        <label id="add_emp_password-error" class="error remove-error" for="add_emp_password"></label>
                    </div>
                    <!-- emp_bank_document Employee -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"> <i
                                    class="ri-lock-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="password" class="form-control" name="add_confirmed_emp_password"
                                    id="add_confirmed_emp_password" placeholder="············">
                                <label for="basicFullname">Confirm Password</label>
                            </div>
                        </div>
                        <label id="add_confirmed_emp_password-error" class="error remove-error"
                            for="add_confirmed_emp_password" style=""></label>
                    </div>
                    <!-- emp_bank_document Employee -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"> <i
                                    class="ri-file-upload-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="file" class="form-control" name="add_profile_image"
                                    id="add_profile_images" placeholder="············">
                                <label for="basicFullname">profile_image</label>
                            </div>
                        </div>
                        <label id="add_profile_images-error" class="error remove-error" for="add_profile_images"></label>
                    </div>
                    <!-- emp_bank_document Employee -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"> <i
                                    class="ri-user-settings-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select class="form-control add-role" name="add_role" id="add_role"
                                    style="color:#a0acb7">
                                    <option value="">Select Role</option>
                                    <option value="0">Admin</option>
                                    <option value="1">Team Head</option>
                                    <option value="2">Employee</option>
                                    <option value="3">HR</option>
                                </select>
                                <label for="basicFullname">Role</label>
                            </div>
                        </div>
                        <label id="add_role-error" class="error remove-error" for="add_role"></label>
                    </div>
                    <!-- emp_bank_document Employee -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"> <i
                                    class="ri-user-settings-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select class="form-control team-head" name="add_emp_team_head_id"
                                    id="add_emp_team_head_id" style="color:#a0acb7;">
                                    <option>Selete Team Head</option>
                                    @foreach ($team_head_name as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('emp_team_head_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->emo_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="basicFullname">Team Head Name</label>
                            </div>
                        </div>
                    </div>


                    <!-- Buttons -->
                    <div class="col-sm-12">
                        <button type="submit" class="btn data-submit me-sm-4 me-1 waves-effect waves-light"
                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;">Save</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!--  Edit modal -->
        <div class="offcanvas offcanvas-end" id="editEmployee" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="editEmployee">Employee Edit</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="" method="post" id="inquiry_form" enctype="multipart/form-data"
                    class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework myForm">
                    @csrf
                    <input type="hidden" id="emp_id" name="id">
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-user-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="emp_name" class="form-control" id="emp_name"
                                    placeholder="Enter Employee Name">
                                <label for="basicFullname">Full Name</label>
                            </div>
                        </div>
                        <label id="emp_name-error" class="error remove-error" for="emp_name"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-mail-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="email" class="form-control emp_email" name="emp_email" id="emp_email"
                                    placeholder="Enter Employee Email">
                                <label for="basicFullname">Email </label>
                            </div>
                        </div>
                        <label id="emp_email-error" class="error remove-error" for="emp_email"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-phone-line"></i></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel" class="form-control mobile" name="emp_mobile_no[main]"
                                    id="emp_mobile_no" placeholder="Enter Employee Mobile no"
                                    oninput="this.value = this.value.replace(/\D+/g, '')">
                                <label for="basicFullname">Mobile Number </label>
                            </div>
                        </div>
                        <label id="emp_mobile_no-error" class="error remove-error" for="emp_mobile_no"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-map-pin-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="emp_address" id="emp_address"
                                    placeholder="Enter Employee Address">
                                <label for="basicFullname">Address </label>
                            </div>
                        </div>
                        <label id="emp_address-error" class="error remove-error" for="emp_address"> </label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-phone-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel" class="form-control mobile" name="emp_father_mobile_no"
                                    id="emp_father_mobile_no" placeholder="Enter Employee Father Mobile Number"
                                    oninput="this.value = this.value.replace(/\D+/g, '')">
                                <label for="basicFullname">Father Mobile Number </label>
                            </div>
                        </div>
                        <label id="emp_father_mobile_no-error" class="error remove-error" for="emp_father_mobile_no">
                        </label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-phone-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel" class="form-control mobile" name="emp_mother_mobile_no"
                                    id="emp_mother_mobile_no" placeholder="Enter Employee Mother Mobile Number"
                                    oninput="this.value = this.value.replace(/\D+/g, '')">
                                <label for="basicFullname">Mother Mobile Number </label>
                            </div>
                        </div>
                        <label id="emp_mother_mobile_no-error" class="error remove-error" for="emp_mother_mobile_no">
                        </label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-phone-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel" class="form-control mobile" name="emp_brother_sister_mobile_no"
                                    id="emp_brother_sister_mobile_no"
                                    placeholder="Enter Employee Brother / Sister Mobile Number"
                                    oninput="this.value = this.value.replace(/\D+/g, '')">
                                <label for="basicFullname">Brother / Sister Mobile Number </label>
                            </div>
                        </div>
                        <label id="emp_brother_sister_mobile_no-error" class="error remove-error"
                            for="emp_brother_sister_mobile_no">
                        </label>
                    </div>

                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-bank-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel" class="form-control mobile" name="bank_no"
                                    placeholder="Enter Bank Number " id="bank_no"
                                    oninput="this.value = this.value.replace(/\D+/g, '')">
                                <label for="basicFullname">Bank Number </label>
                            </div>
                        </div>
                        <label id="bank_no-error" class="error remove-error" for="bank_no"> </label>
                    </div>

                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-bank-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="bank_name" id="bank_name"
                                    placeholder="Enter Bank Name">
                                <label for="basicFullname">Bank Name</label>
                            </div>
                        </div>
                        <label id="bank_name-error" class="error remove-error" for="bank_name"></label>
                    </div>

                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ri-building-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select class="form-control add_emp_department_name" name="emp_department_name"
                                    id="emp_department_name">
                                    <option value="">Select Department Name</option>
                                    @foreach ($department_name as $item)
                                        <option value="{{ $item->id }}"
                                            @if (isset($data->emp_department_name) && $data->emp_department_name == $item->id) selected @endif>
                                            {{ $item->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="basicFullname">Department Name </label>
                            </div>
                        </div>
                        <label id="emp_department_name-error" class="error remove-error"
                            for="emp_department_name"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" readonly class="form-control dob-picker" name="joining_date"
                                    id="joining_date" placeholder="">
                                <label for="basicFullname">Joining Date </label>
                            </div>
                        </div>
                        <label id="joining_date-error" class="error remove-error" for="joining_date"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-money-rupee-circle-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel" class="form-control mobile" name="monthly_selery"
                                    id="monthly_selery" placeholder="Enter Employee Monthly Salary"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                <label for="basicFullname">Monthly Salary</label>
                            </div>
                        </div>
                        <label id="monthly_selery-error" class="error remove-error" for="monthly_selery"> </label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-file-line"></i></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="file" class="form-control" name="emp_document[]" id="emp_document"
                                    multiple>
                                <label for="basicFullname">Upload Employee Documents</label>
                            </div>
                        </div>
                        <label id="emp_document-error" class="error remove-error" for="emp_document"></label>
                        <!-- Multiple Image display area -->
                        <div class="emp_document_preview_info mt-3" style="cursor: pointer;" id="emp_document_preview">
                        </div>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-file-line"></i></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="file" class="form-control" name="emp_bank_document"
                                    id="emp_bank_document">
                                <label for="basicFullname">Uplode Employee Bank Document</label>
                            </div>
                        </div>
                        <label id="emp_bank_document-error" class="error remove-error" for="emp_bank_document"></label>
                        <!-- Multiple Image display area -->
                        <div class="mt-3" style="cursor: pointer;" id="emp_bank_document_preview"></div>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" readonly class="form-control dob-picker" name="emp_birthday_date"
                                    id="emp_birthday_date" placeholder="Enter Employee Birthday Date">
                                <label for="basicFullname">Birthday Date </label>
                            </div>
                        </div>
                        <label id="emp_birthday_date-error" class="error remove-error" for="emp_birthday_date"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-sticky-note-add-line"></i></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="notes" id="notes"
                                    placeholder="Enter Employee Notes">
                                <label for="basicFullname">Notes </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-image-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="file" class="form-control" name="profile_image" id="profile_image" />
                                <label for="basicFullname">Profile Picture </label>
                            </div>
                        </div>
                        <label id="profile_image-error" class="error remove-error" for="profile_image"></label>
                        <div class="mt-3" style="cursor: pointer;" id="profile_image_preview"></div>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ri-user-settings-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select class="form-control add-role" name="role" id="role"
                                    style="color:#a0acb7">
                                    <option value="">Select Role</option>
                                    <option value="0">Admin</option>
                                    <option value="1">Team Head</option>
                                    <option value="2">Employee</option>
                                    <option value="3">HR</option>
                                </select>
                                <label for="basicFullname">Role</label>
                            </div>
                        </div>
                        <label id="role-error" class="error remove-error" for="role"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ri-user-settings-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select class="form-control team-head" name="emp_team_head_id" id="emp_team_head_id"
                                    style="color:#a0acb7;">
                                    <option value="">Select Team Head Name</option>
                                    @foreach ($team_head_name as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->emo_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="basicFullname">Team Head Name</label>
                            </div>
                        </div>
                        <label id="emp_team_head_id-error" class="error remove-error" for="emp_team_head_id"></label>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn data-submit me-sm-4 me-1 waves-effect waves-light"
                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;">Update</button>

                        <button type="reset" class="btn btn-outline-secondary waves-effect"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Image Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="" alt="Image Preview" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for displaying PDF -->
        <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pdfModalLabel">Document Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <iframe id="pdfPreview" src="" width="100%" height="500px"
                            style="border:none;"></iframe>
                    </div>
                </div>
            </div>
        </div>


        <!-- Delete Confirmation Modal (Offcanvas) -->
        <div class="offcanvas offcanvas-end" id="deletemodal" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="deletemodal">Delete Employee</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <h5 class="text-center">Are you sure you want to delete Employee?</h5>
                <div class="col-sm-12">
                    <button type="submit" id="deletemember" class="btn btn-danger waves-effect waves-light"
                        style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;">Delete</button>
                    <button type="reset" class="btn btn-outline-secondary waves-effect"
                        data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </div>
        </div>

        <!--  Password modal -->
        <div class="offcanvas offcanvas-end" id="passwordeditmodal" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="passwordeditmodal">Change Password</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="{{ route('admin.EmployeeChangePassowed') }}" method="post" id="passwordForm"
                    enctype="multipart/form-data"
                    class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-user-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="password" class="form-control dt-full-name" name="emp_password"
                                    id="emp_password" placeholder="Enter password"
                                    aria-describedby="basic-default-password2" required />
                                <label for="basicFullname">Password</label>
                            </div>
                        </div>
                        <label id="emp_password-error" class="error" for="emp_password"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-user-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="password" class="form-control dt-full-name" name="confirm_password"
                                    id="confirm_password" placeholder="Enter confirm password"
                                    aria-describedby="basic-default-password2" required />
                                <label for="basicFullname">Confirm Password </label>
                            </div>
                        </div>
                        <label id="confirm_password-error" class="error" for="confirm_password"></label>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn data-submit me-sm-4 me-1 waves-effect waves-light"
                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;">Update</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!--  Lock modal -->
        <div class="offcanvas offcanvas-end" id="lockemodal" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="lockemodal">Lock Employee</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <h5 class="text-center">Are you sure you want to Lock Employee?</h5>
                <div class="col-sm-12">
                    <button id="lockemember" class="btn btn-danger waves-effect waves-light"
                        style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;">YES</button>
                    <button type="reset" class="btn btn-outline-secondary waves-effect"
                        data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </div>
        </div>

        <!--  Unlock modal -->
        <div class="offcanvas offcanvas-end" id="unlockemodal" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="unlockemodal">Un-Lock Employee</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <h5 class="text-center">Are you sure you want to Un-Lock Employee?</h5>
                <div class="col-sm-12">
                    <button id="unlockemember" class="btn btn-danger waves-effect waves-light"
                        style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;">YES</button>
                    <button type="reset" class="btn btn-outline-secondary waves-effect"
                        data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.add_recode', function(event) {
                event.preventDefault();
                const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('addEmployee'));
                offcanvasEdit.show();

                // Custom validation methods
                $.validator.addMethod("emp_document", function(value, element) {
                        if (element.files && element.files.length > 0) {
                            let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp|\.pdf)$/i;
                            return allowedTypes.test(element.files[0].name);
                        }
                        return true;
                    },
                    "Only image files (jpg, jpeg, png, svg, gif, jfif, webp) and PDF files are allowed."
                );

                $.validator.addMethod("emp_bank_document", function(value, element) {
                    if (element.files && element.files.length > 0) {
                        let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp)$/i;
                        return allowedTypes.test(element.files[0].name);
                    }
                    return true;
                }, "Only image files (jpg, jpeg, png, svg, gif, jfif, webp) files are allowed.");

                $.validator.addMethod("profile_image", function(value, element) {
                    if (element.files && element.files.length > 0) {
                        let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp)$/i;
                        return allowedTypes.test(element.files[0].name);
                    }
                    return true;
                }, "Only image files (jpg, jpeg, png, svg, gif, jfif, webp) files are allowed.");

                // Initialize validation plugin
                $('.myForm').validate({
                    rules: {
                        add_emp_name: {
                            required: true
                        },
                        add_emp_email: {
                            required: true,
                            email: true,
                            remote: {
                                url: '{{ route('admin.checkEmail') }}', // Route for checking email uniqueness
                                type: "POST",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    email: function() {
                                        return $('.emp_email').val();
                                    }
                                }
                            }
                        },
                        "add_emp_mobile_no[main]": {
                            required: true,
                            number: true,
                            minlength: 10,
                            maxlength: 10
                        },
                        add_emp_address: {
                            required: true
                        },
                        emp_father_mobile_no: {
                            required: true,
                            number: true,
                            minlength: 10,
                            maxlength: 10
                        },
                        emp_mother_mobile_no: {
                            required: true,
                            number: true,
                            minlength: 10,
                            maxlength: 10
                        },
                        bank_no: {
                            required: true,
                            number: true,
                        },
                        bank_name: {
                            required: true,
                        },
                        add_emp_department_name: {
                            required: true
                        },
                        add_joining_date: {
                            required: true
                        },
                        add_monthly_selery: {
                            required: true
                        },
                        add_emp_birthday_date: {
                            required: true
                        },
                        add_emp_password: {
                            required: true
                        },
                        add_confirmed_emp_password: {
                            required: true,
                            equalTo: "#add_emp_password"
                        },
                        add_role: {
                            required: true
                        },
                        "add_emp_document[]": {
                            emp_document: true
                        },
                        add_emp_bank_document: {
                            emp_bank_document: true
                        },
                        add_profile_image: {
                            profile_image: true
                        },
                        add_emp_team_head_id: {
                            required: function() {
                                return $('#add_role').val() ===
                                    '2'; // Make Team Head required for Employees
                            }
                        }
                    },
                    messages: {
                        add_emp_name: {
                            required: "Employee name is required"
                        },
                        add_emp_email: {
                            required: "Employee email is required",
                            email: "Please enter a valid email address",
                            remote: "This email already exists"
                        },
                        "add_emp_mobile_no[main]": {
                            required: "The mobile number is required",
                            number: "Please enter a valid mobile number",
                            minlength: "The mobile number must be exactly 10 digits",
                            maxlength: "The mobile number must be exactly 10 digits"
                        },
                        add_emp_address: {
                            required: "Employee address is required"
                        },
                        emp_father_mobile_no: {
                            required: "The mobile number is required",
                            number: "Please enter a valid mobile number",
                            minlength: "The mobile number must be exactly 10 digits",
                            maxlength: "The mobile number must be exactly 10 digits"
                        },
                        emp_mother_mobile_no: {
                            required: "The mobile number is required",
                            number: "Please enter a valid mobile number",
                            minlength: "The mobile number must be exactly 10 digits",
                            maxlength: "The mobile number must be exactly 10 digits"
                        },
                        bank_no: {
                            required: "The bank number is required",
                            number: "Please enter a valid bank number",
                        },
                        bank_name: {
                            required: "The bank name is required",
                        },
                        add_emp_department_name: {
                            required: "Employee department name is required"
                        },
                        add_joining_date: {
                            required: "Employee joining date is required"
                        },
                        add_monthly_selery: {
                            required: "Employee monthly salary is required"
                        },
                        add_emp_birthday_date: {
                            required: "Employee birthday date is required"
                        },
                        add_emp_password: {
                            required: "The password is required"
                        },
                        add_confirmed_emp_password: {
                            required: "The confirm password is required",
                            equalTo: "The confirm password must match the password"
                        },
                        add_role: {
                            required: "Employee role is required"
                        },
                        "add_emp_document[]": {
                            emp_document: "Only image files (jpg, jpeg, png, svg, gif, jfif, webp) and PDF files are allowed."
                        },
                        add_emp_bank_document: {
                            emp_bank_document: "Only image files (jpg, jpeg, png, svg, gif, jfif, webp) files are allowed."
                        },
                        add_profile_image: {
                            profile_image: "Only image files (jpg, jpeg, png, svg, gif, jfif, webp) files are allowed."
                        },
                        add_emp_team_head_id: {
                            required: "Team Head is required for Employees"
                        }
                    },
                    errorPlacement: function(error, element) {
                        if (element.hasClass('add_emp_department_name') || element.hasClass(
                                'add-role')) {
                            error.insertAfter(
                                element);
                        } else {
                            error.insertAfter(
                                element);
                        }
                    },
                    highlight: function(element, errorClass, validClass) {
                        if (!$(element).hasClass('add_emp_department_name') && !$(element)
                            .hasClass('add-role')) {
                            $(element).addClass(errorClass).removeClass(validClass);
                        }
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        if (!$(element).hasClass('add_emp_department_name') && !$(element)
                            .hasClass('add-role')) {
                            $(element).removeClass(errorClass).addClass(validClass);
                        }
                    },
                    // Submit handler
                    submitHandler: function(form) {
                        form.submit();
                    }
                });

                // Revalidate Team Head dynamically when Role changes
                $('#add_role').on('change', function() {
                    $('#add_emp_team_head_id').rules('add', {
                        required: $('#add_role').val() === '2',
                        messages: {
                            required: "Team Head is required for Employees"
                        }
                    });
                    $('.myForm').validate().element('#add_emp_team_head_id'); // Force re-validation
                });
            });
        });

        $(document).ready(function() {

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
                submitHandler: function(form) {
                    form.submit();
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function formatDate(date) {
                var d = new Date(date);
                var day = ("0" + d.getDate()).slice(-2); // Ensures two digits
                var month = ("0" + (d.getMonth() + 1)).slice(-2); // Months are zero-indexed
                var year = d.getFullYear();

                return day + '-' + month + '-' + year;
            }
            $(document).on('click', '.edit', function(event) {
                event.preventDefault();

                // Fetching data attributes
                var id = $(this).data('id');
                var emp_name = $(this).data('emp_name');
                var emp_email = $(this).data('emp_email');
                var emp_mobile_no = $(this).data('emp_mobile_no');
                var emp_address = $(this).data('emp_address');
                var emp_father_mobile_no = $(this).data('emp_father_mobile_no');
                var emp_mother_mobile_no = $(this).data('emp_mother_mobile_no');
                var emp_brother_sister_mobile_no = $(this).data('emp_brother_sister_mobile_no');
                var bank_no = $(this).data('bank_no');
                var bank_name = $(this).data('bank_name');
                var emp_department_name = $(this).data('emp_department_name');
                var joining_date = $(this).data('joining_date');
                var monthly_selery = $(this).data('monthly_selery');
                var emp_documents = $(this).data('emp_document');
                var emp_bank_document = $(this).data('emp_bank_document');
                var emp_birthday_date = $(this).data('emp_birthday_date');
                var emp_notes = $(this).data('emp_notes');
                var profile_image = $(this).data('profile_image');
                var role = $(this).data('role');
                var emp_team_head_id = $(this).data('emp_team_head_id');

                // Showing the offcanvas
                const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('editEmployee'));
                offcanvasEdit.show();

                var formattedJoiningDate = formatDate(joining_date);
                var formattedBirthdayDate = formatDate(emp_birthday_date);

                // Setting values to the form fields
                $('#emp_name').val(emp_name);
                $('#emp_email').val(emp_email);
                $('#emp_mobile_no').val(emp_mobile_no);
                $('#emp_address').val(emp_address);
                $('#emp_father_mobile_no').val(emp_father_mobile_no);
                $('#emp_mother_mobile_no').val(emp_mother_mobile_no);
                $('#emp_brother_sister_mobile_no').val(emp_brother_sister_mobile_no);
                $('#bank_no').val(bank_no);
                $('#bank_name').val(bank_name);
                // $('#joining_date').val(joining_date);
                $('#monthly_selery').val(monthly_selery);
                // $('#emp_birthday_date').val(emp_birthday_date);
                $('#joining_date').val(formattedJoiningDate);
                $('#emp_birthday_date').val(formattedBirthdayDate);
                $('#notes').val(emp_notes);
                $('#emp_id').val(id);

                // Setting the department dropdown value and triggering change for select2 (if used)
                $('#emp_department_name').val(emp_department_name).trigger('change');
                $('#role').val(role).trigger('change');
                $('#emp_team_head_id').val(emp_team_head_id).trigger('change');


                // Display multiple images or PDF icons
                if (emp_documents) {
                    var documents = emp_documents.split(','); // Split the comma-separated document URLs

                    // Clear previous previews
                    $('#emp_document_preview').empty();

                    // Loop through each document URL and display the image or icon
                    documents.forEach(function(document) {
                        var fileExt = document.split('.').pop().toLowerCase(); // Get file extension
                        var filePath = '{{ asset('emp_document/') }}' + '/' + document;
                        var pdfParth = '{{ asset('assets/img/pdf.png') }}';

                        // Check if the file exists using an AJAX HEAD request
                        $.ajax({
                            url: filePath,
                            type: 'HEAD',
                            success: function() {
                                // Create a container div for each document
                                var docContainer = $('<div>').addClass(
                                    'document-preview d-inline-block mb-3');

                                // Create an inner container div for image and buttons
                                var innerContainer = $('<div>').addClass(
                                    'document-inner-container');

                                if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']
                                    .includes(fileExt)) {
                                    // Display Image
                                    var imgElement = $('<img>').attr('src', filePath)
                                        .addClass('img-thumbnail preview-img')
                                        .css('max-width', '100px')
                                    innerContainer.append(
                                        imgElement
                                    ); // Append image to the inner container
                                } else if (fileExt === 'pdf') {
                                    // Display PDF Icon
                                    var pdfIcon = $('<img>')
                                        .attr('src', pdfParth)
                                        .addClass('preview-pdf img-thumbnail')
                                        .attr('data-pdf-url', filePath)
                                        .css('max-width', '100px')
                                    innerContainer.append(
                                        pdfIcon
                                    ); // Append PDF icon to the inner container
                                }

                                // Add a download button for each document
                                var downloadBtn = $('<a>').attr('href', filePath)
                                    .attr('download', document)
                                    .addClass('btn btn-sm btn-outline-primary')
                                    .css('margin-top', '5px')
                                    .html(
                                        '<i class="ri-download-cloud-line"></i>'
                                    ); // Add the download icon
                                innerContainer.append(
                                    downloadBtn
                                ); // Append download button to the inner container

                                // Add a delete button for each document
                                var deleteBtn = $('<a>')
                                    .attr('href', '#')
                                    .addClass(
                                        'btn btn-sm btn-outline-danger delete-doc')
                                    .data('document',
                                        document) // Store the full document filename
                                    .css('margin-top', '5px')
                                    .html(
                                        '<i class="ri-delete-bin-6-line delete-btn"></i>'
                                    );
                                innerContainer.append(
                                    deleteBtn
                                ); // Append delete button to the inner container

                                // Append the inner container (which includes the image and buttons) to the document container
                                docContainer.append(innerContainer);

                                // Append the document container to the preview area
                                $('#emp_document_preview').append(docContainer);

                                // Bind click event to delete button
                                deleteBtn.on('click', function(e) {
                                    e
                                        .preventDefault(); // Prevent default anchor behavior

                                    var documentName = $(this).data(
                                        'document'
                                    ); // Get the document filename

                                    // Confirm with the user
                                    if (!confirm(
                                            'Are you sure you want to delete this document?'
                                        )) {
                                        return;
                                    }

                                    // Send AJAX request to delete the document from the server
                                    $.ajax({
                                        url: '{{ route('admin.delete-emp-document') }}', // Backend route for deleting the document
                                        type: 'DELETE',
                                        data: {
                                            _token: '{{ csrf_token() }}', // CSRF token for security
                                            document: documentName, // Pass the document filename
                                            user_id: id // Pass the user ID
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                location
                                                    .reload(); // Reload the page after successful deletion
                                            } else {
                                                alert(
                                                    'Error deleting document'
                                                );
                                            }
                                        },
                                        error: function() {
                                            alert(
                                                'An error occurred while deleting the document.'
                                            );
                                        }
                                    });
                                });
                            },
                            error: function() {
                                $('#emp_document_preview')
                                    .empty(); // Empty preview if the file doesn't exist
                            }
                        });
                    });

                    $('#emp_document_preview').show(); // Show the preview area
                } else {
                    $('#emp_document_preview').empty(); // Clear preview if no documents
                }



                // Display the bank document image if it exists
                if (emp_bank_document) {
                    var bankFileExt = emp_bank_document.split('.').pop()
                        .toLowerCase(); // Get file extension
                    var bankFilePath = '{{ asset('emp_bank_document/') }}' + '/' + emp_bank_document;
                    var pdfPath =
                        '{{ asset('assets/img/pdf.png') }}'; // PDF icon path (if you want a placeholder for PDFs)

                    // Clear previous bank document preview
                    $('#emp_bank_document_preview').empty();

                    // Check if the file exists using an AJAX HEAD request
                    $.ajax({
                        url: bankFilePath,
                        type: 'HEAD',
                        success: function() {
                            // File exists, proceed to display the bank document
                            var docContainer = $('<div>').addClass(
                                'document-preview d-inline-block mb-3');

                            // Create an inner container for the image/icon and buttons
                            var innerContainer = $('<div>').addClass(
                                'document-inner-container');

                            if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'].includes(
                                    bankFileExt)) {
                                // Display Image for bank document
                                var bankImgElement = $('<img>').attr('src', bankFilePath)
                                    .addClass('img-thumbnail preview-img')
                                    .css('max-width', '100px')
                                    .css('margin-right', '10px');
                                innerContainer.append(
                                    bankImgElement); // Append image to inner container
                            } else if (bankFileExt === 'pdf') {
                                // Display PDF Icon (image as a placeholder for PDF documents)
                                var pdfIcon = $('<img>')
                                    .attr('src', pdfPath)
                                    .addClass('preview-pdf')
                                    .attr('data-pdf-url', bankFilePath)
                                    .css('max-width', '100px')
                                    .css('margin-right', '10px');
                                innerContainer.append(
                                    pdfIcon); // Append PDF icon to inner container
                            }

                            // Add a download button for the bank document
                            var downloadBtn = $('<a>').attr('href', bankFilePath)
                                .attr('download', emp_bank_document)
                                .addClass('btn btn-sm btn-outline-primary')
                                .css('margin-top', '5px')
                                .html(
                                    '<i class="ri-download-cloud-line"></i>'
                                ); // Add the download icon
                            innerContainer.append(
                                downloadBtn); // Append download button to inner container

                            // Add a delete button for the bank document
                            var deleteBtn = $('<a>')
                                .attr('href', '#')
                                .addClass('btn btn-sm btn-outline-danger delete-doc')
                                .data('document',
                                    emp_bank_document) // Store the full document filename
                                .css('margin-top', '5px')
                                .html('<i class="ri-delete-bin-6-line delete-btn"></i>');
                            innerContainer.append(
                                deleteBtn); // Append delete button to inner container

                            // Append the inner container to the document container
                            docContainer.append(innerContainer);

                            // Append the document container to the preview area
                            $('#emp_bank_document_preview').append(docContainer);

                            // Bind click event to delete button
                            deleteBtn.on('click', function(e) {
                                e.preventDefault(); // Prevent default anchor behavior

                                var documentName = $(this).data(
                                    'document'); // Get the document filename

                                // Confirm with the user
                                if (!confirm(
                                        'Are you sure you want to delete this document?'
                                    )) {
                                    return;
                                }

                                // Send AJAX request to delete the bank document from the server
                                $.ajax({
                                    url: '{{ route('admin.delete.emp.bank.document') }}', // Backend route for deleting the document
                                    type: 'DELETE',
                                    data: {
                                        _token: '{{ csrf_token() }}', // CSRF token for security
                                        document: documentName, // Pass the document filename
                                        user_id: id // Pass the user ID
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            // If deletion is successful, remove the preview from the UI
                                            $('#emp_bank_document_preview')
                                                .empty(); // Remove the document preview container
                                        } else {
                                            alert(
                                                'Error deleting document'
                                            );
                                        }
                                    },
                                    error: function() {
                                        alert(
                                            'An error occurred while deleting the document.'
                                        );
                                    }
                                });
                            });

                            $('#emp_bank_document_preview')
                                .show(); // Show bank document preview
                        },
                        error: function() {
                            // File does not exist, show a placeholder or skip displaying this document
                            $('#emp_bank_document_preview')
                                .empty(); // Remove the preview container
                        }
                    });
                } else {
                    $('#emp_bank_document_preview').hide(); // Hide preview if no bank document
                }

                // Display the Profile image if it exists
                if (profile_image) {
                    var profileFileExt = profile_image.split('.').pop().toLowerCase(); // Get file extension
                    var profileFilePath = '{{ asset('profile_image/') }}' + '/' + profile_image;
                    var pdfPath = '{{ asset('assets/img/pdf.png') }}'; // Path to the PDF icon if needed

                    // Clear previous profile image preview
                    $('#profile_image_preview').empty();

                    // Check if the file exists using an AJAX HEAD request
                    $.ajax({
                        url: profileFilePath,
                        type: 'HEAD',
                        success: function() {
                            // File exists, proceed to display the profile image
                            var docContainer = $('<div>').addClass(
                                'document-preview d-inline-block mb-3');

                            // Create an inner container for the image/icon and buttons
                            var innerContainer = $('<div>').addClass(
                                'document-inner-container');

                            if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'].includes(
                                    profileFileExt)) {
                                // Display Image for profile image
                                var profileImgElement = $('<img>').attr('src', profileFilePath)
                                    .addClass('img-thumbnail preview-img')
                                    .css('max-width', '100px')
                                    .css('margin-right', '10px');
                                innerContainer.append(
                                    profileImgElement); // Append image to inner container
                            } else {
                                // Display PDF Icon or any other placeholder (you can adjust this logic as needed)
                                var pdfIcon = $('<img>')
                                    .attr('src', pdfPath)
                                    .addClass('preview-pdf')
                                    .attr('data-pdf-url', profileFilePath)
                                    .css('max-width', '100px')
                                    .css('margin-right', '10px');
                                innerContainer.append(
                                    pdfIcon); // Append PDF icon to inner container
                            }

                            // Add a download button for the profile image
                            var downloadBtn = $('<a>').attr('href', profileFilePath)
                                .attr('download', profile_image)
                                .addClass('btn btn-sm btn-outline-primary')
                                .css('margin-top', '5px')
                                .html(
                                    '<i class="ri-download-cloud-line"></i>'
                                    ); // Add the download icon
                            innerContainer.append(
                                downloadBtn); // Append download button to inner container

                            // Add a delete button for the profile image
                            var deleteBtn = $('<a>')
                                .attr('href', '#')
                                .addClass('btn btn-sm btn-outline-danger delete-doc')
                                .data('document',
                                    profile_image) // Store the full document filename
                                .css('margin-top', '5px')
                                .html('<i class="ri-delete-bin-6-line delete-btn"></i>');
                            innerContainer.append(
                                deleteBtn); // Append delete button to inner container

                            // Append the inner container to the document container
                            docContainer.append(innerContainer);

                            // Append the document container to the preview area
                            $('#profile_image_preview').append(docContainer);

                            // Bind click event to delete button
                            deleteBtn.on('click', function(e) {
                                e.preventDefault(); // Prevent default anchor behavior

                                var documentName = $(this).data(
                                    'document'); // Get the document filename

                                // Confirm with the user
                                if (!confirm(
                                        'Are you sure you want to delete this image?'
                                    )) {
                                    return;
                                }

                                // Send AJAX request to delete the profile image from the server
                                $.ajax({
                                    url: '{{ route('admin.delete.emp.profile.document') }}', // Backend route for deleting the document
                                    type: 'DELETE',
                                    data: {
                                        _token: '{{ csrf_token() }}', // CSRF token for security
                                        document: documentName, // Pass the document filename
                                        user_id: id // Pass the user ID
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            // If deletion is successful, remove the preview from the UI
                                            $('#profile_image_preview')
                                                .empty(); // Remove the document preview container
                                        } else {
                                            alert('Error deleting image');
                                        }
                                    },
                                    error: function() {
                                        alert(
                                            'An error occurred while deleting the image.'
                                            );
                                    }
                                });
                            });

                            $('#profile_image_preview').show(); // Show profile image preview
                        },
                        error: function() {
                            // File does not exist, show a placeholder or message
                            $('#profile_image_preview').empty(); // Remove preview container
                        }
                    });
                } else {
                    $('#profile_image_preview').hide(); // Hide preview if no profile image
                }

                $.validator.addMethod("emp_document", function(value, element) {
                        if (element.files && element.files.length > 0) {
                            let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp|\.pdf)$/i;
                            return allowedTypes.test(element.files[0].name);
                        }
                        return true;
                    },
                    "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) and PDF files are allowed.");

                $.validator.addMethod("emp_bank_document", function(value, element) {
                    if (element.files && element.files.length > 0) {
                        let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp)$/i;
                        return allowedTypes.test(element.files[0].name);
                    }
                    return true;
                }, "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) files are allowed.");

                $.validator.addMethod("profile_image", function(value, element) {
                    if (element.files && element.files.length > 0) {
                        let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp)$/i;
                        return allowedTypes.test(element.files[0].name);
                    }
                    return true;
                }, "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) files are allowed.");

                $('#inquiry_form').validate({
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
                                    email: function() {
                                        return $('.emp_email').val(); // Get the email value
                                    },
                                    user_id: function() {
                                        return $('#emp_id')
                                            .val(); // Get the user_id value (e.g., from a hidden input)
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
                        emp_address: {
                            required: true
                        },
                        emp_father_mobile_no: {
                            required: true,
                            number: true,
                            minlength: 10,
                            maxlength: 10
                        },
                        emp_mother_mobile_no: {
                            required: true,
                            number: true,
                            minlength: 10,
                            maxlength: 10
                        },
                        bank_no: {
                            required: true,
                            number: true,
                        },
                        bank_name: {
                            required: true,
                        },
                        emp_department_name: {
                            required: true
                        },
                        joining_date: {
                            required: true
                        },
                        monthly_selery: {
                            required: true
                        },
                        emp_birthday_date: {
                            required: true
                        },
                        role: {
                            required: true
                        },
                        "emp_document[]": {
                            emp_document: true, // Custom validation for file types
                        },
                        emp_bank_document: {
                            emp_bank_document: true,
                        },
                        profile_image: {
                            profile_image: true,
                        },
                        emp_team_head_id: {
                            // Default validation rules for emp_team_head_id
                            required: function() {
                                // Check if the role is Employee (role == 2)
                                return $('#role').val() == '2'; // Only required if role is 2
                            }
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
                        emp_address: {
                            required: "Employee adress is required"
                        },
                        emp_father_mobile_no: {
                            required: "The mobile number is required",
                            number: "Please enter a valid mobile number",
                            minlength: "The mobile number must be exactly 10 digits",
                            maxlength: "The mobile number must be exactly 10 digits"
                        },
                        emp_mother_mobile_no: {
                            required: "The mobile number is required",
                            number: "Please enter a valid mobile number",
                            minlength: "The mobile number must be exactly 10 digits",
                            maxlength: "The mobile number must be exactly 10 digits"
                        },
                        bank_no: {
                            required: "The bank number is required",
                            number: "Please enter a valid bank number",
                        },
                        bank_name: {
                            required: "The bank name is required",
                        },
                        emp_department_name: {
                            required: "Employee department name is required"
                        },
                        joining_date: {
                            required: "Employee joining date is required"
                        },
                        monthly_selery: {
                            required: "Employee monthly salary is required"
                        },
                        emp_birthday_date: {
                            required: "Employee birthday date is required"
                        },
                        role: {
                            required: "Employee role is required"
                        },
                        "emp_document[]": {
                            emp_document: "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) and PDF files are allowed.",
                        },
                        emp_bank_document: {
                            emp_bank_document: "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) files are allowed.",
                        },
                        profile_image: {
                            profile_image: "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) files are allowed.",
                        },
                        emp_team_head_id: {
                            required: "Employee team head name is required"
                        }
                    },
                    errorPlacement: function(error, element) {
                        if (element.hasClass('add_emp_department_name') || element.hasClass(
                                'add-role') || element.hasClass('team-head')) {
                            error.insertAfter(
                                element);
                        } else {
                            error.insertAfter(
                                element);
                        }
                    },
                    highlight: function(element, errorClass, validClass) {
                        if (!$(element).hasClass('add_emp_department_name') && !$(element)
                            .hasClass('add-role') && !$(element).hasClass('team-head')) {
                            $(element).addClass(errorClass).removeClass(validClass);
                        }
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        if (!$(element).hasClass('add_emp_department_name') && !$(element)
                            .hasClass('add-role') && !$(element).hasClass('team-head')) {
                            $(element).removeClass(errorClass).addClass(validClass);
                        }
                    },
                    // Submit handler
                    submitHandler: function(form) {
                        // Send the AJAX request to update the employee data
                        $.ajax({
                            url: '{{ route('admin.employee.update') }}', // Named route for update
                            type: 'POST',
                            data: new FormData(
                                form), // Include form data, including file inputs
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content') // CSRF token
                            },
                            success: function(response) {
                                console.log(response); // Log success
                                location
                                    .reload(); // Reload the page after successful update
                            },
                            error: function(xhr, status, error) {
                                console.log(error); // Log any errors
                                // Optionally show an error message to the user
                            }
                        });
                    }
                });
            });

            // Handling image click to open in modal
            $(document).on('click', '.preview-img', function() {
                var imgSrc = $(this).attr('src');
                $('#imageModal img').attr('src', imgSrc); // Set the image in the modal
                $('#imageModal').modal('show'); // Show the modal
            });

            // Handling PDF icon click to open PDF in modal
            $(document).on('click', '.preview-pdf', function() {
                var pdfUrl = $(this).data('pdf-url'); // Get the PDF URL from the data attribute

                // Set the PDF URL to the iframe
                $('#pdfPreview').attr('src', pdfUrl);

                // Show the modal
                $('#pdfModal').modal('show');
            });

            $(document).on('click', '.editpassword', function(event) {
                event.preventDefault();
                var id = $(this).data('id');
                var password = $(this).data('emp_password');
                const offcanvasDelete = new bootstrap.Offcanvas(document.getElementById(
                    'passwordeditmodal'));
                offcanvasDelete.show();
                // $('#passwordeditmodal').modal('show');
                $('#id').val(id);
            });

            $(document).on('click', '.delete', function(event) {
                event.preventDefault();
                var id = $(this).data('id');
                const offcanvasDelete = new bootstrap.Offcanvas(document.getElementById('deletemodal'));
                offcanvasDelete.show();
                $('#deletemember').val(id);
            });
            $('#deletemember').click(function() {
                var id = $(this).val();
                $.post("{{ URL::to('admin/delete') }}", {
                        id: id
                    },
                    function() {
                        $('#deletemodal').modal('hide');
                        location.reload();
                    })
            });

            $(document).on('click', '.lock', function(event) {
                event.preventDefault();
                var id = $(this).data('id');
                var is_lock = $(this).data('is_lock');
                console.log(is_lock);
                if (is_lock == 0) {
                    const offcanvasDelete = new bootstrap.Offcanvas(document.getElementById('lockemodal'));
                    offcanvasDelete.show();
                } else {
                    const offcanvasDelete = new bootstrap.Offcanvas(document.getElementById(
                        'unlockemodal'));
                    offcanvasDelete.show();
                }

                $('#lockemember').val(id);
                $('#unlockemember').val(id);

            });

            $('#lockemember').click(function() {
                var id = $(this).val();
                $.post("{{ URL::to('admin/user_lock') }}", {
                        id: id
                    },
                    function() {
                        $('#lockemodal').modal('hide');
                        $('#unlockemodal').modal('hide');
                        location.reload();
                    })
            });
            $('#unlockemember').click(function() {
                var id = $(this).val();
                $.post("{{ URL::to('admin/user_lock') }}", {
                        id: id
                    },
                    function() {
                        $('#unlockemodal').modal('hide');
                        location.reload();
                    })
            });
        });
    </script>
    <script>
        var mobile_no = window.intlTelInput(document.querySelector("#employee_mobile_no"), {
            separateDialCode: true,
            preferredCountries: ["in"],
            hiddenInput: "full",
            utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
        });

        $("form").submit(function() {
            var full_number = mobile_no.getNumber(intlTelInputUtils.numberFormat.E164);
            $("input[name='mobile_no[full]'").val(full_number);
        });

        $(document).ready(function() {
            $("#password").submit(function(event) {
                // Get the values of the password fields
                var password = $("#emp_password").val();
                var confirmedPassword = $("#confirm_password").val();

                // Check if the passwords match
                if (password !== confirmedPassword) {
                    // If passwords don't match, prevent the form submission and show an error message
                    event.preventDefault();
                    alert("Passwords do not match. Please enter matching passwords.");
                }
            });
        });
    </script>
@endsection
