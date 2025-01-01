@extends('team_head.team_head_layout.sidebar')
@section('content')

{{-- <style>
    
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
    .editmodel{
        width: 200%;
        margin-left: -45%;
    }
    html:not(.layout-footer-fixed) .content-wrapper {
        padding-bottom: 500px !important;
    }
    div.dataTables_wrapper{
        margin-top: 10px;
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
</style> --}}
<h5 style="color:black">All Leave Request</h5>
<div class="card">
    <div class="table-responsive text-nowrap">
        <div style="display: flex;width:50%">
            <label style="margin-top: 7px">From Date: </label>
            <input type="date" class="form-control" style="margin-left:3px;" id="filter_from_date">
            <label style="margin-top: 7px;margin-left: 5px;">To Date: </label>
            <input type="date" class="form-control" style="margin-left: 3px" id="filter_to_date">
            <label style="margin-top: 7px; margin-left: 5px;">Status: </label>
            <select name="status" id="filter_status" class="form-control" style="margin-left: 3px">
                <option value="">Select Status</option>
                <option value="Rejected">Rejected</option>
                <option value="Approved">Approved</option>
            </select>
        </div>
     
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Employee Name</th>
                    <th>Apply Date</th>
                    <th>Leave Type</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Reason</th>
                    <th>Admin Status</th>
                    <th>Admin Reject Reason</th>
                    <th>Team Head Status</th>
                    <th>Team Head Reject Reason</th>                    
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
                        @if($item->to_date  != null)
                        {{ \Carbon\Carbon::parse($item->to_date)->format('d-m-Y') }}
                        @endif
                    </td>
                    <td>{{$item->leave_reason}}</td>
                    <td>
                        @if($item->status == null)
                        <div></div>
                        @elseif($item->status == 0)
                        <div style="color: red">Rejected</div>
                        @elseif($item->status == 1)
                        <div style="color: green">Approved</div>
                        @endif
                    </td>
                    <td>{{$item->rejected_reason}}</td>
                    <td>
                        @if($item->team_head_status == null)
                        <div></div>
                        @elseif($item->team_head_status == 0)
                        <div style="color: red">Rejected</div>
                        @elseif($item->team_head_status == 1)
                        <div style="color: green">Approved</div>
                        @endif
                    </td>
                    <td>{{$item->team_head_rejected_reasons}}</td>
                    <td>
                        <a class="edit" href="#" data-id='{{$item->id}}' data-status='{{$item->team_head_status}}' data-rejected_reason='{{$item->team_head_rejected_reasons}}'>
                            <i class="fa fa-check" style="font-size:24px;color:#36a50b"></i>
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
                <h5 class="modal-title" id="myModalLabel">Leaver Approved & Rejected</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('teamHead.teamHead_user_request_leave_approved')}}" method="post" id="password" enctype="multipart/form-data">
                    @csrf
                     <input type="hidden" id="id" name="id">
                     <div>
                            <input type="radio"  name="status" value="1" id="leave_approved" required/>
                            <label for="html">Approved</label>

                            <input type="radio" name="status" value="0" id="leave_rejected" style="margin-left: 15px" required />
                            <label for="html">Rejected</label>     
                    </div>
                    <br>
                    
                    <div id="errorexpanded" class="mb-3 attempt_reason"  style="display: none;">
                        <label>Rejecte Reason<span class="text-danger">*</span></label>
                        <input type="text"  class="form-control" name="rejected_reason" id="rejected_reason" required />
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

{{-- employee delete modal --}}
<div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dfe8eb">
                <h5 class="modal-title" id="myModalLabel">Delete Leave Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="text-center" style="margin-right: 8%;">Are you sure you want to Delete Leave Request</h5>
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

<script type="text/javascript">
$(document).ready(function() {
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
    $(document).ready(function() {
        var table = $('#example').DataTable({
            "processing" : true,
            "serverside" : true,
            dom: 'Bfrtip',
                buttons: [
                    'excelHtml5',
                    'pdfHtml5',
                ]
        });

    // Add event listeners to the filter inputs
        $('#filter_from_date, #filter_to_date, #filter_status').on('change', function() {
            applyFilters(table);
        });
    });

    function applyFilters(table) {
        var fromDate = $('#filter_from_date').val();
        var toDate = $('#filter_to_date').val();
        var status = $('#filter_status').val();

        // Convert the dates to 'yy-mm-dd' format
        fromDate = fromDate ? formatDate(fromDate) : '';
        toDate = toDate ? formatDate(toDate) : '';

        console.log('From Date:', fromDate);
        console.log('To Date:', toDate);
        console.log('Status:', status);

        // Custom filtering function for date range
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                var applyDate = data[1]; // Assuming 'Apply Date' is in the second column
                if (fromDate && toDate) {
                    return applyDate >= fromDate && applyDate <= toDate;
                }
                return true;
            }
        );

    // Use the correct column index for 'Status'
        table.columns(6).search(status).draw();
        
        // Pop the custom filter function to avoid affecting other DataTables instances
        $.fn.dataTable.ext.search.pop();
    }
    function formatDate(dateString) {
        var parts = dateString.split("-");
        return parts[2] + '-' + parts[1] + '-' + parts[0];
    }
    $(document).on('click', '.edit', function(event) {
        event.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        var rejected_reason = $(this).data('rejected_reason');


        $('#leavemodal').modal('show');
        $('#rejected_reason').val(rejected_reason);
        $('#id').val(id);
        $('#status').val(status);

         if(status == "1"){
            $("#leave_approved").prop("checked", true);
         }else if(status == "0"){
            $("#leave_rejected").prop("checked", true);
         }
  
     
    });


    $(document).on('click', '.edit', function(event){
        event.preventDefault(); 
        var status = $(this).data('status');
        if (status == '0') {
            $('.attempt_reason').show();
        } else if(status == '1'){
            $('.attempt_reason').hide();
    
        } else {
            $('.attempt_reason').hide();
        }

    });
    document.querySelectorAll('input[type="radio"][name="status"]').forEach(e => {
            e.addEventListener('change', function() {
                if (this.value == "0") {
                    errorexpanded.style.display = "block";
                    $('#attempt_reason').prop('required', true);
                } else {
                    errorexpanded.style.display = "none";
                    $('#attempt_reason').prop('required', false);
                }
            });
    });
    document.querySelectorAll('input[type="radio"][name="status"]').forEach(e => {
            e.addEventListener('change', function() {
                if (this.value == "0") {
                    errorexpanded.style.display = "block";
                    $('#rejected_reason').prop('required', true);
                } else {
                    errorexpanded.style.display = "none";
                    $('#rejected_reason').prop('required', false);
                 
                }
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
    $.post("{{ route('teamHead.teamHead_user_request_leave_delete') }}", {
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
