@extends('admin_layout.sidebar')
@section('content')

{{-- fa fa icon sacript  --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

{{-- mobile flage and country code selected script --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>

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
    .iti{
        width: 100%;
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
<h4 style="color: black">Employee</h4>
<div class="card">
    <a  href="{{route('admin.employee.create')}}">
        <button class="employee"><i class="fa fa-plus" aria-hidden="true"></i></button></a>
    <div class="table-responsive text-nowrap">
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Employee Name</th>
                    <th>Employee MobileNo.</th>
                    <th>Employee Email</th>
                    <th>Employee Joining Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($emp_details as $item)
                <tr>
                    <td>  {{ $loop->index + 1 }}</td>
                    <td>{{$item->emo_name}}</td>
                    <td>{{$item->emp_mobile_no}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{ \Carbon\Carbon::parse($item->joining_date )->format('d-m-y') }}</td>
                    <td>
                        <a class="edit" href="{{ route('admin.employee.edit', $item->id) }}">
                            <i class="fa fa-edit" style="font-size:24px;color:#36a50b"></i>
                        </a>
                        <a href="#" class="editpassword" data-id='{{$item->id}}' data-emp_password= '{{$item->password}}'>
                            <i class="fa fa-key" style="font-size:24px"></i>
                        </a>
                        <a href="#" class="delete" data-id='{{$item->id}}'>
                            <i class="fa fa-trash-o" style="font-size:24px;color:red"></i>
                        </a>
                        {{-- <i class="fa fa-lock" aria-hidden="true"></i> --}}
                        @if($item->is_lock == 0)
                        <a href="#" class="lock" data-id='{{$item->id}}' data-is_lock='{{$item->is_lock}}'>
                            <i class="fa fa-unlock-alt" style="font-size: 24px;color:#163048"></i>
                        </a>
                        @else
                        <a href="#" class="lock" data-id='{{$item->id}}' data-is_lock='{{$item->is_lock}}'>
                            <i class="fa fa-lock"style="font-size: 24px;color:#163048"></i>
                        </a>
                        @endif

                    
                        <!-- <a href="#" class="view">
                            <i class="fa fa-eye" style="font-size:24px;color:gray"></i>
                        </a> -->
                    </td>
                </tr>
                @endforeach
             
               
            </tbody>
        </table>
    </div>
</div>
    <!-- Edit  employee list Modal -->
    <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content editmodel">
                <div class="modal-header" style="background-color: #dfe8eb">
                    <h5 class="modal-title" id="myModalLabel">Edit Inquiry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="nsfijsydf" method="post" id="inquiry_form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="inid" name="inid">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <strong>Full Name <span class="text-danger">*</span></strong>
                                <input type="text" name="emp_name" class="form-control" id="employee_name" placeholder="Enter Employee Name" >
                                
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <strong>Email <span class="text-danger">*</span></strong>
                                <input type="email" class="form-control" name="emp_email" id="employee_email" placeholder="Enter Employee Email"  >
                                
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 form-group">
                                <strong style="display:flow-root;">Mobile no. <span class="text-danger">*</span></strong>
                                <input type="number" class="form-control mobile" name="emp_mobile_no[main]" id="employee_mobile_no" placeholder="Enter Employee Mobile no" >
        
                             
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <strong>Address <span class="text-danger">*</span></strong>
                                <input type="text" class="form-control" name="emp_address" id="employee_address" placeholder="Enter Employee Address"  >
                               
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 form-group">
                                <strong>Department Name <span class="text-danger">*</span></strong>
                                <select class="form-control" name="emp_department_name" id="employee_department_name" >
                                    <option value="">Select Department Name</option>
                                    @foreach ($department_name as $item)
                                    <option value="{{$item->id}}">{{$item->department_name}}</option>
                                  @endforeach    
                                </select>
                               
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <strong>Joining Date <span class="text-danger">*</span></strong>
                                <input type="date" class="form-control" name="joining_date" id="employee_joining_date" placeholder=""  >
                              
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 form-group">
                                <strong>Birthday Date<span class="text-danger">*</span></strong>
                                <input type="date" class="form-control" name="emp_birthday_date" id="employee_birthday_date" placeholder=""  >
                               
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <strong>Notes <span class="text-danger">*</span></strong>
                                <input type="text" class="form-control" name="notes" id="emp_notes" placeholder=""  >
                              
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <strong>Uplode Employee Document <span class="text-danger">*</span></strong>
                                <input type="file" class="form-control" name="emp_document[]" id="employee_document" multiple>
                               
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <strong>Uplode Employee Bank Document </strong>
                                <input type="file" class="form-control" name="emp_bank_document" id="employee_bank_document">
                             
                            </div>
                        </div>
                       
        
                       
                        <div class="mt-3">
                            <button type="submit"
                                class="text-white p-2 border-0 rounded px-3 fw-bold send_inquiry_btn" style="background-color: #16ae71;">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!-- Edit user password Modal -->
        <div class="modal fade" id="passwordeditmodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #dfe8eb">
                        <h5 class="modal-title" id="myModalLabel">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="bcdhygubjh" method="post" id="password" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id" name="id">
                          
                            <div class="row mt-3">
                                <div class="col-md-6 form-group">
                                    <strong>Password<span class="text-danger">*</span></strong>
                                    <input type="password" class="form-control" name="emp_password" id="emp_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="basic-default-password2" />
                                   
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <strong>Confirm Password <span class="text-danger">*</span></strong>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="basic-default-password2" />
                                  
                                </div>
                            </div>
                           
                            <div class="mt-3">
                                <button type="submit"
                                    class="text-white p-2 border-0 rounded px-3 fw-bold send_inquiry_btn" style="background-color: #16ae71;">Edit</button>
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
                        <h5 class="modal-title" id="myModalLabel">Delete Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-center" style="margin-right: 8%;">Are you sure you want to delete Employee?</h5>
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
        <!--employee lock  Modal -->
        <div class="modal fade" id="lockemodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #dfe8eb">
                        <h5 class="modal-title" id="myModalLabel">Lock Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-center" style="margin-right: 8%;">Are you sure you want to Lock Employee?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="background-color:#356a7f ">NO</button>
                        <button type="button" id="lockemember" class="btn btn-danger">YES</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--employee Unlock  Modal -->
        <div class="modal fade" id="unlockemodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #dfe8eb">
                        <h5 class="modal-title" id="myModalLabel">Un-Lock Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-center" style="margin-right: 8%;">Are you sure you want to Un-Lock Employee?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="background-color:#356a7f ">NO</button>
                        <button type="button" id="unlockemember" class="btn btn-danger">YES</button>
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

    $(document).on('click', '.editpassword', function(event){
        event.preventDefault();
        var id = $(this).data('id');
        var password = $(this).data('emp_password');
        $('#passwordeditmodal').modal('show');
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
        $.post("{{ URL::to('admin/delete') }}", {
                id: id
            },
            function() {
                $('#deletemodal').modal('hide');
                location.reload();
            })
    });

    $(document).on('click','.lock', function(event){
        event.preventDefault();
        var id = $(this).data('id');
        var is_lock = $(this).data('is_lock');
        console.log(is_lock);
        if(is_lock == 0){
            $('#lockemodal').modal('show');
        }else{
            $('#unlockemodal').modal('show');
        }
       
        $('#lockemember').val(id);
        $('#unlockemember').val(id);

    });

    $('#lockemember').click(function() {
        var id = $(this).val();
        $.post("{{ URL::to('admin/user_lock') }}", {
                id: id
            },
            function() {
                $('#lockemodal').modal('hide');
                $('#unlockemodal').modal('hide');
                location.reload();
            })
    });
    $('#unlockemember').click(function() {
        var id = $(this).val();
        $.post("{{ URL::to('admin/user_lock') }}", {
                id: id
            },
            function() {
                $('#unlockemodal').modal('hide');
                location.reload();
            })
    });
});
</script>
<script>
      var mobile_no = window.intlTelInput(document.querySelector("#employee_mobile_no"), {
        separateDialCode: true,
        preferredCountries: ["in"],
        hiddenInput: "full",
        utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
    });

    $("form").submit(function() {
        var full_number = mobile_no.getNumber(intlTelInputUtils.numberFormat.E164);
        $("input[name='mobile_no[full]'").val(full_number);
    });

    $(document).ready(function () {
        $("#password").submit(function (event) {
            // Get the values of the password fields
            var password = $("#emp_password").val();
            var confirmedPassword = $("#confirm_password").val();

            // Check if the passwords match
            if (password !== confirmedPassword) {
                // If passwords don't match, prevent the form submission and show an error message
                event.preventDefault();
                alert("Passwords do not match. Please enter matching passwords.");
            }
        });
    });
</script>
@endsection
