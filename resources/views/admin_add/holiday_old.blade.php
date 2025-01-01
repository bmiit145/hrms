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
    .editmodel{
        width: 200%;
        margin-left: -45%;
    }
    html:not(.layout-footer-fixed) .content-wrapper {
        padding-bottom: 520px !important;
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
<h4 style="color: black">Add Holiday</h4>
<div class="card">
 
        <button class="employee"><i class="fa fa-plus" aria-hidden="true"></i></button>
    <div class="table-responsive text-nowrap">
     
     
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Holiday Name</th>
                    <th>Start Date</th>   
                    <th>End Date</th>   
                    <th>Details</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($holidays as $item)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{$item->holiday_name}}</td>
                    <td>
                        @if(\Carbon\Carbon::hasFormat($item->holiday_date, 'Y-m-d')) 
                            {{ \Carbon\Carbon::parse($item->holiday_date)->format('d-m-y') }}
                        @endif
                    </td>
                    <td>
                        @if(\Carbon\Carbon::hasFormat($item->end_date, 'Y-m-d'))
                            {{ \Carbon\Carbon::parse($item->end_date)->format('d-m-y') }}
                        @endif
                    </td>
                    <td>{{$item->details}}</td>
                    <td><a class="edit" href="#" data-id='{{$item->id}}' data-holiday_name='{{$item->holiday_name}}' data-holiday_date='{{$item->holiday_date}}' data-holiday_end_date='{{$item->end_date}}' data-details='{{$item->details}}'>
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

  <!-- add department  -->
<div class="modal fade" id="enterdepartmentmodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dfe8eb">
                <h5 class="modal-title" id="myModalLabel">Add Holiday</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.holiday_store')}}" method="post" id="password" enctype="multipart/form-data">
                    @csrf
                     <div class="row mt-3">
                            <strong>Holiday<span class="text-danger">*</span></strong>
                            <input type="texr" class="form-control"  placeholder="Enter Holiday name" name="holiday_name"  aria-describedby="basic-default-password2" required />
                             
                    </div>
                     <div class="row mt-3">
                            <strong>Start Date<span class="text-danger">*</span></strong>
                            <input type="date" class="form-control"  placeholder="Enter Holiday start date" name="holiday_date"  aria-describedby="basic-default-password2" required />
                             
                    </div>
                    <div class="row mt-3">
                            <strong>End Date</strong>
                            <input type="date" class="form-control"  placeholder="Enter Holiday end date" name="holiday_end_date"/>
                             
                    </div>
                     <div class="row mt-3">
                            <strong>Details</strong>
                            <input type="text" class="form-control"  placeholder="Enter Details" name="details"  aria-describedby="basic-default-password2" />
                             
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
                <h5 class="modal-title" id="myModalLabel">Edit Holiday</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.holiday_edit')}}" method="post" id="password" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id">
                     <div class="row mt-3">
                            <strong>Holiday<span class="text-danger">*</span></strong>
                            <input type="text" class="form-control"   name="holiday_name" id="holiday_name" aria-describedby="basic-default-password2" required />
                  
                    </div>
                     <div class="row mt-3">
                            <strong>Date<span class="text-danger">*</span></strong>
                            <input type="date" class="form-control"  name="holiday_date" id="holiday_date" aria-describedby="basic-default-password2" required />
                  
                    </div>
                    <div class="row mt-3">
                            <strong>End Date</strong>
                            <input type="date" class="form-control"  placeholder="Enter Holiday end date" id="holiday_end_date" name="holiday_end_date"/>                             
                    </div>
                     <div class="row mt-3">
                            <strong>Details</strong>
                            <input type="text" class="form-control"  name="details" id="details" aria-describedby="basic-default-password2"/>
                  
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
                    <h5 class="modal-title" id="myModalLabel">Delete Holiday</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="text-center" style="margin-right: 8%;">Are you sure you want to delete Holiday?</h5>
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
    $(document).on('click', '.employee', function(event){
        event.preventDefault(); 
        $('#enterdepartmentmodal').modal('show');
    });

    $(document).on('click', '.edit', function(event){
        event.preventDefault();
        var id = $(this).data('id');
        var holiday_name = $(this).data('holiday_name');
        var holiday_date = $(this).data('holiday_date');
        var holiday_end_date = $(this).data('holiday_end_date');
        var details = $(this).data('details');
        $('#editmodal').modal('show');
        $('#holiday_name').val(holiday_name);
        $('#holiday_date').val(holiday_date);
        $('#holiday_end_date').val(holiday_end_date);
        $('#details').val(details);
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
        $.post("{{ URL::to('admin/holidat_delete') }}", {
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
