@extends('HR.hr_layout.sidebar')
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

    .btn-secondary:hover {
        background-color: #7e4ee6 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        color: #fff !important;
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
        border-bottom: 0px solid #E6E5E8;
    }
    body.dark-mode table.dataTable.no-footer {
        border-bottom: 0px solid #474360;
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

    .card{
        height : 100%
    }



</style>



<meta name="csrf-token" content="{{ csrf_token() }}" />

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-datatable table-responsive pt-0 h-100">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0">Employee Attendance List</h5>
                    </div>
                </div>
                <!-- Month and Year Filter Form -->
                <form method="GET" action="{{ route('hr.employee_attendance') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="month">Select Month</label>
                            <select name="month" id="month" class="form-control">
                                @foreach(range(1, 12) as $month)
                                <option value="{{ $month }}" {{ request('month', Carbon\Carbon::now()->month) == $month ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="year">Select Year</label>
                            <select name="year" id="year" class="form-control">
                                @foreach(range(2020, Carbon\Carbon::now()->year) as $year)
                                <option value="{{ $year }}" {{ request('year', Carbon\Carbon::now()->year) == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary mt-5" style="background-color: #7e4ee6;color: #fff;">Submit</button>
                            <button type="submit" class="btn btn-primary mt-5 refresh-btn" style="background-color: #7e4ee6;"><i class="ri-refresh-line ri-22px text-white"></i></button>
                        </div>
                    </div>
                </form>
                <hr class="my-0 mt-3">
                <table class="datatables-basic table table-bordered dataTable no-footer dtr-column" id="example1" aria-describedby="DataTables_Table_0_info" style="width: 1395px;">
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Salary</th>
                            @php
                            // Calculate the number of days in the selected month
                            $daysInMonth = Carbon\Carbon::create()->month(request('month', Carbon\Carbon::now()->month))->daysInMonth;
                            @endphp
                            @foreach (range(1, $daysInMonth) as $day)
                            <th>{{ $day }}</th>
                            @endforeach
                            <th>Total</th>
                            <th>Per Day</th>
                            <th>Grand Total</th>
                            <th>Over Time</th>
                            <th>Benefits</th>
                            <th>Deducation (-)</th>
                            <th>Adjustment (+)</th>
                            <th>Paid Leave</th>
                            <th>Sub Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                     
                        @foreach ($data as $empId => $attendances)
                        @php
                        $employeeName = $attendances->first()->get_emp_name->emo_name ?? 'No Name Available';
                        $totalAttendance = 0; // Initialize total attendance count
                        $paidLeaveTaken = false; // Initialize flag to track if paid leave is taken
                        $workingDays = 0; // Initialize working days count

                        // Loop through each day of the month and exclude Sundays and 2nd/4th Saturdays
                        foreach (range(1, $daysInMonth) as $day) {
                        $currentDate = Carbon\Carbon::createFromDate(
                        request('year', Carbon\Carbon::now()->year),
                        request('month', Carbon\Carbon::now()->month),
                        $day
                        );

                        // Check if the day is a Sunday
                        $isSunday = $currentDate->isSunday();

                        // Check if it's Saturday and if it's in the 2nd or 4th week of the month
                        $isSecondOrFourthSaturday = $currentDate->isSaturday() && (ceil($day / 7) == 2 || ceil($day / 7) == 4);

                        // Count the day as a working day if it's not a Sunday and not a 2nd or 4th Saturday
                        if (!$isSunday && !$isSecondOrFourthSaturday) {
                        $workingDays++;
                        }
                        }

                        // Fetch OT amount for the employee
                        $otAmount = app()->call('App\Http\Controllers\AttendanceController@getOt', [
                            'id' => $empId,
                            'month' => request('month', Carbon\Carbon::now()->month),
                            'year' => request('year', Carbon\Carbon::now()->year)
                        ]);
                        
                        $getpl = app()->call('App\Http\Controllers\AttendanceController@getPL', [
                            'id' => $empId,
                            'month' => request('month', Carbon\Carbon::now()->month),
                            'year' => request('year', Carbon\Carbon::now()->year)
                        ]);
                        $dedunction = app()->call('App\Http\Controllers\AttendanceController@getdedunction', [
                            'id' => $empId,
                            'month' =>  request('month', Carbon\Carbon::now()->month),
                            'year' => request('year', Carbon\Carbon::now()->year)
                        ]);
                        $getadjustment = app()->call('App\Http\Controllers\AttendanceController@getadjustment', [
                            'id' => $empId,
                            'month' =>  request('month', Carbon\Carbon::now()->month),
                            'year' => request('year', Carbon\Carbon::now()->year)
                        ]);
                        $Benefits = app()->call('App\Http\Controllers\AttendanceController@getbenefits', [
                            'id' => $empId,
                            'month' =>  request('month', Carbon\Carbon::now()->month),
                            'year' => request('year', Carbon\Carbon::now()->year)
                        ]);

                   
                        @endphp
                        <tr>
                            <td class="employee-name" style="white-space: nowrap;">{{ $employeeName }}</td>
                            <td class="employee-name">{{ $attendances->first()->get_emp_name->monthly_selery }}</td>
                            @foreach (range(1, $daysInMonth) as $day)
                            @php
                            $currentDate = Carbon\Carbon::createFromDate(
                            request('year', Carbon\Carbon::now()->year),
                            request('month', Carbon\Carbon::now()->month),
                            $day
                            );

                            // Check if the day is Sunday
                            $isSunday = $currentDate->isSunday();

                            // Check if it's Saturday and if it's in the 2nd or 4th week of the month
                            $isSecondOrFourthSaturday = $currentDate->isSaturday() && (ceil($day / 7) == 1 || ceil($day / 7) == 3);

                            // Mark the day as a holiday if it's Sunday or 2nd/4th Saturday
                            $isHoliday = $isSunday || $isSecondOrFourthSaturday;

                            $attendanceForDay = $attendances->firstWhere('today_date', $currentDate->toDateString());
                            

                            // Determine the background color based on the attendance status
                            if ($attendanceForDay) {
                            if ($attendanceForDay->status == 0) {
                            $bgColor = '#ff00004a'; // Status 0 - red background    
                            $totalAttendance += 0; // Add to total
                            } elseif ($attendanceForDay->status == 1) {
                            $bgColor = '#00800021'; // Status 1 - green background
                            $totalAttendance += 1; // Add to total
                            } elseif ($attendanceForDay->status == 2) {
                            $bgColor = '#ffff0042'; // Status 2 - yellow background
                            $totalAttendance += 0.5; // Add to total
                            } else {
                            $bgColor = ''; // No background for other statuses
                            }
                            } else {
                            $bgColor = ''; // No background if no attendance data
                            }
                            @endphp
                           <td class="attendance-cell {{ $attendanceForDay && $attendanceForDay->notes ? 'attendance-color' : '' }}" 
                                data-toggle="tooltip"   data-bs-placement="right"
                                title="{{ $attendanceForDay && $attendanceForDay->notes ? $attendanceForDay->notes : '' }}" 
                                style="{{ $isHoliday ? 'background-color: #ff00004a; color: black;' : 'background-color: ' . $bgColor . ';' }}">

                                @if ($isHoliday)
                                <strong><span>0</span></strong>
                                @elseif ($attendanceForDay)
                                @if ($attendanceForDay->status == 0)
                                <strong><span style="color: black;">0</span></strong>
                                @elseif ($attendanceForDay->status == 1)
                                <strong><span style="color: green;">1</span></strong>
                                @elseif ($attendanceForDay->status == 2)
                                <strong><span style="color: #ff8f00;">0.5</span></strong>
                                @elseif ($attendanceForDay->status == 3)
                                <i class="fa fa-question-circle" style="color: orange;"></i>
                                @endif
                                @else
                                <span style="color: gray;">-</span>
                                @endif
                            </td>
                            @endforeach
                            <!-- Add Total Column -->
                            <td class="total-attendance">
                                <strong>{{ $totalAttendance }}</strong>
                            </td>
                            <td>
                                
                                    @if ($workingDays > 0)
                                    {{ number_format($attendances->first()->get_emp_name->monthly_selery / $workingDays) }}
                                    @else
                                    {{ number_format(0) }} 
                                    @endif
                               
                            </td>

                           <td class="grand-total">
                                @php
                                    $monthlySalary = $attendances->first()->get_emp_name->monthly_selery ?? 0; 
                   
                                    $totalAttendance = is_numeric($totalAttendance) ? $totalAttendance : 2;

                                    // Ensure numeric conversion
                                    $perday = is_numeric($monthlySalary) && $monthlySalary > 0
                                                ? number_format($monthlySalary / $workingDays, 0, '.', '')
                                                : 0;

                                    $grandTotal = is_numeric($perday) ? $perday * $totalAttendance : 0;
                                   
                                @endphp
                                {{ number_format($grandTotal, 0) }}
                            </td>
                            <td>{{ number_format($otAmount, 0) }}</td> 
                            <td>{{ number_format($Benefits, 0) }}</td>
                        <td>
                         <span class="export-value" style="display: none;">{{$dedunction->amont ?? ''}}</span>
                            <form action="{{route('admin.storeAdjustment')}}" method="POST" style="display: flex;">
                                @csrf
                                <input type="hidden" value="{{$dedunction->id ?? ''}}" name="id">
                                <input class="form-control" style="height: 30px;" type="text" value="{{$dedunction->amont ?? ''}}" name="amont" placeholder="Enter value">
                                <input type="hidden" value="{{ $attendances->first()->get_emp_name->id }}" name="emp_id">
                                <input type="hidden" name="datea_and_month" value="{{ request('month', Carbon\Carbon::now()->month)}}">
                                <input type="hidden" name="date_and_year" value="{{ request('year', Carbon\Carbon::now()->year)}}">
                                <input type="hidden" name="dedunction" value="1">
                                <button type="submit" style="border: none; background: none;"><i class="ri-save-3-line"></i></button>
                            </form>
                        </td>
                        <td>
                            <span class="export-value" style="display: none;">{{$getadjustment->amont ?? ''}}</span>
                            <form action="{{route('admin.storeAdjustment')}}" method="POST" style="display: flex;">
                                @csrf
                                <input type="hidden" value="{{$getadjustment->id ?? ''}}" name="id">
                                <input class="form-control" style="height: 30px;" value="{{$getadjustment->amont ?? ''}}" type="text" name="amont" placeholder="Enter value">
                                  <input type="hidden" value="{{ $attendances->first()->get_emp_name->id }}" name="emp_id">
                                <input type="hidden" name="datea_and_month" value="{{ request('month', Carbon\Carbon::now()->month)}}">
                                <input type="hidden" name="date_and_year" value="{{ request('year', Carbon\Carbon::now()->year)}}">
                                <input type="hidden" name="adjustment" value="1">
                                <button style="border: none;background: none;" type="submit"><i class="ri-save-3-line"></i></button>
                            </form>
                        </td>
                            <td>{{$getpl}}</td>
                           <td>
                                    @php
                                        $subTotal = $grandTotal + (is_numeric($otAmount) ? $otAmount : 0) + (is_numeric($Benefits) ? $Benefits : 0) +
                                                    ($getadjustment->amont ?? 0) - 
                                                    ($dedunction->amont ?? 0);

                                        $month = request('month', Carbon\Carbon::now()->month);
                                        $year =  request('year', Carbon\Carbon::now()->year);
                                        $perday = $attendances->first()->get_emp_name->monthly_selery / $workingDays;
                                    @endphp
                                    @if($getpl == 0)
                                      {{ number_format(floatval($subTotal) + floatval($perday)) , 0}}

                                    @else
                                        {{ number_format($subTotal, 0)}}
                                    @endif
                                </td>
                               <td>
                                   <a href="{{ url('admin/salary-slip-priview/' . $attendances->first()->get_emp_name->id . '/' . $month . '/' . $year) }}" target="_blank">
                                            <i class="ri-chat-forward-line"></i>
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
            var url = "{{ route('hr.employee_attendance') }}";

            // Reload the page with the constructed URL (this ensures the selected month and year stay)
            window.location.href = url;
        });
    });

</script>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
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
                    text: '<span style="color: green; font-weight: bold;">Excel</span>', // Custom text and color
                    className: 'btn-excel', // Add a custom class for additional styling
                },
                {
                    extend: 'pdfHtml5',
                    text: '<span style="color: red; font-weight: bold;">PDF</span>', // Custom text and color
                    className: 'btn-pdf', // Add a custom class for additional styling
                    orientation: 'landscape',
                    pageSize: 'A2', // Set orientation to landscape
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
                        objLayout['hLineWidth'] = function(i) { return 0.5; }; // Horizontal line width
                        objLayout['vLineWidth'] = function(i) { return 0.5; }; // Vertical line width
                        objLayout['hLineColor'] = function(i) { return '#000000'; }; // Horizontal line color
                        objLayout['vLineColor'] = function(i) { return '#000000'; }; // Vertical line color
                        objLayout['paddingLeft'] = function(i) { return 8; }; // Padding left
                        objLayout['paddingRight'] = function(i) { return 8; }; // Padding right
                        objLayout['paddingTop'] = function(i) { return 6; }; // Padding top
                        objLayout['paddingBottom'] = function(i) { return 6; }; // Padding bottom
                        doc.content[1].layout = objLayout; // Apply layout to the table (content[1] is the table)
                    }
                },
            ]
        });
    });
</script>



@endsection
