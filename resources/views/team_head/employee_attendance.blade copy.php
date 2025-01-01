
@extends('team_head.team_head_layout.sidebar')
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

<div class="card">
    <div class="table-responsive text-nowrap">
    <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    @foreach (range(1, Carbon\Carbon::now()->daysInMonth) as $day)
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
                    @foreach (range(1, Carbon\Carbon::now()->daysInMonth) as $day)
                        @php
                            // Fetch the attendance for this day
                            $attendanceForDay = $attendances->where('today_date', Carbon\Carbon::now()->year . '-' . Carbon\Carbon::now()->month . '-' . $day)->first();
                        @endphp
                        <td class="attendance-cell">
                            @if ($attendanceForDay)
                                @if($attendanceForDay->status == 0)
                                    <!-- Absent icon (red) -->
                                    <!-- <i class="fa fa-times" aria-hidden="true" style="color:red;"></i> -->
                                    <strong><span style="color: red;">A</span></strong>
                                @elseif($attendanceForDay->status == 1)
                                    <!-- Present icon (green) -->
                                    <!-- <i class="fa fa-check" aria-hidden="true" style="color:green;"></i> -->
                                    <strong><span style="color: green;">P</span></strong>
                                @else
                                    <!-- Unknown status (orange) -->
                                    <i class="fa fa-question-circle" style="color:orange;"></i>
                                @endif
                            @else
                                <!-- No attendance data for this day, show a dash (gray) -->
                                <!-- <i class="fa fa-minus" aria-hidden="true"></i> -->
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
</script>

@endsection
