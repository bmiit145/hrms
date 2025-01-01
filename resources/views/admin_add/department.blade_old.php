@extends('admin_layout.sidebar')
@section('content')

{{-- fa fa icon sacript  --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

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
<h4 style="color:black">Department List</h4>
<div class="card">
 
        <button class="employee"><i class="fa fa-plus" aria-hidden="true"></i></button>
    <div class="table-responsive text-nowrap">
     
     
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Department Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($department_view as $item)
                <tr>
                    <td> {{ $loop->index + 1 }}</td>
                    <td>{{$item->department_name}}</td>
                    <td><a class="edit" href="#" data-id='{{$item->id}}' data-department_name='{{$item->department_name}}'>
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
                <h5 class="modal-title" id="myModalLabel">Add Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="nbvhugdai" method="post" id="password" enctype="multipart/form-data">
                    @csrf
                     <div class="row mt-3">
                            <strong>Add Department<span class="text-danger">*</span></strong>
                            <input type="texr" class="form-control"  placeholder="Enter department name" name="department_name"  aria-describedby="basic-default-password2" required />
                             
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

 <!-- edit department  -->
 <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dfe8eb">
                <h5 class="modal-title" id="myModalLabel">Edit Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="edit_department" method="post" id="password" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id">
                     <div class="row mt-3">
                            <strong>Department<span class="text-danger">*</span></strong>
                            <input type="texr" class="form-control"  placeholder="Enter department name" name="department_name" id="department_name" aria-describedby="basic-default-password2" required />
                  
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
                    <h5 class="modal-title" id="myModalLabel">Delete Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="text-center" style="margin-right: 8%;">Are you sure you want to delete Department?</h5>
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
 

    
<!-- Include jQuery and DataTables JS and CSS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


<script type="text/javascript">
$(document).ready(function() {
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    $(document).ready(function () {
        $('#example').DataTable();
    });

    $(document).on('click', '.employee', function(event){
        event.preventDefault(); 
        $('#enterdepartmentmodal').modal('show');
    });
    $(document).on('click', '.edit', function(event){
        event.preventDefault();
        var id = $(this).data('id');
        var department_name = $(this).data('department_name');
        $('#editmodal').modal('show');
        $('#department_name').val(department_name);
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
        $.post("{{ URL::to('admin/delete_department') }}", {
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
