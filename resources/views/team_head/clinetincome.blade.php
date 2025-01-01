@extends('team_head.team_head_layout.sidebar')
@section('content')
    <style>
        div.dataTables_wrapper {
            position: relative;
            padding: 1.5%;
        }

        .light-style table.table-bordered.dataTable th,
        .light-style table.table-bordered.dataTable td {
            border-color: #000 !important;
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


        td {
            text-align: center;
            border-right: 1px solid #020202 !important;
        }

        .datatables-basic th {
            text-align: center !important;
            border-right: 1px solid #020202 !important;
        }

        th.sorting {
            padding: 6px 15px 10px 15px !important;

        }

        th.sorting {
            padding: 6px 15px 10px 15px !important;
            text-align: center !important;
            line-height: 1;
        }

        table.table-bordered.dataTable>:not(caption)>*:first-child {
            border: 1px solid #000;
        }

        table.dataTable.no-footer {
            border: 1px solid #000;
        }

        .table:not(.table-dark):not(.table-light) thead:not(.table-dark):not(.table-light) tr th {
            background-color: #000;
            color: #fff;
            white-space: nowrap;
        }

        .attendance-color {
            position: relative;
        }

        .attendance-color:after {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            background: red;
            height: 10px;
            width: 10px;
            clip-path: polygon(0 0, 100% 100%, 100% 0);
        }


        .tooltip-inner {
            background-color: black;

        }

        body.dark-mode .tooltip-inner {
            color: #aca8c3 !important;
        }

        .card {
            height: 100%
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

        body.dark-mode select option {
            background: #312d4b;
        }
    </style>



    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Client Income List</h5>
                        </div>
                    </div>
                    <!-- Month and Year Filter Form -->
                    <form method="GET" action="{{ route('teamhead.Clinetincome') }}">
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
                                <button type="submit" class="btn mt-5"
                                    style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;">Submit</button>
                                <button type="submit" class="btn mt-5 refresh-btn"
                                    style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;"><i
                                        class="ri-refresh-line ri-22px text-white"></i></button>
                            </div>
                        </div>
                    </form>
                    <hr class="my-0 mt-3">
                    <table class="datatables-basic table table-bordered dataTable no-footer dtr-column" id="example1">
                        <thead>
                            <tr>
                                <th>Client Name</th>
                                @php
                                    // Get number of days in selected month
                                    $daysInMonth = Carbon\Carbon::create()
                                        ->month(request('month', Carbon\Carbon::now()->month))
                                        ->year(request('year', Carbon\Carbon::now()->year))
                                        ->daysInMonth;
                                @endphp
                                @foreach (range(1, $daysInMonth) as $day)
                                    <th>{{ $day }}</th>
                                @endforeach
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Initialize daily totals for columns
                                $dailyTotals = array_fill(1, $daysInMonth, 0);
                            @endphp
                            @foreach ($data as $project)
                                @php
                                    $ClientName = $project->getClientName->name ?? 'No Name Available';
                    
                                    // Group payments by project_id and payment_date, then sum the total payments
                                    $paymentDates = collect($project->getpayment)
                                        ->groupBy(function ($item) {
                                            return Carbon\Carbon::parse($item->payment_date)->format('Y-m-d'); // Group by date
                                        })
                                        ->map(function ($group) {
                                            return $group->sum('total_payment'); // Sum payments for each group
                                        });
                    
                                    $rowTotal = 0; // Initialize row total
                                @endphp
                                <tr>
                                    <td>{{ $ClientName }}</td>
                                    @foreach (range(1, $daysInMonth) as $day)
                                        @php
                                            // Create the current date
                                            $currentDate = Carbon\Carbon::create()
                                                ->month(request('month', Carbon\Carbon::now()->month))
                                                ->year(request('year', Carbon\Carbon::now()->year))
                                                ->day($day)
                                                ->format('Y-m-d');
                    
                                            // Get total payment for the current date
                                            $dailyPayment = $paymentDates->get($currentDate, 0);
                    
                                            // Update row total and daily totals
                                            $rowTotal += $dailyPayment;
                                            $dailyTotals[$day] += $dailyPayment;
                                        @endphp
                                        <td>{{ $dailyPayment ?: '-' }}</td>
                                    @endforeach
                                    <td style="font-weight: bold;">{{ $rowTotal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                @php
                                    $grandTotal = 0;
                                @endphp
                                @foreach (range(1, $daysInMonth) as $day)
                                    @php
                                        $grandTotal += $dailyTotals[$day];
                                    @endphp
                                    <th style="font-weight: bold;">{{ $dailyTotals[$day] }}</th>
                                @endforeach
                                <th style="font-weight: bold;">{{ $grandTotal }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.refresh-btn').click(function(event) {
                // Prevent the default form submission behavior
                event.preventDefault();

                // Get the current selected month and year values
                var month = $('#month').val();
                var year = $('#year').val();

                // Construct the new URL with month and year
                var url = "{{ route('teamhead.Clinetincome') }}";

                // Reload the page with the constructed URL (this ensures the selected month and year stay)
                window.location.href = url;
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
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<span>PDF</span>', // Custom text and color
                        className: 'btn-pdf', // Add a custom class for additional styling
                        orientation: 'landscape',
                        pageSize: 'A3', // Set orientation to landscape
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
