@extends('HR.hr_layout.sidebar')
@section('content')
   <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
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

        .list-btn {
            color: #8b8693;
        }

        .btn-secondary:hover {
            background-color: #7e4ee6 !important;
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
        body.dark-mode section.mdtp__time_holder
        {
            color: #b0acc7 !important;
        }
        body.dark-mode span.mdtp__button.cancel
        {
            color: #b0acc7 !important;
        }
        body.dark-mode .mdtp__button.ok
        {
            color: #b0acc7 !important;
        }
        body.dark-mode select.form-control.emp_id {
            background-color: #312d4b;
        }
        body.dark-mode select.form-control#month {
            background-color: #312d4b !important;
        }
        body.dark-mode select.form-control#year {
            background-color: #312d4b !important;
        }
    </style>



    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Today's Attendance</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons btn-group flex-wrap">
                                <a class="add_recode"><button style="color: #f0f8ff;"
                                        class="btn  create-new  waves-effect waves-light employee"
                                        tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i
                                                class="ri-add-line"></i> <span class="d-none d-sm-inline-block">Add New
                                                Record</span></span>
                                    </button></a>
                            </div>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('admin.today.attendance') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="month">Select Month</label>
                                <select name="month" id="month" class="form-control">
                                    @foreach (range(1, 12) as $month)
                                        <option value="{{ $month }}"
                                            {{ request('month', Carbon\Carbon::now()->month) == $month ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="year">Select Year</label>
                                <select name="year" id="year" class="form-control">
                                    @foreach (range(2020, Carbon\Carbon::now()->year) as $year)
                                        <option value="{{ $year }}"
                                            {{ request('year', Carbon\Carbon::now()->year) == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn  mt-5"
                                    style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color:white">Submit</button>
                                <button type="submit" class="btn  mt-5 refresh-btn"
                                    style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;"><i
                                        class="ri-refresh-line ri-22px text-white"></i></button>
                            </div>
                        </div>
                    </form>
                    <hr class="my-0 mt-3">
                    <table class="datatables-basic table table-bordered dataTable no-footer dtr-column" id="example1"
                        aria-describedby="DataTables_Table_0_info" style="width: 1395px;">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select_all">
                                </th>
                                <th>Sr No.</th>
                                <th>Attendance Date</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>First In</th>
                                <th>Last Out</th>
                                <th>Working Hour</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="select_row" data-id="{{$item->id}}">
                                    </td>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->today_date)->format('d-m-y') }}</td>
                                    <td>{{ $item->user_name }}</td>
                                    <td>{{ $item->de_name }}</td>
                                    <td>
                                        @if ($item->first_in != null)
                                            {{ \Carbon\Carbon::parse($item->first_in)->format('h:i:s A') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->last_out != null)
                                            {{ \Carbon\Carbon::parse($item->last_out)->format('h:i:s A') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->first_in && $item->last_out)
                                            @php
                                                // Parse the first_in and last_out times
                                                $firstIn = \Carbon\Carbon::parse($item->first_in);
                                                $lastOut = \Carbon\Carbon::parse($item->last_out);

                                                // Define fixed lunch break start and end times
                                                $lunchStart = \Carbon\Carbon::createFromTime(13, 0); // 1:00 PM
                                                $lunchEnd = \Carbon\Carbon::createFromTime(13, 45); // 1:45 PM

                                                // Calculate the difference between first_in and last_out
                                                $workingDiff = $firstIn->diff($lastOut);

                                                // Get the total hours and minutes from the difference
                                                $totalHours = $workingDiff->h;
                                                $totalMinutes = $workingDiff->i;

                                                // Check if lunch break should be deducted
                                                $breakTime = 0; // Default: no break time deduction
                                                if ($firstIn->lt($lunchStart) && $lastOut->gt($lunchEnd)) {
                                                    // If first_in is before lunch and last_out is after lunch, deduct 45 minutes
                                                    $breakTime = 45; 
                                                }

                                                // Subtract the break time from the total working time
                                                $totalMinutes -= $breakTime;

                                                // Adjust if minutes become negative after subtraction
                                                if ($totalMinutes < 0) {
                                                    $totalMinutes += 60; // Add 60 minutes to totalMinutes
                                                    $totalHours--; // Subtract 1 hour from totalHours
                                                }

                                                // If totalMinutes >= 60, add to totalHours
                                                $totalHours += intdiv($totalMinutes, 60);
                                                $totalMinutes %= 60;
                                            @endphp

                                            <!-- Display the result with styling depending on hours worked -->
                                            <span style="color: {{ $totalHours >= 8 ? 'green' : 'red' }}">
                                                {{ $totalHours }} hours {{ $totalMinutes }} minutes
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $item->notes }}</td>

                                    <td>
                                        @if ($item->status == 0)
                                            <div>Absent</div>
                                        @elseif($item->status == 1)
                                            <div>Present</div>
                                        @else
                                            <div>Half Day</div>
                                        @endif
                                    </td>
                                    <td><a class="edit" href="#" data-id='{{ $item->id }}'
                                            data-first_in='{{ $item->first_in }}'
                                            data-today_date='{{ \Carbon\Carbon::parse($item->today_date)->format('d-m-Y') }}'
                                            data-notes='{{ $item->notes }}'
                                            data-last_out='{{ $item->last_out }}' 
                                            data-status='{{ $item->status }}'
                                            data-emp_id='{{ $item->emp_id }}'>
                                            <i class="ri-edit-box-line ri-22px list-btn"></i>
                                        </a>
                                        <a href="#" class="delete" data-id='{{ $item->id }}'>
                                            <i class="ri-delete-bin-7-line ri-22px list-btn"></i>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                    <button class="dt-button buttons-delete btn btn-danger buttons-html5 btn-delete" tabindex="0" aria-controls="example" type="button" style="display:none !important;" id="delete_button">
                        <i class="ri-delete-bin-7-line ri-22px"></i>
                    </button>
                </div>
            </div>
        </div>



        <div class="offcanvas offcanvas-end" id="todaymodal" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">Add Attendance</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="{{ route('hr.attendance.store') }}" method="post" id="password" enctype="multipart/form-data"
                    class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    @csrf
                    <!-- Employee Name -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-user-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select class="form-control emp_id" name="emp_id"  required>
                                    <option value="">Select Employee Name</option>
                                      
                                    @foreach ($user as $item)
                                        <option value="{{ $item->id }}">{{ $item->emo_name }}</option>
                                    @endforeach
                                </select>
                                {{-- <label for="basicFullname">Employee Name</label> --}}
                            </div>
                        </div>
                    </div>
                    <!-- Today Date -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-calendar-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control dob-picker" name="today_date"
                                    placeholder="Enter Today Date" required readonly>
                                <label for="basicFullname">Today Date</label>
                            </div>
                        </div>
                    </div>
                    <!-- First In -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-time-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control timepicker" name="first_in"
                                    placeholder="Enter First In">
                                <label for="basicFullname">First In</label>
                            </div>
                        </div>
                    </div>
                    <!-- Last Out -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-time-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control timepicker" name="last_out"
                                    placeholder="Enter Last Out">
                                <label for="basicFullname">Last In</label>
                            </div>
                        </div>
                    </div>
                    <!-- Status -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-checkbox-circle-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select class="form-control emp_id" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="0">Absent</option>
                                    <option value="1">Present</option>
                                    <option value="2">Half Day</option>
                                </select>
                                <label for="basicFullname">Status</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-time-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="notes" placeholder="Enter Notes">
                                <label for="basicFullname">Notes</label>
                            </div>
                        </div>
                    </div>
                    <!-- Submit and Cancel Buttons -->
                    <div class="col-sm-12">
                        <button type="submit" class="btn data-submit me-sm-4 me-1 waves-effect waves-light"
                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- edit add department  -->
        <div class="offcanvas offcanvas-end" id="editmodal" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">Edit Attendance</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="{{ route('hr.attendance.update') }}" method="post" id="password"
                    enctype="multipart/form-data"
                    class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    @csrf
                    <!-- Employee Name -->
                    <input type="hidden" id="id" name="id">
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-user-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select class="form-control emp_id" name="emp_id" id="emp_id" required>
                                    <option value="">Select Employee Name</option>
                                    @foreach ($user as $item)
                                        <option value="{{ $item->id }}">{{ $item->emo_name }}</option>
                                    @endforeach
                                </select>
                                <label for="basicFullname">Employee Name</label>
                            </div>
                        </div>
                    </div>
                    <!-- Today Date -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-calendar-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control dob-picker" name="today_date" id="today_date"
                                    placeholder="Enter Today Date" required readonly>
                                <label for="basicFullname">Today Date</label>
                            </div>
                        </div>
                    </div>
                    <!-- First In -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-time-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control timepicker" name="first_in" id="first_in"
                                    placeholder="Enter First In">
                                <label for="basicFullname">First In</label>
                            </div>
                        </div>
                    </div>
                    <!-- Last Out -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-time-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control timepicker" name="last_out" id="last_out"
                                    placeholder="Enter Last Out">
                                <label for="basicFullname">Last In</label>
                            </div>
                        </div>
                    </div>
                    <!-- Status -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-checkbox-circle-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select class="form-control emp_id" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="0">Absent</option>
                                    <option value="1">Present</option>
                                    <option value="2">Half Day</option>

                                </select>
                                <label for="basicFullname">Status</label>
                            </div>
                        </div>
                    </div>
                    <!-- Last Out -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-time-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="notes" id="notes"
                                    placeholder="Enter Notes">
                                <label for="basicFullname">Notes</label>
                            </div>
                        </div>
                    </div>
                    <!-- Submit and Cancel Buttons -->
                    <div class="col-sm-12">
                        <button type="submit" class="btn  data-submit me-sm-4 me-1 waves-effect waves-light"
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
                <h5 class="offcanvas-title" id="deleteExampleModalLabel">Delete Attendance</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <h5 class="text-center">Are you sure you want to delete this Attendance?</h5>
                <form action="{{ route('hr.attendance.delete') }}" method="POST" id="delete-form">
                    @csrf
                    <input type="hidden" name="ids" id="delete-ids"> <!-- Hidden field to store the selected IDs -->
                    <div class="col-sm-12">
                        <button type="submit" class="btn  waves-effect waves-light"
                                style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color:white">Delete
                        </button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.refresh-btn').click(function(event) {
                // Prevent the default form submission behavior
                event.preventDefault();

                // Get the current selected month and year values
                var month = $('#month').val();
                var year = $('#year').val();

                // Construct the new URL with month and year
                var url = "{{ route('hr.today.attendance') }}";

                // Reload the page with the constructed URL (this ensures the selected month and year stay)
                window.location.href = url;
            });

               $('#add_emp_id').select2();
        });


        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize DataTables without buttons first

            $(document).on('click', '.employee', function(event) {
                event.preventDefault();
                const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('todaymodal'));
                offcanvasEdit.show();
            });


            $(document).on('click', '.edit', function(event) {
                event.preventDefault();

                var id = $(this).data('id');
                var today_date = $(this).data('today_date');
                var first_in = $(this).data('first_in');
                var last_out = $(this).data('last_out');
                var status = $(this).data('status');
                var emp_id = $(this).data('emp_id');
                var notes = $(this).data('notes');

                const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('editmodal'));
                offcanvasEdit.show();

                // Fill the modal fields with the selected row's data
                $('#first_in').val(first_in);
                $('#today_date').val(today_date);
                $('#last_out').val(last_out);
                $('#status').val(status);
                $('#emp_id').val(emp_id);
                $('#notes').val(notes);
                $('#id').val(id);  // Set the hidden input for the record's ID
            });

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
                        orientation: 'landscape',
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

