@extends('admin_layout.sidebar')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

{{-- mobile flage and country code selected script --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>

{{-- fa fa icon sacript  --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
 

<style>
    /* .mobile{
        width: 754px;
    } */
    .iti{
        width: 100%;
    }
    .form-control{
        color: #a0acb7;
    }
</style>


<!-- Basic Layout -->
<div class="row">
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Employee Form</h5> <small class="text-muted float-end"></small>
        </div>
        <div class="card-body">
            <form action="{{route('admin.employee.store')}}" method="post" id="inquiry_form" class="myForm" enctype="multipart/form-data">
                @csrf

               
                <div class="row">
                    <div class="col-md-6 form-group">
                        <strong>Full Name <span class="text-danger">*</span></strong>
                        <input type="text" name="emp_name" class="form-control" id="emp_name" placeholder="Enter Employee Name" value="{{ old ('emp_name') }}">
                        @error('emp_name')
                            <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mt-3 mt-md-0">
                        <strong>Email <span class="text-danger">*</span></strong>
                        <input type="email" class="form-control emp_email" name="emp_email" id="emp_email"
                            placeholder="Enter Employee Email" value="{{ old('emp_email') }}" >
                        @error('emp_email')
                            <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 form-group">
                        <strong style="display:flow-root;">Mobile no. <span class="text-danger">*</span></strong>
                        <input type="number" class="form-control mobile" name="emp_mobile_no[main]" id=""
                        placeholder="Enter Employee Mobile no"  value="{{ old('emp_mobile_no.main') }}" >

                        @error('emp_mobile_no.main')
                            <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                        <label id="mobile_no-error" class="error" for="mobile_no" style=""></label>
                    </div>
                    <div class="col-md-6 form-group mt-3 mt-md-0">
                        <strong>Address <span class="text-danger">*</span></strong>
                        <input type="text" class="form-control" name="emp_address" id="emp_address"
                            placeholder="Enter Employee Address" value="{{ old('emp_address') }}" >
                        @error('emp_address')
                            <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <strong>Department Name <span class="text-danger">*</span></strong>
                        <select class="form-control" name="emp_department_name" id="emp_department_name" style="color:#a0acb7;">
                            <option value="">Select Department Name</option>
                            @foreach ($department_name as $item)
                                <option value="{{ $item->id }}" {{ old('emp_department_name') == $item->id ? 'selected' : '' }}>
                                    {{ $item->department_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('emp_department_name')
                            <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mt-3 mt-md-0">
                        <strong>Joining Date <span class="text-danger">*</span></strong>
                        <input type="date" class="form-control" name="joining_date" id="joining_date"
                            placeholder="" value="{{ old('joining_date') }}" >
                        @error('joining_date')
                            <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 form-group mt-3 mt-md-0">
                        <strong>Uplode Employee Document</strong>
                        <input type="file" class="form-control" name="emp_document[]" id="emp_document" multiple>
                        @error('emp_document')
                            <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mt-3 mt-md-0">
                        <strong>Uplode Employee Bank Document </strong>
                        <input type="file" class="form-control" name="emp_bank_document" id="emp_bank_document">
                        @error('emp_bank_document')
                            <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 form-group">
                        <strong>Birthday Date <span class="text-danger">*</span></strong>
                        <input type="date" class="form-control" name="emp_birthday_date" id="emp_birthday_date" placeholder="Enter Employee Birthday Date">
                        @error('emp_birthday_date')
                            <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mt-3 mt-md-0">
                        <strong>Notes</strong>
                        <input type="text" class="form-control" name="notes" id="notes"
                            placeholder="Enter Employee Notes" value="{{ old('notes') }}" >
                        @error('notes')
                            <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 form-group mt-3 mt-md-0">
                        <strong>Password <span class="text-danger">*</span></strong>
                        <div class="input-group">
                            <input type="password" class="form-control" name="emp_password" id="emp_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="basic-default-password2" />
                            <span id="basic-default-password2" class="input-group-text cursor-pointer"><i class="fa fa-fw fa-eye field_icon toggle-password"></i></span>
                        </div>
                        <label id="emp_password-error" class="error" for="emp_password"></label>
                        @error('emp_password')
                        <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                        <div style="color:green">Password must be created name@123</div> 
                    </div>
                    <div class="col-md-6 form-group mt-3 mt-md-0">
                        <strong>Confirm Password <span class="text-danger">*</span></strong>
                        <div class="input-group">
                            <input type="password" class="form-control" name="confirmed_emp_password" id="confirmed_emp_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="basic-default-password2" />
                            <span id="basic-default-password2" class="input-group-text cursor-pointer"><i class="fa fa-fw fa-eye field_icon toggle-password12"></i></span>
                        </div>
                        <label id="confirmed_emp_password-error" class="error" for="confirmed_emp_password"></label>
                        @error('emp_password')
                        <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 form-group mt-3 mt-md-0">
                        <strong>Profile Picture</strong>
                        <div class="input-group">
                            <input type="file" class="form-control" name="profile_image" id="profile_image" />   
                        </div>
                        @error('profile_image')
                        <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                        <label id="profile_image-error" class="error" for="profile_image"></label>
                    </div>
                    <div class="col-md-6 form-group">
                        <strong>Role <span class="text-danger">*</span></strong>
                        <select class="form-control" name="role" id="role" style="color:#a0acb7">
                            <option value="">Select Role</option>
                             <option value="0">Admin</option>
                             <option value="1">Team Head</option>
                             <option value="2">Employee</option>
                             <option value="3">HR</option>
                        </select>
                        @error('role')
                            <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                    
                </div>

                <div class="row mt-2">
                    <div class="col-md-6 form-group">
                        <strong>Team Head Name </strong>
                        <select class="form-control" name="emp_team_head_id" id="emp_team_head_id" style="color:#a0acb7;">
                            <option value="">Select Team Head Name</option>
                            @foreach ($team_head_name as $item)
                                <option value="{{ $item->id }}" {{ old('emp_team_head_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->emo_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('emp_team_head_id')
                            <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

               
                <div class="mt-3">
                    <button type="submit"
                        class="text-white p-2 border-0 rounded px-3 fw-bold send_inquiry_btn" style="background-color: #ff004c;">Submit</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  
  </div>
  <script>
    var mobile_no = window.intlTelInput(document.querySelector("#mobile_no"), {
        separateDialCode: true,
        preferredCountries: ["in"],
        // hiddenInput: "full",
        utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
    });

    $("form").submit(function() {
            var full_number = mobile_no.getNumber();
            $("input[name='mobile_no[main]'").val(full_number);
            // alert(full_number)
    });

    $("#emp_document").change(function () {
        $("#selected_files").empty();
        var files = $(this)[0].files;
        for (var i = 0; i < files.length; i++) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#selected_files").append('<div class="file-preview"><img src="' + e.target.result +
                    '" alt="file-preview" /> ' + files[i].name + '</div>');
            }
            reader.readAsDataURL(files[i]);
        }
    });

    $(document).on('click', '.toggle-password', function() {

        $(this).toggleClass("fa-eye fa-eye-slash");

        var input = $("#emp_password");
        input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
    });
    $(document).on('click', '.toggle-password12', function() {

        $(this).toggleClass("fa-eye fa-eye-slash");

        var input = $("#confirmed_emp_password");
        input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
    });

    // $(document).ready(function () {
    //     $("#inquiry_form").submit(function (event) {
    //         // Get the values of the password fields
    //         var password = $("#emp_password").val();
    //         var confirmedPassword = $("#confirmed_emp_password").val();

    //         // Check if the passwords match
    //         if (password !== confirmedPassword) {
    //             // If passwords don't match, prevent the form submission and show an error message
    //             event.preventDefault();
    //             alert("Passwords do not match. Please enter matching passwords.");
    //         }
    //     });
    // });
</script>

<script>
$(document).ready(function () {

     // Custom validation to check for valid file types (image or pdf only)
     $.validator.addMethod("emp_document", function(value, element) {
        if (element.files && element.files.length > 0) {
            let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp|\.pdf)$/i;
            return allowedTypes.test(element.files[0].name);
        }
        return true;
    }, "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) and PDF files are allowed.");

    $.validator.addMethod("emp_bank_document", function(value, element) {
        if (element.files && element.files.length > 0) {
            let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp)$/i;
            return allowedTypes.test(element.files[0].name);
        }
        return true;
    }, "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) files are allowed.");

    $.validator.addMethod("profile_image", function(value, element) {
        if (element.files && element.files.length > 0) {
            let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp)$/i;
            return allowedTypes.test(element.files[0].name);
        }
        return true;
    }, "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) files are allowed.");

    $('.myForm').validate({ // initialize the plugin

        rules: {
            emp_name: {
                required: true
            },
            emp_email: {
                required: true,
                email: true,
                remote: {
                    url: '{{ route('admin.checkEmail') }}', // URL to the route that checks email
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: function() {
                            return $('.emp_email').val(); // Get the email value
                        }
                    }
                }
            },
            "emp_mobile_no[main]": {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            emp_address: {
                required: true
            },
            emp_department_name: {
                required: true
            },
            joining_date: {
                required: true
            },
            emp_birthday_date: {
                required: true
            },
            emp_password: {
                required: true,
            },
            confirmed_emp_password: {
                required: true,
                equalTo: "#emp_password"
            },
            role: {
                required: true
            },
            "emp_document[]": {
                emp_document: true,  // Custom validation for file types
            },
            emp_bank_document:{
                emp_bank_document: true,
            },
            profile_image:{
                profile_image: true,
            },
            emp_team_head_id: {
                // Default validation rules for emp_team_head_id
                required: function() {
                    // Check if the role is Employee (role == 2)
                    return $('#role').val() == '2';  // Only required if role is 2
                }
            }
        },
        messages: {
            emp_name: {
                required: "Employee name is required"
            },
            emp_email: {
                required: "Employee email is required",
                email: "Please enter a valid email address",
                remote: "This email already exists"
            },
            "emp_mobile_no[main]": {
                required: "The mobile number is required",
                number: "Please enter a valid mobile number",
                minlength: "The mobile number must be exactly 10 digits",
                maxlength: "The mobile number must be exactly 10 digits"
            },
            emp_address: {
                required: "Employee address is required"
            },
            emp_department_name: {
                required: "Employee department name is required"
            },
            joining_date: {
                required: "Employee joining date is required"
            },
            emp_birthday_date: {
                required: "Employee birthday date is required"
            },
            emp_password: {
                required: "The password is required",
            },
            confirmed_emp_password: {
                required: "The confirm password is required",
                equalTo: "The confirm password must match the password"
            },
            role: {
                required: "Employee role is required"
            },
            "emp_document[]": {
                emp_document: "Only image files (jpg, jpeg, png, svg, gif, jfif, webp) and PDF files are allowed.",
            },
            emp_bank_document:{
                emp_bank_document: "Only image files (jpg, jpeg, png, svg, gif, jfif, webp) files are allowed.",
            },
            profile_image:{
                profile_image: "Only image files (jpg, jpeg, png, svg, gif, jfif, webp) files are allowed.",
            },
            emp_team_head_id: {
                required: "Employee team head name is required"
            }
        },

        // Custom function to handle dynamic validation when role changes
        submitHandler: function(form) {
            form.submit();
        }
        });

        // Check if role changes dynamically (for example, on change event of the role select)
        $('#role').on('change', function() {
        $('.myForm').validate().element($('#emp_team_head_id'));  // Re-validate emp_team_head_id when role changes
        });
});

</script>

@endsection

