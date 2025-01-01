@extends('admin_layout.sidebar')
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
        padding-bottom: 500px !important;
    }

    .editmodel{
        width: 200%;
        margin-left: -45%;
    }

    @media (max-width: 767px) {
        .employee {
            margin-left: 30%; /* Adjust the margin for smaller screens */
            width: 13%; /* Make the button full width */
        }
        .editmodel{
            width: 100%;
            margin-left: 0%;
        }
    }
</style>
<h4 style="color: black">Today's Attendance</h4>
<div class="card">

           
            <button class="employee"><i class="fa fa-plus" aria-hidden="true"></i></button>
         
    <div class="table-responsive text-nowrap">
          
    
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Attendance Date</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>First In</th>
                    <th>Last Out</th>
                    <!-- <th>Break</th>
                    <th>After Breck First In</th>
                    <th>After Breck Last Out</th> -->
                    <th>Working Hour</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->today_date)->format('d-m-y') }}</td>
                    <td>{{$item->user_name}}</td>
                    <td>{{$item->de_name}}</td>
                    <td>
                        @if($item->first_in != null)
                        {{ \Carbon\Carbon::parse($item->first_in)->format('h:i:s A') }}
                        @endif
                    </td>
                    <td>@if($item->last_out != null)
                            {{ \Carbon\Carbon::parse($item->last_out)->format('h:i:s A') }}
                        @endif
                    </td>
                    <!-- <td>1:00 PM to 2:00 PM</td>
                    <td>
                        @if($item->after_breck_first_in != null)
                        {{ \Carbon\Carbon::parse($item->after_breck_first_in)->format('h:i:s A') }}
                        @endif
                    </td>
                    <td>
                        @if($item->after_breck_last_out != null)
                        {{ \Carbon\Carbon::parse($item->after_breck_last_out)->format('h:i:s A') }}
                        @endif
                    </td> -->
                    <td>
                        @if($item->first_in && $item->last_out)
                            @php
                                // Parse the first_in and last_out times
                                $firstIn = \Carbon\Carbon::parse($item->first_in);
                                $lastOut = \Carbon\Carbon::parse($item->last_out);

                                // Calculate the difference between first_in and last_out
                                $workingDiff = $firstIn->diff($lastOut);

                                // Get the total hours and minutes from the difference
                                $totalHours = $workingDiff->h;
                                $totalMinutes = $workingDiff->i;

                                // Check if the work time goes beyond 2:00 PM (14:00) for break deduction
                                $breakTime = 0; // Default: no break time
                                if ($lastOut->hour >= 14) { // Last out is after 2:00 PM
                                    $breakTime = 45; // Subtract 45 minutes for the break
                                }

                                // Subtract the break time (45 minutes) from the total working time
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
                    
                    <td> @if($item->status == 0)
                         <div>Absent</div>
                        @else
                         <div>Present</div>
                        @endif
                    </td> 
                    <td><a class="edit" href="#" data-id='{{$item->id}}' data-first_in='{{$item->first_in}}' data-today_date='{{$item->today_date}}'
                           data-last_out='{{$item->last_out}}' data-status='{{$item->status}}' data-emp_id = '{{$item->emp_id}}'>
                         <i class="fa fa-edit" style="font-size:24px;color:#36a50b"></i>
                        </a>
                        <a href="#" class="delete" data-id='{{$item->id}}'>
                            <i class="fa fa-trash-o" style="font-size:24px;color:red"></i>
                        </a>
                       
                    </td>
                </tr>
                @endforeach
             
               
            </tbody>
        </table>
    </div>
</div>



    <!-- add Today's attendance  -->
