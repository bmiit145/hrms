@extends('User.user_layout.sidebar')
@section('content')
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

        body.dark-mode .list-btn {
            color: #b0acc7 !important;
        }

        .list-btn {
            color: #8b8693;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            color: #fff !important;
        }

        .multipleChosen,
        .multipleSelect2 {
            width: 300px;
        }

        li.search-field {
            height: 44px;
            border: none !important;
        }

        li.search-field {
            padding: 10px !important;
            color: #9a96a1 !important;
        }

        ul.chosen-choices {
            padding: 2px !important;
        }

        body.dark-mode a.paginate_button {
            background-color: #403c59 !important;
            border-radius: 50% !important;
        }

        a.paginate_button {
            background-color: #eeeeef !important;
            border-radius: 50% !important;
        }

        body.dark-mode a.paginate_button.current {
            background-color: #8c57ff !important;
        }

        .table-responsive {
            overflow-x: auto;
            white-space: nowrap;
        }

        .table-bordered th,
        .table-bordered td {
            text-align: center;
        }

        #example {
            width: 100%;
        }

        a.chosen-single {
            border: none !important;
            height: 44px !important;
            padding: 11px !important;
            background-color: transparent !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            color: #fff !important;
        }

        a#example1_previous {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
            border-radius: 5% !important;
            margin-right: 5px !important;
            color: white !important;
        }

        a#example1_next {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
            border-radius: 5% !important;
            margin-left: 5px !important;
            color: white !important;
        }

        body.dark-mode a.chosen-single.chosen-default {
            background: #312d4b;
        }

        body.dark-mode .chosen-drop {
            background: #312d4b !important;
        }

        body.dark-mode ul.chosen-choices {
            background: #312d4b !important;
        }

        body.dark-mode input.default {
            color: #d4d0e9 !important;
        }

        body.dark-mode ul.chosen-results {
            color: #d5d1ea !important;
        }

        body.dark-mode li.search-choice {
            background: #312d4b !important;
            color: #ccc7e1 !important;
        }

        body.dark-mode .chosen-container-active .chosen-choices li.search-field input[type=text] {
            color: #d5d1ea !important;
        }

        body.dark-mode a.chosen-single {
            background: #312d4b !important;
            color: #c5c0da !important;
        }

        body.dark-mode select.form-control.employee-id {
            background: #312d4b;
        }

        .input-group {
            padding-bottom: 15px;
        }

        form .error:not(li):not(input) {
            position: absolute;
            bottom: -7px !important;
            left: 10px;
        }

        @media (max-width: 767px) {
            .modal-dialog {
                max-width: 100%;
                /* Make sure modal takes up full width */
                margin: 0;
                /* Remove any default margins */
            }

            .modal-body {
                padding: 10px;
                /* Adjust padding for small screens */
            }

            .table-responsive {
                max-height: 400px;
                /* Add scrollable height if there are many rows */
                overflow-y: auto;
            }
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Project List</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons btn-group flex-wrap">
                                <div class="dt-buttons btn-group flex-wrap">
                                    <a href="#" class="add_recode"><button
                                            class="btn create-new waves-effect waves-light employee"
                                            style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;"
                                            tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i
                                                    class="ri-add-line"></i> <span class="d-none d-sm-inline-block">Add New
                                                    Project</span></span>
                                        </button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <table class="datatables-basic table table-bordered dataTable no-footer dtr-column" id="example"
                        aria-describedby="DataTables_Table_0_info" style="width: 1395px;">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Client Name</th>
                                <th>Project Name</th>
                                <th>Amount</th>
                                <th>Commission (%)</th>
                                <th>Tax (%)</th>
                                <th>Total Earning</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Working Employee</th>
                                <th>Payment</th>
                                <th>Project Progress</th>
                                <th>Payment Actions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $project)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $project->getClientName->name ?? '' }}</td>
                                    <td>{{ $project->project_name ?? '' }}</td>
                                    <td>{{ $project->amount ?? '' }}</td>
                                    <td>{{ $project->commission ?? '' }}</td>
                                    <td>{{ $project->text ?? '' }}</td>
                                    <td>{{ $project->total_earning ?? '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($project->start_date)->format('d-m-Y') ?? '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($project->end_date)->format('d-m-Y') ?? '' }}</td>
                                    <td>
                                        @foreach ($project->getWorkingEmployee() as $employee)
                                            {{ $employee->emo_name }} <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($project->payment == '1')
                                            Milestone
                                        @elseif($project->payment == '2')
                                            Fix
                                        @elseif($project->payment == '3')
                                            Hourly
                                        @else
                                        @endif
                                    </td>
                                    <td>
                                        @if ($project->project_progress == '0')
                                            Pendding
                                        @elseif($project->project_progress == '1')
                                            Working
                                        @elseif($project->project_progress == '2')
                                            Stack
                                        @elseif($project->project_progress == '3')
                                            Canceled
                                        @elseif($project->project_progress == '4')
                                            QA Testing
                                        @elseif($project->project_progress == '5')
                                            Done
                                        @else
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="payment" data-id='{{ $project->id }}'>
                                            <i class="ri-add-line ri-22px list-btn"></i>
                                        </a>
                                        <a href="#" class="view" data-id='{{ $project->id }}'>
                                            <i class="ri-eye-line ri-22px list-btn"></i>
                                        </a>
                                    </td>
                                    <td><a class="edit" href="#" data-id='{{ $project->id }}'
                                            data-client_id='{{ $project->client_id }}'
                                            data-project_name='{{ $project->project_name }}'
                                            data-amount='{{ $project->amount }}'
                                            data-commission='{{ $project->commission }}' data-text='{{ $project->text }}'
                                            data-total_earning='{{ $project->total_earning }}'
                                            data-start_date='{{ $project->start_date }}'
                                            data-end_date='{{ $project->end_date }}'
                                            data-working_emp='{{ $project->working_emp }}'
                                            data-payment='{{ $project->payment }}'
                                            data-project_progress='{{ $project->project_progress }}'>
                                            <i class="ri-edit-box-line ri-22px list-btn"></i>
                                        </a>
                                        <a href="#" class="delete" data-id='{{ $project->id }}'>
                                            <i class="ri-delete-bin-7-line ri-22px list-btn"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add modal -->
        <div class="offcanvas offcanvas-end" id="addProject" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="addProject">Add Project</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="{{ route('admin.project.store') }}" method="post" id="myForm"
                    enctype="multipart/form-data"
                    class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework myForm">
                    @csrf
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-user-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select name="client_id" data-placeholder="Select Client Name"
                                    class="form-control multipleChosen" required>
                                    <option></option>
                                    @foreach ($getClient as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                <label for="basicFullname">Client Name</label>
                            </div>
                        </div>
                        <label id="client_id-error" class="error" for="client_id"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-user-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="Enter Project Name"
                                    name="project_name" />
                                <label for="basicFullname">Project Name</label>
                            </div>
                        </div>
                        <label id="project_name-error" class="error" for="project_name"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-money-rupee-circle-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                    class="form-control" placeholder="Enter Amount" name="amount" id="amount" />
                                <label for="basicFullname">Amount</label>
                            </div>
                        </div>
                        <label id="amount-error" class="error" for="amount"></label>
                    </div>

                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-percent-line"></i></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                    class="form-control" placeholder="Enter Commission (%)" name="commission"
                                    id="commission" />
                                <label for="basicFullname">Commission (%)</label>
                            </div>
                        </div>
                        <label id="commission-error" class="error" for="commission"></label>
                    </div>

                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-percent-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                    class="form-control" placeholder="Enter Tax (%)" name="tax" id="tex" />
                                <label for="basicFullname">Tax (%)</label>
                            </div>
                        </div>
                        <label id="tex-error" class="error" for="tex"></label>
                    </div>

                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-money-rupee-circle-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" readonly name="total_earning"
                                    id="total_earning" />
                                <label for="basicFullname">Total Earning</label>
                            </div>
                        </div>
                        <label id="total_earning-error" class="error" for="total_earning"></label>
                    </div>

                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" readonly class="form-control dob-picker"
                                    placeholder="Select Start Date" name="start_date" />
                                <label for="basicFullname">start Date</label>
                            </div>
                        </div>
                        <label id="festival_date-error" class="error" for="festival_date"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" readonly class="form-control dob-picker"
                                    placeholder="Select End Date" name="end_date" />
                                <label for="basicFullname">End Date</label>
                            </div>
                        </div>
                        <label id="festival_date-error" class="error" for="festival_date"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-group-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select name="working_employee[]" id="workingEmployee"
                                    class="form-control multipleChosen" data-placeholder="Select Working Employee"
                                    multiple="true">
                                    <option></option>
                                    @foreach ($getEmployee as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->emo_name }}</option>
                                    @endforeach
                                </select>
                                <label for="workingEmployee">Working Employee</label>
                            </div>
                        </div>
                        <label id="festival_date-error" class="error" for="festival_date"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-bank-card-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select name="payment" id="" class="form-control">
                                    <option value="">Select Payment</option>
                                    <option value="1">Milestone</option>
                                    <option value="2">Fix</option>
                                    <option value="3">Hourly</option>
                                </select>
                                <label for="basicFullname">Payment</label>
                            </div>
                        </div>
                        <label id="festival_date-error" class="error" for="festival_date"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-progress-1-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select name="project_progress" id="" class="form-control project_progress">
                                    <option value="">Select Project Progress</option>
                                    <option value="0">Pendding</option>
                                    <option value="1">Working</option>
                                    <option value="2">Stack</option>
                                    <option value="3">Canceled</option>
                                    <option value="4">QA Testing</option>
                                    <option value="5">Done</option>
                                </select>
                                <label for="basicFullname">Project Progress </label>
                            </div>
                        </div>
                        <label id="project_progress-error" class="error" for="project_progress"></label>
                    </div>

                    <!-- Buttons -->
                    <div class="col-sm-12">
                        <button type="submit" class="btn data-submit me-sm-4 me-1 waves-effect waves-light"
                            style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;">Save</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!--  Edit modal -->
        <div class="offcanvas offcanvas-end" id="editProject" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="editProject">Edit Project</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="{{ route('admin.project.edit') }}" method="post" id="editForm"
                    enctype="multipart/form-data"
                    class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework myForm">
                    @csrf
                    <input type="hidden" name="id" id="id">

                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-user-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select name="client_id" id="client_id" class="form-control multipleChosen" required>
                                    @foreach ($getClient as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                <label for="basicFullname">Client Name</label>
                            </div>
                        </div>
                        <label id="client_id-error" class="error" for="client_id"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-user-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="Enter Project Name"
                                    name="project_name" id="project_name" />
                                <label for="basicFullname">Project Name</label>
                            </div>
                        </div>
                        <label id="project_name-error" class="error" for="project_name"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-money-rupee-circle-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                    class="form-control amount" placeholder="Enter Amount" name="amount"
                                    id="amount" />
                                <label for="basicFullname">Amount</label>
                            </div>
                        </div>
                        <label id="amount-error" class="error" for="amount"></label>
                    </div>

                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-percent-line"></i></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                    class="form-control commission" placeholder="Enter Commission (%)" name="commission"
                                    id="commission" />
                                <label for="basicFullname">Commission (%)</label>
                            </div>
                        </div>
                        <label id="commission-error" class="error" for="commission"></label>
                    </div>

                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-percent-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                    class="form-control tex" placeholder="Enter Tax (%)" name="tax"
                                    id="tex" />
                                <label for="basicFullname">Tax (%)</label>
                            </div>
                        </div>
                        <label id="tex-error" class="error" for="tex"></label>
                    </div>

                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-money-rupee-circle-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control total_earning" readonly name="total_earning"
                                    id="total_earning" />
                                <label for="basicFullname">Total Earning</label>
                            </div>
                        </div>
                        <label id="total_earning-error" class="error" for="total_earning"></label>
                    </div>

                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" readonly class="form-control dob-picker"
                                    placeholder="Select Start Date" name="start_date" id="start_date" />
                                <label for="basicFullname">start Date</label>
                            </div>
                        </div>
                        <label id="festival_date-error" class="error" for="festival_date"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" readonly class="form-control dob-picker"
                                    placeholder="Select End Date" name="end_date" id="end_date" />
                                <label for="basicFullname">End Date</label>
                            </div>
                        </div>
                        <label id="festival_date-error" class="error" for="festival_date"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-group-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select name="working_employee[]" id="working_employee"
                                    class="form-control multipleChosen" data-placeholder="Select Working Employee"
                                    multiple="true">
                                    <option></option>
                                    @foreach ($getEmployee as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->emo_name }}</option>
                                    @endforeach
                                </select>
                                <label for="workingEmployee">Working Employee</label>
                            </div>
                        </div>
                        <label id="festival_date-error" class="error" for="festival_date"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-bank-card-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select name="payment" id="payment" class="form-control">
                                    <option value="">Select Payment</option>
                                    <option value="1">Milestone</option>
                                    <option value="2">Fix</option>
                                    <option value="3">Hourly</option>
                                </select>
                                <label for="basicFullname">Payment</label>
                            </div>
                        </div>
                        <label id="festival_date-error" class="error" for="festival_date"></label>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-progress-1-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select name="project_progress" id="project_progress"
                                    class="form-control project_progress">
                                    <option value="">Select Project Progress</option>
                                    <option value="0">Pendding</option>
                                    <option value="1">Working</option>
                                    <option value="2">Stack</option>
                                    <option value="3">Canceled</option>
                                    <option value="4">QA Testing</option>
                                    <option value="5">Done</option>
                                </select>
                                <label for="basicFullname">Project Progress </label>
                            </div>
                        </div>
                        <label id="project_progress-error" class="error" for="project_progress"></label>
                    </div>

                    <!-- Buttons -->
                    <div class="col-sm-12">
                        <button type="submit" class="btn data-submit me-sm-4 me-1 waves-effect waves-light"
                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;">Update</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Delete Confirmation Modal (Offcanvas) -->
        <div class="offcanvas offcanvas-end" id="deletemodal" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="deletemodal">Delete Project</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <h5 class="text-center">Are you sure you want to delete this Project?</h5>
                <div class="col-sm-12">
                    <button type="submit" id="deleteProject"
                        class="btn btn-danger waves-effect waves-light">Delete</button>
                    <button type="reset" class="btn btn-outline-secondary waves-effect"
                        data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </div>
        </div>


        <!--  Payment modal -->
        <div class="offcanvas offcanvas-end" id="paymentModal" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="paymentModal">Payment</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="{{ route('admin.project.payment') }}" method="post" id="paymnetForm"
                    enctype="multipart/form-data"
                    class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework myForm">
                    @csrf
                    <input type="hidden" name="project_id" id="project_id">
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" readonly class="form-control dob-picker"
                                    placeholder="Select Paymnet Date" name="payment_date" id="payment_date" />
                                <label for="basicFullname">Paymnet Date</label>
                            </div>
                        </div>
                        <label id="payment_date-error" class="error" for="payment_date"></label>
                    </div>

                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-money-rupee-circle-fill"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                    class="form-control" placeholder="Enter Total Paymnet" name="total_payment"
                                    id="total_payment" />
                                <label for="basicFullname">Total Paymnet</label>
                            </div>
                        </div>
                        <label id="total_payment-error" class="error" for="total_payment"></label>
                    </div>

                    <!-- Buttons -->
                    <div class="col-sm-12">
                        <button type="submit" class="btn data-submit me-sm-4 me-1 waves-effect waves-light"
                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment Details Modal -->
        <div class="modal fade" id="paymentDetailsModal" tabindex="-1" aria-labelledby="paymentDetailsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <!-- modal-lg for large modal, use modal-sm for small -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentDetailsModalLabel">Payment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive"> <!-- Enables horizontal scroll for the table on small screens -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Payment Date</th>
                                        <th>Total Payment</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="paymentDetailsBody">
                                    <!-- Payment rows will be dynamically added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Payment Modal -->
        <div class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="editPaymentForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPaymentModalLabel">Edit Payment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="paymentId" name="payment_id">
                            <div class="mb-3">
                                <label for="paymentAmount" class="form-label">Payment Date</label>
                                <input type="text" readonly class="form-control dob-picker"
                                    placeholder="Select Paymnet Date" name="payment_date" id="paymentDate" />
                            </div>
                            <div class="mb-3">
                                <label for="paymentAmount" class="form-label">Payment Amount</label>
                                <input type="tel"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                    id="paymentAmount" name="amount" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit"
                                style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;"
                                class="btn">Save Changes</button>
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $(document).on('click', '.add_recode', function(event) {
                    event.preventDefault();
                    const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('addProject'));
                    offcanvasEdit.show();

                    $(document).ready(function() {
                        //Chosen
                        $(".multipleChosen").chosen({
                            placeholder_text_multiple: "Select Working Employee" //placeholder
                        });
                    })


                    // Initialize validation plugin
                    $('#myForm').validate({
                        rules: {
                            client_id: {
                                required: true
                            },
                            project_name: {
                                required: true
                            },
                            amount: {
                                required: true
                            },
                            total_earning: {
                                required: true,
                            },
                            project_progress: {
                                required: true,
                            }
                        },
                        messages: {
                            client_id: {
                                required: "Client name is required"
                            },
                            project_name: {
                                required: "Project name is required"
                            },
                            amount: {
                                required: "Project amount is required"
                            },
                            total_earning: {
                                required: "Total earning is required",
                            },
                            project_progress: {
                                required: "Project progress is required",
                            }
                        },
                        errorPlacement: function(error, element) {
                            if (element.hasClass('project_progress')) {
                                error.insertAfter(
                                    element);
                            } else {
                                error.insertAfter(
                                    element);
                            }
                        },
                        highlight: function(element, errorClass, validClass) {
                            if (!$(element).hasClass('project_progress')) {
                                $(element).addClass(errorClass).removeClass(validClass);
                            }
                        },
                        unhighlight: function(element, errorClass, validClass) {
                            if (!$(element).hasClass('project_progress')) {
                                $(element).removeClass(errorClass).addClass(validClass);
                            }
                        },
                        // Submit handler
                        submitHandler: function(form) {
                            form.submit(); // Submit the form if validation passes
                        }
                    });
                });
            });

            $(document).ready(function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $(document).on('click', '.edit', function(event) {
                    event.preventDefault();
                    $(document).ready(function() {
                        //Chosen
                        $(".multipleChosen").chosen({
                            placeholder_text_multiple: "Select Working Employee" //placeholder
                        });
                    })

                    // Fetching data attributes
                    var id = $(this).data('id');
                    var client_id = $(this).data('client_id');
                    var project_name = $(this).data('project_name');
                    var amount = $(this).data('amount');
                    var commission = $(this).data('commission');
                    var text = $(this).data('text');
                    var total_earning = $(this).data('total_earning');
                    var start_date = $(this).data('start_date');
                    var end_date = $(this).data('end_date');
                    var working_emp = $(this).data('working_emp');
                    var payment = $(this).data('payment');
                    var project_progress = $(this).data('project_progress');

                    // Showing the offcanvas
                    const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('editProject'));
                    offcanvasEdit.show();

                    // Setting values to the form fields
                    $('#id').val(id);
                    $('#client_id').val(client_id);
                    $('#project_name').val(project_name);
                    $('.amount').val(amount);
                    $('.commission').val(commission);
                    $('.tex').val(text);
                    $('.total_earning').val(total_earning);
                    $('#start_date').val(start_date);
                    $('#end_date').val(end_date);
                    $('#payment').val(payment);
                    $('#project_progress').val(project_progress);

                    if (working_emp) {
                        // Ensure `working_emp` is a string
                        if (typeof working_emp !== 'string') {
                            working_emp = working_emp.toString(); // Convert to string if it's not
                        }
                        var workingEmpArray = working_emp.split(','); // Split the string
                        $('#working_employee').val(workingEmpArray).change(); // Set selected values
                    } else {
                        // Clear selection if no employees
                        $('#working_employee').val([]).change();
                    }

                    // Apply validation to the form
                    $('#editForm').validate({
                        // Validation rules
                        rules: {
                            project_name: {
                                required: true
                            },
                            client_id: {
                                required: true
                            },
                            amount: {
                                required: true
                            },
                            total_earning: {
                                required: true,
                            },
                            project_progress: {
                                required: true,
                            }
                        },
                        messages: {
                            project_name: {
                                required: "Project name is required"
                            },
                            client_id: {
                                required: "Client name is required"
                            },
                            amount: {
                                required: "Project amount is required"
                            },
                            total_earning: {
                                required: "Total earning is required",
                            },
                            project_progress: {
                                required: "Project progress is required",
                            }
                        },
                        // Submit handler (submit the form if validation is successful)
                        submitHandler: function(form) {
                            var formData = new FormData(form); // Get form data including files
                            var url = $(form).attr('action'); // Get form action URL

                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    location.reload();
                                },
                                error: function(response) {
                                    // Handle any error if needed
                                    alert('An error occurred. Please try again.');
                                }
                            });
                        }
                    });
                });
            });

            $(document).on('click', '.delete', function(event) {
                event.preventDefault();
                var id = $(this).data('id');

                // Show the delete modal
                const offcanvasDelete = new bootstrap.Offcanvas(document.getElementById('deletemodal'));
                offcanvasDelete.show();

                // Assign the festival ID to the delete button
                $('#deleteProject').val(id);
            });

            $('#deleteProject').click(function() {
                var id = $(this).val();

                // Send an AJAX request to delete the festival
                $.ajax({
                    url: "{{ route('admin.project.delete') }}",
                    type: "GET",
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        if (response) {
                            location.reload(); // Reload the page
                        } else {
                            alert(response.message ||
                                'Error deleting the festival.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while deleting the festival.');
                    }
                });
            });

            $(document).ready(function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $(document).on('click', '.payment', function(event) {
                    event.preventDefault();

                    // Fetching data attributes
                    var id = $(this).data('id');

                    // Showing the offcanvas
                    const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('paymentModal'));
                    offcanvasEdit.show();

                    // Setting values to the form fields
                    $('#project_id').val(id);

                    // Apply validation to the form
                    $('#paymnetForm').validate({
                        // Validation rules
                        rules: {
                            payment_date: {
                                required: true
                            },
                            total_payment: {
                                required: true
                            },
                        },
                        messages: {
                            payment_date: {
                                required: "Paymnet date is required"
                            },
                            total_payment: {
                                required: "Total paymnet is required"
                            },
                        },
                        // Submit handler (submit the form if validation is successful)
                        submitHandler: function(form) {
                            var formData = new FormData(form); // Get form data including files
                            var url = $(form).attr('action'); // Get form action URL

                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    location.reload();
                                },
                                error: function(response) {
                                    // Handle any error if needed
                                    alert('An error occurred. Please try again.');
                                }
                            });
                        }
                    });
                });

                $(document).ready(function() {
                    // View Payment Details
                    function formatDate(dateString) {
                        const date = new Date(dateString);
                        const day = String(date.getDate()).padStart(2, '0'); // Add leading zero to the day
                        const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
                        const year = String(date.getFullYear()).slice(-2); // Get last two digits of the year
                        return `${day}-${month}-${year}`;
                    }
                    $('.view').on('click', function(e) {
                        e.preventDefault();

                        const projectId = $(this).data('id');

                        $.ajax({
                            url: '{{ route('admin.project.payment.detail') }}',
                            method: 'GET',
                            data: {
                                project_id: projectId
                            },
                            success: function(response) {
                                const paymentDetails = response.payment_details;
                                const remainingBalance = response.remaining_balance;
                                const totalEarning = response
                                    .total_earning; // Get total_earning from the response

                                // Clear previous payment details
                                $('#paymentDetailsBody').html('');

                                // Append each payment to the table
                                paymentDetails.forEach((payment, index) => {
                                    $('#paymentDetailsBody').append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${formatDate(payment.date)}</td>
                        <td>${payment.amount}</td>
                        <td>
                            <a class="edit-payment" style="cursor: pointer;" data-id="${payment.id}" data-date="${payment.date}" data-amount="${payment.amount}">
                                <i class="ri-edit-line"></i>
                            </a>
                            <a class="delete-payment" style="cursor: pointer;" data-id="${payment.id}">
                                <i class="ri-delete-bin-7-line"></i>
                            </a>
                        </td>
                    </tr>
                `);
                                });

                                // Append total remaining balance and total earning to the table
                                $('#paymentDetailsBody').append(`
                <tr>
                    <td colspan="2"><strong>Total Earning</strong></td>
                    <td colspan="2"><strong>${totalEarning}</strong></td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Total Remaining</strong></td>
                    <td colspan="2"><strong>${remainingBalance}</strong></td>
                </tr>
            `);

                                // Show the modal with payment details
                                $('#paymentDetailsModal').modal('show');
                            },
                            error: function() {
                                alert('Failed to fetch payment details.');
                            }
                        });
                    });

                    // Delete Payment
                    $(document).on('click', '.delete-payment', function() {
                        const paymentId = $(this).data('id');

                        if (confirm('Are you sure you want to delete this payment?')) {
                            $.ajax({
                                url: '{{ route('admin.project.payment.delete') }}',
                                method: 'POST',
                                data: {
                                    payment_id: paymentId,
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    location.reload();
                                },
                                error: function() {
                                    alert('Failed to delete payment.');
                                }
                            });
                        }
                    });

                    // Edit Payment
                    $(document).on('click', '.edit-payment', function() {
                        const paymentId = $(this).data('id');
                        const currentAmount = $(this).data('amount');
                        const currentDate = $(this).data('date');

                        $('#paymentId').val(paymentId);
                        $('#paymentAmount').val(currentAmount);
                        $('#paymentDate').val(currentDate);
                        $('#editPaymentModal').modal('show');
                    });

                    // Save Payment Changes
                    $('#editPaymentForm').on('submit', function(e) {
                        e.preventDefault();

                        const paymentId = $('#paymentId').val();
                        const newAmount = $('#paymentAmount').val();
                        const newDate = $('#paymentDate').val();

                        $.ajax({
                            url: '{{ route('admin.project.payment.update') }}',
                            method: 'POST',
                            data: {
                                payment_id: paymentId,
                                amount: newAmount,
                                payment_date: newDate,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                location.reload();
                            },
                            error: function() {
                                alert('Failed to update payment.');
                            }
                        });
                    });
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Function to initialize total earning calculation for a specific form
                function initializeTotalEarningCalculation(formId) {
                    const form = document.getElementById(formId);

                    if (form) {
                        const amountField = form.querySelector('#amount');
                        const commissionField = form.querySelector('#commission');
                        const taxField = form.querySelector('#tex');
                        const totalEarningField = form.querySelector('#total_earning');

                        // Function to calculate total earning
                        function updateTotalEarning() {
                            const amount = parseFloat(amountField.value) || 0;
                            const commission = parseFloat(commissionField.value) || 0;
                            const tax = parseFloat(taxField.value) || 0;

                            // Calculate the total earning
                            const totalEarning = amount - (amount * commission / 100) - (amount * tax / 100);

                            // Update the Total Earning field
                            totalEarningField.value = totalEarning.toFixed(2); // Keep two decimal places
                        }

                        // Attach event listeners for input changes
                        [amountField, commissionField, taxField].forEach(function(field) {
                            field.addEventListener('input', updateTotalEarning);
                        });

                        // Optionally, initialize the value if the form is already prefilled
                        updateTotalEarning();
                    }
                }

                // Initialize calculations for both "Add" and "Edit" forms
                initializeTotalEarningCalculation('myForm'); // For Add Form
                initializeTotalEarningCalculation('editForm'); // For Edit Form
            });
        </script>

        {{-- <script>
        const onSearch = () => {
            const input = document.querySelector("#search");
            const filter = input.value.toUpperCase();

            const  list = document.querySelectorAll("#workingEmployee option");
            list.forEach((el) => {
                const text = el.textContent.toUpperCase();
                el.style.display = text.includes(filter) ? "" : "none";
            });
        }
    </script> --}}
    @endsection
