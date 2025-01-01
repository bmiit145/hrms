@extends('admin_layout.sidebar')

@section('content')

{{-- fa fa icon sacript  --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

  {{-- data-table css  --}}
<link  rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css"/>

<style>
    html:not(.layout-footer-fixed) .content-wrapper {
        padding-bottom: 431px !important;
    }
    .attendance-table {
        margin-top: 10px;
    }
    .attendance-cell {
        text-align: center;
        vertical-align: middle;
        padding: 10px;
    }
    .attendance-icons i {
        font-size: 18px;
        display: block;
        margin: 0 auto;
    }
    .employee-name {
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
        padding: 10px;
        background-color: #f9f9f9;
    }
    td, th {
        text-align: center;
    }
    .no-data {
        color: gray;
    }
</style>

<h4 style="color: black">Employee Attendance List</h4>



<!-- Month and Year Filter Form -->
<form method="GET" action="{{ route('admin.employee.attendance') }}">
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
            <button type="submit" class="btn btn-primary mt-4">Submit</button>
            <button type="submit" class="btn btn-primary mt-4 refresh-btn" style="height: 40px;"><i class="fa fa-refresh" aria-hidden="true"></i></button>
        </div>
    </div>
</form>

<!-- Attendance Table -->
<div class="card">
    <div class="table-responsive text-nowrap">
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    @php
                        // Calculate the number of days in the selected month
                        $daysInMonth = Carbon\Carbon::create()->month(request('month', Carbon\Carbon::now()->month))->daysInMonth;
                    @endphp
                    @foreach (range(1, $daysInMonth) as $day)
                        <th>{{ $day }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            @foreach ($data as $empId => $attendances)
                @php
                    $employeeName = $attendances->first()->get_emp_name->emo_name ?? 'No Name Available';
                @endphp

                <!-- Display Employee Name in a Separate Row -->
                <tr>
                    <td class="employee-name">{{ $employeeName }}</td>
                    @foreach (range(1, $daysInMonth) as $day)
                        @php
                            // Fetch the attendance for this day
                            $attendanceForDay = $attendances->where('today_date', Carbon\Carbon::now()->year . '-' . request('month', Carbon\Carbon::now()->month) . '-' . $day)->first();
                        @endphp
                        <td class="attendance-cell">
                            @if ($attendanceForDay)
                                @if($attendanceForDay->status == 0)
                                    <!-- Absent icon (red) -->
                                    <strong><span style="color: red;">A</span></strong>
                                @elseif($attendanceForDay->status == 1)
                                    <!-- Present icon (green) -->
                                    <strong><span style="color: green;">P</span></strong>
                                @else
                                    <!-- Unknown status (orange) -->
                                    <i class="fa fa-question-circle" style="color:orange;"></i>
                                @endif
                            @else
                                <!-- No attendance data for this day, show a dash (gray) -->
                                <!-- <i class="fa fa-minus-circle no-data"></i> -->
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
    $('#example').DataTable({
        dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    }, 
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o"></i> PDF',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    },
                }
            ]
    });

    $('.refresh-btn').click(function(event) {
    // Prevent the default form submission behavior
        event.preventDefault();
        
        // Get the current selected month and year values
        var month = $('#month').val();
        var year = $('#year').val();
        
        // Construct the new URL with month and year
        var url = "{{ route('admin.employee.attendance') }}";
        
        // Reload the page with the constructed URL (this ensures the selected month and year stay)
        window.location.href = url;
    });
</script>

@endsection