<div class="modal fade" id="todaymodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dfe8eb">
                <h5 class="modal-title" id="myModalLabel">Add Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="attendance_store" method="post" id="password" enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-3">
                        <strong>Employee Name <span class="text-danger">*</span></strong>
                        <select class="form-control" name="emp_id" required>
                            <option value="">Select Employee Name</option>
                            @foreach ($user as $item)
                            <option value="{{$item->id}}">{{$item->emo_name}}</option>
                            @endforeach    
                        </select>
                            
                    </div>
                    <div class="row mt-3">
                            <strong>Today Date<span class="text-danger">*</span></strong>
                            <input type="date" class="form-control"  placeholder="Enter Holiday name" name="today_date" required/>
                            
                    </div>
                    <div class="row mt-3">
                            <strong>First In</strong>
                            <input type="time" class="form-control"  placeholder="Enter Holiday name" name="first_in"/>
                            
                    </div>
                    <div class="row mt-3">
                            <strong>Last in</strong>
                            <input type="time" class="form-control"  placeholder="Enter Holiday name" name="last_out" />
                            
                    </div>
                    <div class="row mt-3">
                        <strong>Status <span class="text-danger">*</span></strong>
                        <select class="form-control" name="status"  required>
                            <option value="">Select Status</option>
                            <option value="0">Absent</option>
                            <option value="1">Present</option>
                    
                        </select>
                            
                    </div>
                
                
                    <div class="mt-3">
                        <button type="submit"
                            class="text-white p-2 border-0 rounded px-3 fw-bold send_inquiry_btn" style="background-color: #16ae71;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 <!-- edit add department  -->
 <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dfe8eb">
                <h5 class="modal-title" id="myModalLabel">Edit Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="attendance_update" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="row mt-3">
                        <strong>Employee Name <span class="text-danger">*</span></strong>
                        <select class="form-control" name="emp_id" id="emp_id" required>
                            <option value="">Select Employee Name</option>
                            @foreach ($user as $item)
                            <option value="{{$item->id}}">{{$item->emo_name}}</option>
                            @endforeach    
                        </select>
                            
                    </div>
                     <div class="row mt-3">
                            <strong>Today Date<span class="text-danger">*</span></strong>
                            <input type="date" class="form-control"  name="today_date" id="today_date"  />
                  
                    </div>
                    <div class="row mt-3">
                            <strong>First In</strong>
                            <input type="time" class="form-control"  name="first_in" id="first_in" >
                  
                    </div>
                    <div class="row mt-3">
                            <strong>Last Out</strong>
                            <input type="time" class="form-control"  name="last_out" id="last_out" >
                  
                    </div>
                    <div class="row mt-3">
                        <strong>Status <span class="text-danger">*</span></strong>
                        <select class="form-control" name="status" id="status"  required>
                            <option value="">Select Status</option>
                            <option value="0">Absent</option>
                            <option value="1">Present</option>
                        </select>
                            
                    </div>
                   
                    <div class="mt-3">
                        <button type="submit"
                            class="text-white p-2 border-0 rounded px-3 fw-bold send_inquiry_btn" style="background-color: #16ae71;">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 <!--employee Delete Modal -->
 <div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dfe8eb">
                <h5 class="modal-title" id="myModalLabel">Delete Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="text-center" style="margin-right: 8%;">Are you sure you want to delete Attendance?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color:#356a7f ">Close</button>
                <button type="button" id="deletemember" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
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

<script type="text/javascript">
$(document).ready(function() {
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
         
            // Initialize DataTables without buttons first
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
        $(document).on('click', '.employee', function(event){
            event.preventDefault(); 
            $('#todaymodal').modal('show');
        }); 

      
        $(document).on('click', '.edit', function(event){
            event.preventDefault();

             var id = $(this).data('id');
             var today_date = $(this).data('today_date')
             var first_in = $(this).data('first_in');
             var last_out = $(this).data('last_out');
             var status = $(this).data('status');
             var emp_id = $(this).data('emp_id');
            $('#editmodal').modal('show');
            $('#first_in').val(first_in);
            $('#today_date').val(today_date);
            $('#last_out').val(last_out);
            $('#status').val(status);
            $('#emp_id').val(emp_id);
            $('#id').val(id);
        });

        $(document).on('click', '.delete', function(event){
            event.preventDefault();
            var id = $(this).data('id');
            $('#deletemodal').modal('show');
            $('#deletemember').val(id);
        });
        $('#deletemember').click(function() {
            var id = $(this).val();
            $.post("{{ URL::to('admin/attendance_delete') }}", {
                    id: id
                },
                function() {
                    $('#deletemodal').modal('hide');
                    location.reload();
                })
        });
       

});
  

</script>

      
@endsection
