@extends('admin_layout.sidebar')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xl">
            <div class="card mb-6">
                <h5 class="card-header">Employee Create</h5>
                <hr>
                <form action="{{route('admin.employee.store')}}" method="post" id="inquiry_form"
                    class="card-body myForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-6">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="emp_name" class="form-control" id="emp_name"
                                    placeholder="Enter Employee Name" value="{{ old('emp_name') }}">
                                @error('emp_name')
                                    <div class="text-danger fw-semibold">{{ $message }}</div>
                                @enderror
                                <label for="multicol-username">Full Name</label>
                            </div>
                            <label id="emp_name-error" class="error" for="emp_name"></label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline">
                                    <input type="email" class="form-control emp_email" name="emp_email" id="emp_email"
                                        placeholder="Enter Employee Email" value="{{ old('emp_email') }}">
                                    @error('emp_email')
                                        <div class="text-danger fw-semibold">{{ $message }}</div>
                                    @enderror
                                    <label for="multicol-email">Email</label>
                                </div>
                            </div>
                            <label id="emp_email-error" class="error" for="emp_email"></label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="number" class="form-control mobile" name="emp_mobile_no[main]"
                                            id="" placeholder="Enter Employee Mobile no"
                                            value="{{ old('emp_mobile_no.main') }}">

                                        @error('emp_mobile_no.main')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="multicol-password">Mobile Number</label>
                                    </div>
                                </div>
                                <label id="emp_mobile_no[main]-error" class="error" for="emp_mobile_no[main]"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" name="emp_address" id="emp_address"
                                            placeholder="Enter Employee Address" value="{{ old('emp_address') }}">
                                        @error('emp_address')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="multicol-address">Address</label>
                                    </div>
                                </div>
                                <label id="emp_address-error" class="error" for="emp_address"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-control select2" name="emp_department_name"
                                            data-placeholder="Select Department Name" id="emp_department_name"
                                            style="color:#a0acb7;">
                                            <option></option>
                                            @foreach ($department_name as $item)
                                                <option value="{{ $item->id }}" {{ old('emp_department_name') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('emp_department_name')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="multicol-address">Department Name</label>
                                    </div>
                                </div>
                                <label id="emp_department_name-error" class="error" for="emp_department_name"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control dob-picker" name="joining_date"
                                            id="joining_date" placeholder="Select Employee Joining Date"
                                            value="{{ old('joining_date') }}">
                                        @error('joining_date')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="multicol-address">Joining Date</label>
                                    </div>
                                </div>
                                <label id="joining_date-error" class="error" for="joining_date"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="file" class="form-control" name="emp_document[]" id="emp_document"
                                            multiple>
                                        @error('emp_document')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="multicol-address">Uplode Employee Document</label>
                                    </div>
                                </div>
                                <label id="emp_document-error" class="error" for="emp_document"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="file" class="form-control" name="emp_bank_document"
                                            id="emp_bank_document">
                                        @error('emp_bank_document')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="multicol-address">Uplode Employee Bank Document</label>
                                    </div>
                                </div>
                                <label id="emp_bank_document-error" class="error" for="emp_bank_document"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="date" class="form-control dob-picker" name="emp_birthday_date"
                                            id="emp_birthday_date" placeholder="Select Employee Birthday Date">
                                        @error('emp_birthday_date')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="multicol-address">Birthday Date</label>
                                    </div>
                                </div>
                                <label id="emp_birthday_date-error" class="error" for="emp_birthday_date"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" name="notes" id="notes"
                                            placeholder="Enter Employee Notes" value="{{ old('notes') }}">
                                        @error('notes')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="multicol-address">Notes</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline d-flex align-items-center w-100">
                                        <input type="password" class="form-control" name="emp_password"
                                            id="emp_password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="basic-default-password2" />
                                        <span id="basic-default-password2" class="input-group-text cursor-pointer">
                                            <i class="ri-eye-off-line ri-20px field_icon toggle-password"></i>
                                        </span>
                                        <label for="emp_password">Password</label>
                                    </div>
                                    @error('emp_password')
                                        <div class="text-danger fw-semibold">{{ $message }}</div>
                                    @enderror
                                    <label id="emp_password-error" class="error" for="emp_password"></label>
                                </div>
                                <div style="color:green">Password must be created name@123</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline d-flex align-items-center w-100">
                                        <input type="password" class="form-control" name="confirmed_emp_password"
                                            id="confirmed_emp_password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="basic-default-password2" />
                                        <span id="basic-default-password2" class="input-group-text cursor-pointer">
                                            <i class="ri-eye-off-line ri-20px field_icon toggle-password12"></i>
                                        </span>
                                        <label for="emp_password">Confirm Password</label>
                                    </div>
                                    @error('emp_password')
                                        <div class="text-danger fw-semibold">{{ $message }}</div>
                                    @enderror
                                    <label id="confirmed_emp_password-error" class="error"
                                        for="confirmed_emp_password"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="file" class="form-control" name="profile_image"
                                            id="profile_image" />
                                        @error('profile_image')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="multicol-address">Profile Picture</label>
                                    </div>
                                </div>
                                <label id="profile_image-error" class="error" for="profile_image"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-control select2" data-placeholder="Select Role" name="role"
                                            id="role" style="color:#a0acb7">
                                            <option></option>
                                            <option value="0">Admin</option>
                                            <option value="1">Team Head</option>
                                            <option value="2">Employee</option>
                                            <option value="3">HR</option>
                                        </select>
                                        @error('role')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="multicol-address">Role</label>
                                    </div>
                                </div>
                                <label id="role-error" class="error" for="role"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-control select2" data-placeholder="Select Team Head Name"
                                            name="emp_team_head_id" id="emp_team_head_id" style="color:#a0acb7;">
                                            <option></option>
                                            @foreach ($team_head_name as $item)
                                                <option value="{{ $item->id }}" {{ old('emp_team_head_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->emo_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('emp_team_head_id')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="multicol-address">Team Head Name</label>
                                    </div>
                                </div>
                                <label id="emp_team_head_id-error" class="error" for="emp_team_head_id"></label>
                            </div>
                        </div>
                    </div>
                    <div class="pt-6">
                        <button type="submit" class="btn btn-primary me-4 waves-effect waves-light">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    var mobile_no = window.intlTelInput(document.querySelector("#mobile_no"), {
        separateDialCode: true,
        preferredCountries: ["in"],
        // hiddenInput: "full",
        utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
    });

    $("form").submit(function () {
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

    $(document).on('click', '.toggle-password', function () {

        $(this).toggleClass("fa-eye fa-eye-slash");

        var input = $("#emp_password");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });
    $(document).on('click', '.toggle-password12', function () {

        $(this).toggleClass("fa-eye fa-eye-slash");

        var input = $("#confirmed_emp_password");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
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
        $.validator.addMethod("emp_document", function (value, element) {
            if (element.files && element.files.length > 0) {
                let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp|\.pdf)$/i;
                return allowedTypes.test(element.files[0].name);
            }
            return true;
        }, "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) and PDF files are allowed.");

        $.validator.addMethod("emp_bank_document", function (value, element) {
            if (element.files && element.files.length > 0) {
                let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp)$/i;
                return allowedTypes.test(element.files[0].name);
            }
            return true;
        }, "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) files are allowed.");

        $.validator.addMethod("profile_image", function (value, element) {
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
                            email: function () {
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
                emp_bank_document: {
                    emp_bank_document: true,
                },
                profile_image: {
                    profile_image: true,
                },
                emp_team_head_id: {
                    // Default validation rules for emp_team_head_id
                    required: function () {
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
                emp_bank_document: {
                    emp_bank_document: "Only image files (jpg, jpeg, png, svg, gif, jfif, webp) files are allowed.",
                },
                profile_image: {
                    profile_image: "Only image files (jpg, jpeg, png, svg, gif, jfif, webp) files are allowed.",
                },
                emp_team_head_id: {
                    required: "Employee team head name is required"
                }
            },

            // Custom function to handle dynamic validation when role changes
            submitHandler: function (form) {
                form.submit();
            }
        });

        // Check if role changes dynamically (for example, on change event of the role select)
        $('#role').on('change', function () {
            $('.myForm').validate().element($('#emp_team_head_id'));  // Re-validate emp_team_head_id when role changes
        });
    });

</script>

@endsection