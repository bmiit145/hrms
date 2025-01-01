@extends('team_head.team_head_layout.sidebar')

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
<h4 style="color: black">All Leave Request</h4>
<div class="card">
 
        <button class="employee"><i class="fa fa-plus" aria-hidden="true"></i></button>
    <div class="table-responsive text-nowrap">
     
  
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Apply Date</th>
                    <th>Leave Type</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Reason</th>
                    <th>Status </th>
                    <th>Leave Rejecte Reason</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-y') }}</td>
                    <td>{{ $item->leaveType->leave_type ?? 'N/A' }}</td>

                    <td>{{ \Carbon\Carbon::parse($item->from_date)->format('d-m-y') }}</td>
                    <td>@if($item->to_date  != null)
                        {{ \Carbon\Carbon::parse($item->to_date)->format('d-m-y') }}
                        @endif
                    </td>
                    <td>{{$item->leave_reason}}</td>
                    <td>
                          @if($item->status == NULL)
                          <div></div>
                          @elseif($item->status == 0)
                          <div style="color: red">Rejected</div>
                          @elseif($item->status == 1)
                          <div style="color: green">Approved</div>
                          @endif
                    </td> 
                    <td>{{$item->rejected_reason}}</td>
                    <td><a class="edit" href="#" data-id='{{$item->id}}' data-leave ='{{$item->leave_type}}'
                         data-from_date ='{{$item->from_date}}' data-to_date='{{$item->to_date}}' data-leave_reason ='{{$item->leave_reason}}'>
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
  <!-- add leave  -->
  <div class="modal fade" id="leavemodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dfe8eb">
                <h5 class="modal-title" id="myModalLabel">New Add Leave Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="password" enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-3">
                        <strong>Leave Type<span class="text-danger">*</span></strong>
                        <select class="form-control" name="leave_type" id="leave_type">
                            <option value="">Select Leave Type</option>
                            @foreach ($leave as $item)
                            <option value="{{$item->id}}">{{$item->leave_type}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-leave_type"></span>
                    </div>
                    <div class="row mt-3">
                        <strong>From Date<span class="text-danger">*</span></strong>
                      
                          <input type="date" class="form-control" id="from_date" name="from_date" placeholder="Select from date" />
                   
                   
                        <span class="text-danger error-message d-none" id="from_date_error">Please select a valid From Date.</span>
                    </div>
                    <div class="row mt-3">
                        <strong>To Date<span class="text-danger">*</span></strong>
                            <input type="date" class="form-control" id="to_date" name="to_date" placeholder="Select to date" />
                        
                      
                        <span class="text-danger error-message d-none" id="to_date_error">Please select a valid To Date.</span>
                    </div>
                    <div class="row mt-3">
                        <strong>Reason<span class="text-danger">*</span></strong>
                        <textarea type="text" class="form-control" placeholder="Enter Reason" name="leave_reason" id="leave_reason"></textarea>
                        <span class="text-danger error-leave_reason"></span>
                    </div>                                        
                    <div class="mt-3">
                        <button type="submit"
                            class="text-white p-2 border-0 rounded px-3 fw-bold send_inquiry_btn" style="background-color: #16ae71;">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 <!-- edit leave  -->
 <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dfe8eb">
                <h5 class="modal-title" id="myModalLabel">Edit Leave Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="leave_edit" method="post" id="editForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="row mt-3">
                        <strong>Leave Type<span class="text-danger">*</span></strong>
                        <select class="form-control" name="leave_type" id="leave_type">
                        <option value="">Select Leave Type</option>
                            @foreach ($leave as $item)
                            <option value="{{$item->id}}">{{$item->leave_type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mt-3">
                        <strong>From Date<span class="text-danger">*</span></strong>
                        <input type="date" class="form-control" id="from_date" name="from_date" required />
                         
                    </div>
                 <div class="row mt-3">
                        <strong>To Date</strong>
                        <input type="date" class="form-control" id="to_date" name="to_date" />
                         
                    </div>
                    <div class="row mt-3">
                        <strong>Reason<span class="text-danger">*</span></strong>
                            <textarea type="text" class="form-control" id="leave_reason"  placeholder="Enter Details" name="leave_reason"  required></textarea>
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
<!--employee Delete Modal -->
<div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dfe8eb">
                <h5 class="modal-title" id="myModalLabel">Delete Leave Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="text-center" style="margin-right: 8%;">Are you sure you want to delete Leave Request?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    style="background-color:#356a7f ">Close</button>
                <button type="button" id="deletemember" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

    {{-- datable java script --}}
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>



<script>
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
        $(document).on('click', '.employee', function(event){
            event.preventDefault(); 
            $('#leavemodal').modal('show'); 
        });

        $(document).on('click', '.edit', function(event){
            event.preventDefault();
            var id = $(this).data('id');
            var leave_type = $(this).data('leave');
            var from_date = $(this).data('from_date');
            var to_date = $(this).data('to_date');
            var leave_reason = $(this).data('leave_reason');
            $('#editmodal').modal('show');
            $('#leave_type').val(leave_type);
            $('#from_date').val(from_date);
            $('#to_date').val(to_date);
            $('#leave_reason').val(leave_reason);
            $('#id').val(id);
            
            $('#editForm').on('submit', function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    var form = $(this).serialize();
                    var url = $(this).attr('action');
                    $.post(url, form, function(data) {
                        $('#editmodal').modal('hide');
                    })
            });
        });
        $(document).on('click', '.delete', function(event){
            event.preventDefault();
            var id = $(this).data('id');
            $('#deletemodal').modal('show');
            $('#deletemember').val(id);
        });
        $('#deletemember').click(function() {
            var id = $(this).val();
            $.post("{{ URL::to('admin/leave_delete_user') }}", {
                    id: id
                },
                function() {
                    $('#deletemodal').modal('hide');
                    location.reload();
                })
        });
        $(document).on('click', '.delete', function(event){
            event.preventDefault();
            var id = $(this).data('id');
            $('#deletemodal').modal('show');
            $('#deletemember').val(id);
        });
        $('#deletemember').click(function() {
            var id = $(this).val();
            $.post("{{ URL::to('admin/delete') }}", {
                    id: id
                },
                function() {
                    $('#deletemodal').modal('hide');
                    location.reload();
                })
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#password').on('submit', function (e) {
            e.preventDefault(); // Prevent form submission

            // Clear previous error messages
            $('.text-danger').text('');

            // Initialize validation flag
            let isValid = true;

            // Validate Leave Type
            if ($('#leave_type').val() === '') {
                $('.error-leave_type').text('Please select a leave type.');
                isValid = false;
            }

            // Validate From Date
            if ($('#from_date').val() === '') {
                $('.error-from_date').text('Please select a from date.');
                isValid = false;
            }

            // Validate Reason
            if ($('#leave_reason').val().trim() === '') {
                $('.error-leave_reason').text('Please provide a reason.');
                isValid = false;
            }

            // Additional validation for date range
            const fromDate = new Date($('#from_date').val());
            const toDate = new Date($('#to_date').val());
            if ($('#to_date').val() !== '' && fromDate > toDate) {
                $('.error-to_date').text('To date cannot be earlier than from date.');
                isValid = false;
            }

            // Submit form if all validations pass
            if (isValid) {
                const formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.leave_request_store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.success) {
                            alert(response.message); // Success message
                            $('#leavemodal').modal('hide'); // Hide modal
                            location.reload(); // Reload page
                        } else {
                            alert('Unable to process request.');
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText); // Log error details
                        alert('Something went wrong. Please try again.');
                    }
                });
            }
        });
    });
</script>

@endsection
