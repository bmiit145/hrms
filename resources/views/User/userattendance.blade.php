@extends('User.user_layout.sidebar')
@section('content')

{{-- fa fa icon sacript  --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

{{-- data-table css  --}}
<link  rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css"/>


<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    
    .employee{
        border-radius: 13px 5px;
        background: #696cff;
        color: white;
        border: none;
        margin-left: 95%;
        height: 38px;
        width: 4%;
        position: relative;
        margin-bottom: 10px;
    }
    html:not(.layout-footer-fixed) .content-wrapper {
        padding-bottom: 520px !important;
    }
    .editmodel{
        width: 200%;
        margin-left: -45%;
    }

    @media (max-width: 767px) {
        .employee {
            margin-left: 41%; /* Adjust the margin for smaller screens */
            width: 13%; /* Make the button full width */
        }
        .editmodel{
            width: 100%;
            margin-left: 0%;
        }
    }
</style>
<h4 style="color: black">Attendance</h4>
<div class="card">
 
        <button class="employee">Stop</button>
    <div class="table-responsive text-nowrap">
     
  
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Attendance Date</th>
                    <th>First In</th>
                    <th>Last Out</th>
                    <th>Break Time</th>
                    <th>After Breck First In</th>
                    <th>After Breck Last Out</th>
                    <th>Working Hour</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->today_date)->format('d-m-y') }}</td>
                    <td>
                        @if($item->first_in != null)
                        {{ \Carbon\Carbon::parse($item->first_in)->format('h:i:s A') }}
                        @endif
                    </td>
                    <td>@if($item->last_out != null)
                            {{ \Carbon\Carbon::parse($item->last_out)->format('h:i:s A') }}
                        @endif
                    </td>
                    <td>1:00 PM to 2:00 PM</td>
                    <td>
                        @if($item->after_breck_first_in != null)
                        {{ \Carbon\Carbon::parse($item->after_breck_first_in)->format('h:i:s A') }}
                        @endif
                    </td>
                    <td>
                         @if($item->after_breck_last_out != null)
                        {{ \Carbon\Carbon::parse($item->after_breck_last_out)->format('h:i:s A') }}
                        @endif
                    </td>
                    <td>
                        @if($item->last_out && $item->after_breck_last_out)
                            @php
                                $firstIn = \Carbon\Carbon::parse($item->first_in);
                                $lastOut = \Carbon\Carbon::parse($item->last_out);
                                $afterBreckFirstIn = \Carbon\Carbon::parse($item->after_breck_first_in);
                                $afterBreckLastOut = \Carbon\Carbon::parse($item->after_breck_last_out);
                    
                                $workingDiff = $firstIn->diff($lastOut);
                                $afterBreckDiff = $afterBreckFirstIn->diff($afterBreckLastOut);
                    
                                $totalHours = $workingDiff->h + $afterBreckDiff->h;
                                $totalMinutes = $workingDiff->i + $afterBreckDiff->i;
                    
                                $totalHours += intdiv($totalMinutes, 60);
                                $totalMinutes %= 60;
                            @endphp
                           
                            <span style="color: {{ $totalHours >= 8 ? '#798899' : 'red' }}">
                                {{ $totalHours }} hours {{ $totalMinutes }} minutes
                           
                        @endif
                    </td>
                </tr>
                @endforeach   
            </tbody>
        </table>
    </div>
</div>


    {{-- datable java script --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>



<script type="text/javascript">
$(document).ready(function() {
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    $(document).ready(function () {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'pdfHtml5',
            ]
        });
    });  
    $(document).ready(function () {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
         });

        $(".employee").on("click", function () {
            // Capture current time
            var currentTime = new Date();
            var formattedTime = currentTime.getHours() + ":" + currentTime.getMinutes() + ":" + currentTime.getSeconds();
            console.log(formattedTime);

            // Send data to server
            $.ajax({
                type: "POST",
                url: "{{route('attendance.store')}}", // Replace with your actual server-side endpoint
                data: {
                    _token: "{{ csrf_token() }}",
                     first_in: formattedTime,
                     last_out: formattedTime,
                     after_breck_first_in: formattedTime,
                     after_breck_last_out : formattedTime, 
                     client_ip: '{{ request()->ip() }}',
                },
                success: function (response) {
                    console.log(response); // Log the server's response
                },
                
                error: function (error) {
                    console.error("Error:", error);
                }
            });
        });
    });
     
});
</script>
@endsection