<script>
   $(document).ready(function() {
    // Function to toggle the Delete button visibility based on selected checkboxes
    function toggleDeleteButton() {
        var selectedCount = $('.select_row:checked').length; // Count how many checkboxes are checked
        if (selectedCount > 0) {
            $('#delete_button').attr('style', 'display: block !important;'); // Show the delete button
        } else {
            $('#delete_button').attr('style', 'display: none !important;'); // Hide the delete button
        }
    }

    // Select/Deselect all checkboxes when the 'Select All' checkbox is clicked
    $('#select_all').on('click', function() {
        var isChecked = $(this).prop('checked'); // Get the checked status of 'Select All'
        $('.select_row').prop('checked', isChecked); // Set the checked status of all rows
        toggleDeleteButton(); // Update Delete button visibility
    });

    // Update the 'Select All' checkbox based on individual row checkboxes
    $('.select_row').on('click', function() {
        var allChecked = $('.select_row').length === $('.select_row:checked').length; // Check if all checkboxes are selected
        $('#select_all').prop('checked', allChecked); // Update 'Select All' checkbox
        toggleDeleteButton(); // Update Delete button visibility
    });

    // Handle the Delete button click for multiple selected rows
    $('#delete_button').on('click', function() {
        var selectedIds = $('.select_row:checked').map(function() {
            return $(this).data('id'); // Get the ID of each selected row
        }).get();
        
        if (selectedIds.length > 0) {
            // Show confirmation modal for multiple deletions
            const offcanvasdelete = new bootstrap.Offcanvas(document.getElementById('deletemodal'));
            offcanvasdelete.show();
            $('#delete-ids').val(selectedIds.join(',')); // Join the selected IDs with commas for multiple deletions
        }
    });

    // Handle the individual delete button click
    $(document).on('click', '.delete', function(event) {
        var id = $(this).data('id'); // Get the ID of the selected row
        event.preventDefault();

        // Show confirmation modal for a single deletion
        const offcanvasdelete = new bootstrap.Offcanvas(document.getElementById('deletemodal'));
        offcanvasdelete.show();
        $('#delete-ids').val(id); // Set the ID of the single row to be deleted
    });
});

</script>
@endsection
