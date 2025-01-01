@extends('admin_layout.sidebar')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .date-input {
            width: 100%;
            border: 1px solid black;
            padding: 5px;
            border-radius: 3px;
        }

        .navecation ul li {
            list-style: none;
            float: left;
            padding-right: 1px;
        }

        .navecation ul li a {
            text-decoration: none;
            padding: 4px 5px;
            color: #000;
        }

        .active1 {
            border-bottom: 2px solid black
        }

        .chat-card-div {
            height: 85vh;
            overflow: auto;
        }

        @media screen and (max-width:992px) {
            .chat-card-div {
                height: 60vh;
                overflow: auto;
            }
        }

        @media screen and (max-width:425px) {
            .card-main-text {
                font-size: 12px;
            }
        }

        .main-content {
            position: relative;
            display: inline-block;
        }

        .overlay-button-div {
            position: absolute;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .main-content:hover .overlay-button-div {
            opacity: 1;
            /* Show button on hover */
        }

        .main-content:hover .lorem-text {
            display: none;
        }

        /* Scrollbar */

        /* Define scrollbar styles */
        /* Track */
        .chat-card-div::-webkit-scrollbar {
            width: 5px;
            /* Set the width of the scrollbar */
        }

        /* Handle */
        .chat-card-div::-webkit-scrollbar-thumb {
            background: #888;
            /* Set the color of the scrollbar thumb */
        }

        /* Handle on hover */
        .chat-card-div::-webkit-scrollbar-thumb:hover {
            background: #555;
            /* Set the color of the scrollbar thumb on hover */
        }

        /* Track */
        .chat-card-div::-webkit-scrollbar-track {
            background: #f1f1f1;
            /* Set the color of the scrollbar track */
        }

        /* Handle */
        .chat-card-div::-webkit-scrollbar-button {
            background: #ccc;
            /* Set the color of the scrollbar buttons (arrows) */
        }

        /* Scrollbar */
        .filter_head {
            width: 33.33%;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .filter_row {
            display: flex;
            gap: 20px;
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

        label {
            color: white
        }

        option {
            color: black;
        }

        body.dark-mode span.mdtp__time_h.active {
            color: #b0acc7 !important;
        }

        body.dark-mode section.mdtp__clock_holder {
            background-color: #312D4B !important;
        }

        body.dark-mode .mdtp__hour_holder {
            background-color: #312D4B !important;
            border-radius: 50%;
        }

        body.dark-mode .mdtp__minute_holder {
            background-color: #312D4B !important;
        }

        body.dark-mode section.mdtp__time_holder {
            background-color: #312D4B !important;
            border: 1px solid #b0acc7;
        }

        body.dark-mode section.mdtp__time_holder {
            color: #b0acc7 !important;
        }

        body.dark-mode span.mdtp__button.cancel {
            color: #b0acc7 !important;
        }

        body.dark-mode .mdtp__button.ok {
            color: #b0acc7 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            color: white !important;
        }
    </style>

    </head>

    <body>

        <div class="container-fluid">
            <div class="row mx-0">
                <div class="col-xl-6 col-lg-6 col-md-12 mx-0">
                    <div class="fs-4 fw-bold p-3 d-flex align-items-center" style="background: black;color: white;">
                        <div>Employee</div>



                    </div>


                    <input type="hidden" id="monthly_selery" value="{{ $first_emp->monthly_selery ?? '' }}">


                    <div class="card border-0 chat-card-div" style="overflow: auto;">
                        @foreach ($employee as $employee_item)
                            <div class="container-fluid">
                                <div class="row d-flex align-items-center main-content py-3"
                                    style="border-bottom: 1px solid #ddd;">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 d-flex" style="gap: 1%">
                                        <div>
                                            @if ($employee_item->profile_image != null)
                                                <img src="{{ asset('profile_image/' . $employee_item->profile_image) }}"
                                                    class="m-1" width="50" height="50"
                                                    style="border-radius: 50%;">
                                            @else
                                                <img src="{{ asset('assets\img\avatars\3.png') }}" alt=""
                                                    class="m-1" width="50" height="50"
                                                    style="border-radius: 50%;">
                                            @endif
                                        </div>

                                        <div style="margin-top: auto; margin-bottom: auto;">
                                            <b class="card-main-text"
                                                data-emp-id="{{ $employee_item->id }}">{{ $employee_item->emo_name }}</b>
                                        </div>

                                        <div class="ms-auto" style="margin-top: auto; margin-bottom: auto;">
                                            <a type="button" class="add_over_time" data-emp_id="{{ $employee_item->id }}"
                                                data-selery="{{ $employee_item->monthly_selery }}">
                                                <i class="ri-add-line"></i>
                                            </a>
                                            <a type="button" class="view_employee" data-emp_id="{{ $employee_item->id }}"
                                                data-selery="{{ $employee_item->monthly_selery }}">
                                                <i class="ri-eye-line ri-22px list-btn"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 mt-md-0 mt-sm-4 mt-4">
                    <div class=" p-xl-2 p-lg-2 p-md-2 p-sm-2 p-2" style="height: auto;background: black !important;">
                        <div class="d-flex align-items-center">

                            <div>
                                <div class="fw-bold" style="white-space: nowrap;" id="emp_name"></div>
                                <div style="white-space: nowrap;" id="emp_role"></div>
                            </div>
                        </div>
                        <form method="GET" action="{{ route('index.benefits') }}">
                                <input type="hidden" name="emp" value="{{ request()->get('emp') }}" id="filter_emp_id">

                            <div class="filter_row">
                                <div class="filter_head">
                                    <label for="month">Month</label>
                                    <select name="month" id="month" class="form-control" style="color: white;">
                                        @foreach (range(1, 12) as $month)
                                            <option value="{{ $month }}"
                                                {{ request('month', Carbon\Carbon::now()->month) == $month ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="filter_head">
                                    <label for="year">Year</label>
                                    <select name="year" id="year" class="form-control" style="color: white;">
                                        @foreach (range(2020, Carbon\Carbon::now()->year) as $year)
                                            <option value="{{ $year }}"
                                                {{ request('year', Carbon\Carbon::now()->year) == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <input type="hidden" name="emp" id="filter_emp_id"> --}}



                                <div class="filter_head ">
                                    <button type="submit" class="btn  submit_button"
                                        style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;">Submit</button>
                                    <button class="btn  refresh-btn"
                                        style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;"><i
                                            class="ri-refresh-line ri-22px text-white"></i></button>
                                </div>
                            </div>
                        </form>

                    </div>




                    <div class="mt-3" style="overflow: auto;" id="assign_table_show">
                        <div class="mt-3">
                            <b>Benefits Sheet</b>
                        </div>
                        <table class="datatables-basic table table-bordered dataTable no-footer dtr-column" id="example1"
                            aria-describedby="DataTables_Table_0_info" style="width: 1395px;">
                            <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>Date</th>
                                    <th>First In</th>
                                    <th>Last In</th>
                                    <th>Total Time</th>
                                    <th>Total Amonut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="assined_tbody">
                                @foreach ($data as $value)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($value->date)->format('d-m-Y') }}</td>
                                        <td>{{ $value->start_time }}</td>
                                        <td>{{ $value->end_time }}</td>
                                        <td>{{ $value->total_hourse }}</td>
                                        <td>{{ $value->total_amount }}</td>
                                        <td><a class="edit" href="#" data-id='{{ $value->id }}'
                                                data-date='{{ $value->date }}'
                                                data-total_hourse='{{ $value->total_hourse }}'
                                                data-start_time='{{ $value->start_time }}'
                                                data-end_time='{{ $value->end_time }}'
                                                data-total_amount="{{ $value->total_amount }}">
                                                <i class="ri-edit-box-line ri-22px list-btn"></i>
                                            </a>

                                            <a href="#" class="delete" data-id='{{ $value->id }}'>
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
        </div>
        <!-- Add Modal -->

        <div class="offcanvas offcanvas-end" id="add-new-record" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">Add Benefits</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="{{ route('store.benefits') }}" method="post" id="password"
                    enctype="multipart/form-data"
                    class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    @csrf
                    <input type="hidden" id="emp_id" name="emp_id">
                    <div class="col-sm-12 fv-plugins-icon-container">
                        Monthly Selery :- <span class="Monthly"></span>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        Per day Selery :- <span class="Per"></span>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        Hourly Selery :- <span class="Hourly"></span>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-calendar-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" readonly class="form-control dt-full-name  dob-picker "
                                    name="date" placeholder="Enter department name" aria-label="Enter Date"
                                    aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Date</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicStartTime" class="input-group-text"><i
                                    class="ri-time-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="start_time" class="form-control dt-full-name timepicker"
                                    name="start_time" placeholder="Enter Start Time" aria-label="Enter Time"
                                    aria-describedby="basicStartTime" required>
                                <label for="start_time">Start Time</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicEndTime" class="input-group-text"><i class="ri-time-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="end_time" class="form-control dt-full-name timepicker"
                                    name="end_time" placeholder="Enter End Time" aria-label="Enter Time"
                                    aria-describedby="basicEndTime" required>
                                <label for="end_time">End Time</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicTotalHours" class="input-group-text"><i
                                    class="ri-time-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="total_hourse" class="form-control dt-full-name"
                                    name="total_hourse" placeholder="Total Hours/Minutes"
                                    aria-describedby="basicTotalHours" readonly>
                                <label for="total_hourse">Total Hours/Minutes</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-wallet-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control dt-full-name" name="total_amount"
                                    placeholder="Enter department name" aria-label="Enter Total Payable Amonut"
                                    aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Total Payable Amonut</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn  data-submit me-sm-4 me-1 waves-effect waves-light"
                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>

            </div>
        </div>



        {{-- ----------------------- Edit time ------------------------- --}}
        <div class="offcanvas offcanvas-end" id="edit-new-record" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">Edit Benefits</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="{{ route('edit.benefits') }}" method="post" id="password" enctype="multipart/form-data"
                    class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    @csrf
                    <input type="hidden" id="edit_emp_id" name="emp_id">
                    <div class="col-sm-12 fv-plugins-icon-container">
                        Monthly Selery :- <span class="Monthly"></span>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        Per day Selery :- <span class="Per"></span>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        Hourly Selery :- <span class="Hourly"></span>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-calendar-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" readonly class="form-control dt-full-name  dob-picker "
                                    id="edit_date" name="date" placeholder="Enter department name"
                                    aria-label="Enter Date" aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Date</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicStartTime" class="input-group-text"><i
                                    class="ri-time-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="edit_start_time" class="form-control dt-full-name timepicker"
                                    name="start_time" placeholder="Enter Start Time" aria-label="Enter Time"
                                    aria-describedby="basicStartTime" required>
                                <label for="start_time">Start Time</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicEndTime" class="input-group-text"><i class="ri-time-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="edit_end_time" class="form-control dt-full-name timepicker"
                                    name="end_time" placeholder="Enter End Time" aria-label="Enter Time"
                                    aria-describedby="basicEndTime" required>
                                <label for="end_time">End Time</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicTotalHours" class="input-group-text"><i
                                    class="ri-time-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="edit_total_hourse" class="form-control dt-full-name"
                                    name="total_hourse" placeholder="Total Hours/Minutes"
                                    aria-describedby="basicTotalHours" readonly>
                                <label for="total_hourse">Total Hours/Minutes</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-wallet-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control dt-full-name" id="total_amount"
                                    name="total_amount" placeholder="Enter department name"
                                    aria-label="Enter Total Payable Amonut" aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Total Payable Amonut</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn  data-submit me-sm-4 me-1 waves-effect waves-light"
                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>

            </div>
        </div>


        <!-- Delete Confirmation Modal (Offcanvas) -->
        <div class="offcanvas offcanvas-end" id="deletemodal" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="deleteExampleModalLabel">Delete Recode</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <h5 class="text-center">Are you sure you want to delete this Recode?</h5>
                <form action="{{ Route('delete.benefits') }}" method="POST" id="delete-form">
                    @csrf
                    <input type="hidden" name="id" id="delete-id">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-danger waves-effect waves-light"
                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;">Delete</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        @php
            use Carbon\Carbon;

            // મહીનાના કાર્યદિન ગણો
            $daysInMonth = Carbon::create()->month(request('month', Carbon::now()->month))->daysInMonth;
            $workingDays = 0;

            foreach (range(1, $daysInMonth) as $day) {
                $currentDate = Carbon::createFromDate(
                    request('year', Carbon::now()->year),
                    request('month', Carbon::now()->month),
                    $day,
                );

                $isSunday = $currentDate->isSunday();
                $isSecondOrFourthSaturday = $currentDate->isSaturday() && (ceil($day / 7) == 2 || ceil($day / 7) == 4);

                if (!$isSunday && !$isSecondOrFourthSaturday) {
                    $workingDays++;
                }
            }
        @endphp




        <script>
            $(document).ready(function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $(document).on('click', '.add_over_time', function(event) {
                    event.preventDefault();

                    var id = $(this).data('emp_id');
                    var selery = $(this).data('selery'); // માસિક પગાર
                    var workingDays = {{ $workingDays }}; // PHPમાં ગણવેલા કાર્યદિન

                    // પ્રતિદિન પગાર અને પ્રતિ કલાક પગાર
                    var perDaySalary = selery / workingDays;
                    var hourlySalary = perDaySalary / 8;

                    // Show the edit offcanvas
                    const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('add-new-record'));
                    offcanvasEdit.show();

                    // Populate the form fields in the edit offcanvas
                    $('.Monthly').html(selery);
                    $('.Per').html(perDaySalary.toFixed(0));
                    $('.Hourly').html(hourlySalary.toFixed(0));
                    $('#emp_id').val(id);
                });
                $(document).on('click', '.edit', function(event) {
                    event.preventDefault();

                    var id = $(this).data('id');
                    var date = $(this).data('date');
                    var total_hourse = $(this).data('total_hourse');
                    var start_time = $(this).data('start_time');
                    var end_time = $(this).data('end_time');
                    var total_amount = $(this).data('total_amount');
                    var selery = $('#monthly_selery').val(); // માસિક પગાર
                    var workingDays = {{ $workingDays }}; // PHPમાં ગણવેલા કાર્યદિન

                    // પ્રતિદિન પગાર અને પ્રતિ કલાક પગાર
                    var perDaySalary = selery / workingDays;
                    var hourlySalary = perDaySalary / 8;


                    // Populate the form fields in the edit offcanvas
                    $('.Monthly').html(selery);
                    $('.Per').html(perDaySalary.toFixed(0));
                    $('.Hourly').html(hourlySalary.toFixed(0));

                    // Show the edit offcanvas
                    const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('edit-new-record'));
                    offcanvasEdit.show();
                    $('#edit_emp_id').val(id);
                    $('#edit_date').val(date);
                    $('#edit_start_time').val(start_time);
                    $('#edit_end_time').val(end_time);
                    $('#edit_total_hourse').val(total_hourse);
                    $('#total_amount').val(total_amount);


                });
                $(document).on('click', '.view_employee', function(event) {
                    event.preventDefault();
                    var id = $(this).data('emp_id');
                    var selery = $(this).data('selery');

                    $('#filter_emp_id').val(id);
                    $('#monthly_selery').val(selery);
                    $('.submit_button').click();
                });

                $(document).on('click', '.refresh-btn', function(event) {
                    event.preventDefault();
                    window.location.href = "{{ route('index.benefits') }}";
                });


                $(document).on('click', '.delete', function(event) {
                    var id = $(this).data('id');
                    event.preventDefault();
                    const offcanvasdelete = new bootstrap.Offcanvas(document.getElementById('deletemodal'));
                    console.log(offcanvasdelete, 'offcanvasdelete')
                    offcanvasdelete.show();
                    $('#delete-id').val(id)

                });



            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                console.log("DOM Loaded");

                // Basic Event Listeners
                document.getElementById('start_time').addEventListener('change', function() {
                    console.log("Start time changed");
                });
                document.getElementById('end_time').addEventListener('change', function() {
                    console.log("End time changed");
                });

                // Log Custom Events
                $('.timepicker').on('changeTime', function() {
                    console.log("Timepicker changeTime triggered");
                });

                function calculateTotalHours() {
                    console.log("calculateTotalHours called");

                    var startTime = document.getElementById('start_time').value;
                    var endTime = document.getElementById('end_time').value;

                    console.log("Start Time:", startTime);
                    console.log("End Time:", endTime);

                    if (startTime && endTime) {
                        // Parse time with AM/PM format
                        var start = moment(startTime, 'hh:mm A'); // 'hh:mm A' for 12-hour format with AM/PM
                        var end = moment(endTime, 'hh:mm A');

                        if (end.isBefore(start)) {
                            alert('End time must be after start time!');
                            return;
                        }

                        var duration = moment.duration(end.diff(start));
                        var hours = Math.floor(duration.asHours());
                        var minutes = duration.minutes();

                        console.log("Duration:", hours, "hours", minutes, "minutes");
                        document.getElementById('total_hourse').value = hours + ' hours ' + minutes + ' minutes';
                    }
                }

                // Attach Handlers
                $('.timepicker').on('input blur change', calculateTotalHours);
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                console.log("Edit Modal Script Loaded");

                // Edit Modal: Event Listeners for Time Fields
                document.getElementById('edit_start_time').addEventListener('change', calculateEditTotalHours);
                document.getElementById('edit_end_time').addEventListener('change', calculateEditTotalHours);

                // Function to Calculate Total Hours in Edit Modal
                function calculateEditTotalHours() {
                    console.log("calculateEditTotalHours called");

                    var startTime = document.getElementById('edit_start_time').value;
                    var endTime = document.getElementById('edit_end_time').value;

                    console.log("Edit Start Time:", startTime);
                    console.log("Edit End Time:", endTime);

                    if (startTime && endTime) {
                        var start = moment(startTime, 'hh:mm A'); // 'hh:mm A' for 12-hour format with AM/PM
                        var end = moment(endTime, 'hh:mm A');

                        if (end.isBefore(start)) {
                            return;
                        }

                        var duration = moment.duration(end.diff(start));
                        var hours = Math.floor(duration.asHours());
                        var minutes = duration.minutes();

                        console.log("Edit Duration:", hours, "hours", minutes, "minutes");
                        document.getElementById('edit_total_hourse').value = hours + ' hours ' + minutes + ' minutes';

                        // Calculate Total Payable Amount (Example Calculation)
                        var hourlySalary = parseFloat(document.querySelector('.Hourly').textContent) || 0;
                        var totalPay = ((hours + (minutes / 60)) * hourlySalary).toFixed(2);

                        console.log("Total Payable Amount:", totalPay);
                        document.getElementById('total_amount').value = totalPay;
                    }
                }

                // Additional Trigger for Timepicker Inputs
                $('.timepicker').on('input blur change', calculateEditTotalHours);
            });
        </script>
        <script>
            $(document).ready(function() {
                var table = $('#example1').DataTable({
                    "processing": true,
                    "serverside": true,
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'excelHtml5',
                            text: '<span>Excel</span>', // Custom text and color
                            className: 'btn-excel', // Add a custom class for additional styling
                            exportOptions: {
                                columns: ':not(:last-child)' // Exclude the last column
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<span>PDF</span>', // Custom text and color
                            className: 'btn-pdf', // Add a custom class for additional styling

                            pageSize: 'A4', // Set orientation to landscape
                            exportOptions: {
                                columns: ':not(:last-child)' // Exclude the last column
                            },
                            customize: function(doc) {
                                // Customize the PDF with table lines
                                doc.styles.tableHeader = {
                                    bold: true,
                                    fontSize: 14,
                                    color: 'black',
                                    fillColor: '#d9edf7', // Light blue header
                                    alignment: 'center'
                                };
                                doc.defaultStyle.fontSize = 10; // Set default font size

                                // Add borders to table cells
                                var objLayout = {};
                                objLayout['hLineWidth'] = function(i) {
                                    return 0.5;
                                }; // Horizontal line width
                                objLayout['vLineWidth'] = function(i) {
                                    return 0.5;
                                }; // Vertical line width
                                objLayout['hLineColor'] = function(i) {
                                    return '#000000';
                                }; // Horizontal line color
                                objLayout['vLineColor'] = function(i) {
                                    return '#000000';
                                }; // Vertical line color
                                objLayout['paddingLeft'] = function(i) {
                                    return 8;
                                }; // Padding left
                                objLayout['paddingRight'] = function(i) {
                                    return 8;
                                }; // Padding right
                                objLayout['paddingTop'] = function(i) {
                                    return 6;
                                }; // Padding top
                                objLayout['paddingBottom'] = function(i) {
                                    return 6;
                                }; // Padding bottom
                                doc.content[1].layout =
                                    objLayout; // Apply layout to the table (content[1] is the table)
                            }
                        },
                    ]
                });
            });
        </script>
    @endsection
