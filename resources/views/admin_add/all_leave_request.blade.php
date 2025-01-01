@extends('admin_layout.sidebar')
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

        a.chosen-single {
            height: 47px !important;
            padding: 11px !important;
            background: #ffffff !important;

        }

        body.dark-mode a.chosen-single {
            background: #312d4b !important;
            color: #cbc8e0 !important;
            border-color: #595572;
        }

        body.dark-mode .chosen-drop {
            background: #312d4b !important;
        }

        body.dark-mode ul.chosen-results {
            color: #c2bed8 !important;
        }

        b {
            margin-top: 12px;
        }

        table#example1 th.sorting {
            overflow-x: auto;
            white-space: nowrap;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header border-bottom">
                <h6 class="card-title mb-0">Filters</h6>
                <form method="GET" action="{{ route('admin.leave_request_list') }}">
                    <div class="d-flex align-items-center row pt-4 pb-2 gap-3 gx-5">
                        <!-- Search by Name -->
                        <div class="col-md-3 fv-plugins-icon-container">
                            <div class="input-group input-group-merge">
                                <span id="basicFullname4" class="input-group-text"><i class="ri-search-line"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <select name="search_name" id="search_name" class="form-control multipleChosen"
                                        data-placeholder="Select Employee Name">
                                        <option></option>
                                        @foreach ($getEmployee as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ request('search_name') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->emo_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="search_name">Search by Name</label>
                                </div>
                            </div>
                        </div>

                        <!-- From Date -->
                        <div class="col-md-2 fv-plugins-icon-container">
                            <div class="input-group input-group-merge">
                                <span id="basicFullname1" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" readonly name="from_date" id="edit_from_date"
                                        placeholder="Select from date" class="form-control dob-picker"
                                        value="{{ request('from_date') }}">
                                    <label for="edit_from_date">From Date</label>
                                </div>
                            </div>
                        </div>

                        <!-- To Date -->
                        <div class="col-md-2 fv-plugins-icon-container">
                            <div class="input-group input-group-merge">
                                <span id="basicFullname2" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" readonly name="to_date" id="edit_to_date"
                                        placeholder="Select to date" class="form-control dob-picker"
                                        value="{{ request('to_date') }}">
                                    <label for="edit_to_date">To Date</label>
                                </div>
                            </div>
                        </div>

                        <!-- Status Dropdown -->
                        <div class="col-md-2 fv-plugins-icon-container">
                            <div class="input-group input-group-merge">
                                <span id="basicFullname3" class="input-group-text"><i class="ri-checkbox-line"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <select name="status" id="FilterTransaction" class="form-select text-capitalize">
                                        <option value="">Select Status</option>
                                        <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>
                                            Approved</option>
                                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>
                                            Rejected</option>
                                    </select>
                                    <label for="FilterTransaction">Status</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 fv-plugins-icon-container">
                            <div class="input-group input-group-merge gap-3">
                                <button type="submit" class="btn btn-primary submit_button waves-effect waves-light"
                                    style="  background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color:white;    border-radius: .375rem !important;border: none !important;">Submit</button>
                                <button type="button" class="btn btn-primary refresh-btn waves-effect waves-light"
                                    style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;    border-radius: .375rem !important;color:white;border: none !important;"
                                    id="refreshFilters">
                                    <i class="ri-refresh-line ri-22px"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">All Leave Request</h5>
                        </div>
                    </div>
                    <hr class="my-0">
                    <table class="datatables-basic table table-bordered dataTable no-footer dtr-column" id="example1"
                        aria-describedby="DataTables_Table_0_info" style="width: 1395px;">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Employee Name</th>
                                <th>Apply Date</th>
                                <th>Leave Type</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Reason</th>
                                <th>Team Head Status</th>
                                <th>Status </th>
                                <th>Team Head Reject Reason</th>
                                <th>Reject Reason</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->admin->emo_name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                    <td>{{ $item->leaveType->leave_type ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->from_date)->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($item->to_date != null)
                                            {{ \Carbon\Carbon::parse($item->to_date)->format('d-m-Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="details-display">
                                            <!-- Initially show the first 20 characters of details -->
                                            <span class="details-short">{{ \Str::limit($item->leave_reason, 20) }}</span>

                                            <!-- Show "Show More" link if details are longer than 20 characters -->
                                            @if (strlen($item->leave_reason) > 20)
                                                <span class="details-more">
                                                    <a href="javascript:void(0)" class="show-more">Show More</a>
                                                </span>
                                            @endif

                                            <!-- Full details that will be shown when "Show More" is clicked -->
                                            <span class="details-full"
                                                style="display: none;">{{ $item->leave_reason }}</span>

                                            <!-- Show Less link -->
                                            <span class="show-less" style="display: none;">
                                                <a href="javascript:void(0)" class="show-less">Show Less</a>
                                            </span>
                                        </span>
                                    </td>
                                    <td>
                                        @if ($item->team_head_status == null)
                                            <div></div>
                                        @elseif($item->team_head_status == 0)
                                            <div style="color: red">Rejected</div>
                                        @elseif($item->team_head_status == 1)
                                            <div style="color: green">Approved</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == null)
                                            <div></div>
                                        @elseif($item->status == 0)
                                            <div style="color: red">Rejected</div>
                                        @elseif($item->status == 1)
                                            <div style="color: green">Approved</div>
                                        @endif
                                    </td>
                                    <td>{{ $item->team_head_rejected_reasons ?? '' }}</td>
                                    <td>{{ $item->rejected_reason ?? '' }}</td>

                                    <td>
                                        <a class="edit" href="#" data-id='{{ $item->id }}'
                                            data-status='{{ $item->status }}'
                                            data-rejected_reason='{{ $item->rejected_reason }}'>
                                            <i class="ri-check-line ri-22px list-btn"></i>
                                        </a>

                                        <a href="#" class="delete" data-id='{{ $item->id }}'>
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

        <!-- edit add Holiday  -->
        <div class="offcanvas offcanvas-end" id="leaveModal" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="">Leave Approved & Rejected</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="{{ route('admin.leave_approved') }}" method="post" id="password"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id">

                    <!-- Status Radio Buttons -->
                    <div>
                        <input type="radio" name="status" value="1" id="leave_approved" required />
                        <label for="leave_approved">Approved</label>
                        <input type="radio" name="status" value="0" id="leave_rejected"
                            style="margin-left: 15px" required />
                        <label for="leave_rejected">Rejected</label>
                    </div>
                    <br>

                    <!-- Rejected Reason (Initially Hidden) -->
                    <div id="errorexpanded" class="mb-3 attempt_reason" style="display: none;">
                        <label>Reject Reason <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="rejected_reason" id="rejected_reason"
                            required />
                    </div>

                    <div class="mt-3">
                        <button type="submit" id="submitButton" class="text-white p-2 border-0 rounded px-3 fw-bold send_inquiry_btn"
                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;">Submit</button>
                    </div>
                </form>

            </div>
        </div>

        <!-- Delete Confirmation Modal (Offcanvas) -->
        <div class="offcanvas offcanvas-end" id="deletemodal" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="deleteExampleModalLabel">Delete Leave</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <h5 class="text-center">Are you sure you want to delete this Leave?</h5>
                <form action="{{ Route('admin.delete_leave_request_admin') }}" method="POST" id="delete-form">
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
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            // Listen for the click on the Edit button
            $(document).on('click', '.edit', function(event) {
                event.preventDefault();

                // Get data attributes from the clicked button
                var id = $(this).data('id');
                var status = $(this).data('status');
                var rejected_reason = $(this).data('rejected_reason');

                // Open the modal
                // $('#add-new-record').offcanvas('show');
                const offcanvasDelete = new bootstrap.Offcanvas(document.getElementById('leaveModal'));
                offcanvasDelete.show();

                // Set the form inputs with the fetched data
                $('#id').val(id);
                $('#rejected_reason').val(rejected_reason);

                // Set the radio button based on the status
                if (status == "1") {
                    $("#leave_approved").prop("checked", true);
                } else if (status == "0") {
                    $("#leave_rejected").prop("checked", true);
                }

                // Show/hide the reject reason input based on status
                if (status == "0") {
                    $("#errorexpanded").show();
                } else {
                    $("#errorexpanded").hide();
                }
            });

            // Change handler for the status radio buttons
            $('input[type="radio"][name="status"]').on('change', function() {
                if (this.value == "0") {
                    $("#errorexpanded").show();
                    $('#rejected_reason').prop('required', true);
                } else {
                    $("#errorexpanded").hide();
                    $('#rejected_reason').prop('required', false);
                }
            });

            $(document).on('click', '.delete', function(event) {
                var id = $(this).data('id');
                event.preventDefault();
                const offcanvasdelete = new bootstrap.Offcanvas(document.getElementById('deletemodal'));
                offcanvasdelete.show();
                $('#delete-id').val(id)

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Submit Filters
            $('#submitFilters').click(function() {
                // Gather filter values
                var fromDate = $('#edit_from_date').val();
                var toDate = $('#edit_to_date').val();
                var status = $('#FilterTransaction').val();
                var searchName = $('#search_name').val();

                // Redirect with query parameters
                var url = "{{ route('admin.leave_request_list') }}?from_date=" + fromDate + "&to_date=" +
                    toDate + "&status=" + status + "&search_name=" + searchName;

                window.location.href = url;
            });

            // Reset Filters
            $('#refreshFilters').click(function() {
                // Clear all filters
                $('#edit_from_date').val('');
                $('#edit_to_date').val('');
                $('#FilterTransaction').val('');
                $('#search_name').val('');

                // Optionally, redirect to the default route to refresh the page
                window.location.href = "{{ route('admin.leave_request_list') }}";
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
        $(document).ready(function() {
            //Chosen
            $(".multipleChosen").chosen({});
        })
    </script>
    <script>
        // jQuery to toggle between Show More and Show Less
        $(document).ready(function() {
            $('.show-more').click(function() {
                var parent = $(this).closest('.details-display');
                parent.find('.details-short').hide(); // Hide the short text
                parent.find('.details-more').hide(); // Hide the "Show More" link
                parent.find('.details-full').show(); // Show the full details
                parent.find('.show-less').show(); // Show the "Show Less" link
            });

            $('.show-less').click(function() {
                var parent = $(this).closest('.details-display');
                parent.find('.details-short').show(); // Show the short text
                parent.find('.details-more').show(); // Show the "Show More" link
                parent.find('.details-full').hide(); // Hide the full details
                parent.find('.show-less').hide(); // Hide the "Show Less" link
            });
        });
    </script>
    <script>
        document.getElementById('password').addEventListener('submit', function(event) {
            const submitButton = document.getElementById('submitButton');
            submitButton.innerHTML = 'Submitting...';
            submitButton.disabled = true;
        });
        // Show/Hide Reject Reason based on selection
        document.getElementById('leave_rejected').addEventListener('change', function() {
            document.getElementById('errorexpanded').style.display = 'block';
        });
        document.getElementById('leave_approved').addEventListener('change', function() {
            document.getElementById('errorexpanded').style.display = 'none';
        });
    </script>
@endsection
