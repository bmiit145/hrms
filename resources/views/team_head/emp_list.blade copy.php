@extends('team_head.team_head_layout.sidebar')

@section('content')

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

        td,
        th {
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
                                @if ($attendanceForDay->status == 0)
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


    <script>
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [{
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
