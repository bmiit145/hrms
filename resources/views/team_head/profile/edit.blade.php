@extends('team_head.team_head_layout.sidebar')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        div.dataTables_wrapper {
            position: relative;
            padding: 1.5%;
        }

        .light-style table.table-bordered.dataTable th,
        .light-style table.table-bordered.dataTable td {
            border-color: #E6E59C !important;
        }

        table.dataTable.no-footer {
            border-bottom: 0px solid #e6e5e8;
        }

        body.dark-mode table.dataTable.no-footer {
            border-bottom: 0px solid #474360;
        }

        .nav-link {
            color: black;
            background-color: transparent;
        }

        .nav-link.active {
            color: white;
            background-color: #8c57ff;
        }

        body.dark-mode .tablink {
            color: #d5d1ea !important;
        }

        .form-check-input:checked {
            background-color: #8c57ff !important;
            border: none !important;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">


        <div class="row">
            <!-- User Sidebar -->
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card mb-6">
                    <div class="card-body pt-12">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                @if (isset($data) && !empty($data->profile_image) && file_exists(public_path('profile_image/' . $data->profile_image)))
                                    <!-- Only show the image and delete button if the file exists -->
                                    <img class="toZoom" src="{{ asset('profile_image/' . $data->profile_image) }}"
                                        width="100" height="100" alt="Document">
                                @else
                                    <img class="img-fluid rounded mb-4" src="{{ asset('assets/img/avatars/2.png') }}"
                                        height="120" width="120" alt="User avatar">
                                @endif
                                <div class="user-info text-center">
                                    <h5>{{ $data->emo_name ?? '' }}</h5>
                                </div>
                            </div>
                        </div>
                        <h5 class="pb-4 border-bottom mb-4">Details</h5>
                        <div class="info-container">
                            <ul class="list-unstyled mb-6">
                                <li class="mb-2">
                                    <span class="h6">Full Name :</span>
                                    <span>{{ $data->emo_name ?? '' }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="h6">Email :</span>
                                    <span>{{ $data->email ?? '' }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="h6">Contact :</span>
                                    <span>{{ $data->emp_mobile_no ?? '' }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="h6">Birthday Date :</span>
                                    <span>{{ isset($data->emp_birthday_date) ? \Carbon\Carbon::parse($data->emp_birthday_date)->format('d-m-Y') : '' }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="h6">Address :</span>
                                    <span>{{ $data->emp_address ?? '' }}</span>
                                </li>
                            </ul>
                            <div class="d-flex justify-content-center">
                                <a href="javascript:;" class="btn me-4 waves-effect waves-light"
                                    style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;"
                                    data-bs-target="#editUser" data-bs-toggle="modal">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /User Card -->
            </div>
            <!--/ User Sidebar -->


            <!-- User Content -->
            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                <!-- User Tabs -->
                <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light tablink" href="javascript:void(0);"
                                style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;"
                                id="defaultOpen" onclick="openPage('Security', this, '#8c57ff')">
                                <i class="ri-lock-2-line me-1_5"></i>Security
                            </a>
                        </li>
                    </ul>

                    <div id="Security" class="tabcontent">
                        <!-- Change Password -->
                        <div class="card mb-6">
                            <h5 class="card-header">Change Password</h5>
                            <div class="card-body">
                                <form action="{{ route('admin.changepass') }}" id="passwordForm" method="POST"
                                    class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $data->id ?? '' }}">
                                    <div class="row gx-5">
                                        <div class="mb-4 col-12 col-sm-6 form-password-toggle fv-plugins-icon-container">
                                            <div class="input-group input-group-merge">
                                                <div class="form-floating form-floating-outline">
                                                    <input class="form-control" type="password" id="emp_password"
                                                        name="emp_password" placeholder="············">
                                                    <label for="newPassword">New Password</label>
                                                </div>
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="ri-eye-off-line ri-20px"></i></span>
                                            </div>
                                            <label id="emp_password-error" class="error" for="emp_password"></label>
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="mb-4 col-12 col-sm-6 form-password-toggle fv-plugins-icon-container">
                                            <div class="input-group input-group-merge">
                                                <div class="form-floating form-floating-outline">
                                                    <input class="form-control" type="password" name="confirm_password"
                                                        id="confirm_password" placeholder="············">
                                                    <label for="confirmPassword">Confirm New Password</label>
                                                </div>
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="ri-eye-off-line ri-20px"></i></span>
                                            </div>
                                            <label id="confirm_password-error" class="error"
                                                for="confirm_password"></label>
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <button type="submit" class="btn me-2 waves-effect waves-light"
                                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;">Change
                                                Password</button>
                                        </div>
                                    </div>
                                    <input type="hidden">
                                </form>
                            </div>
                        </div>
                        <!--/ Change Password -->
                    </div>
                </div>
                <!--/ User Content -->
            </div>

            <!-- Modal -->
            <!-- Edit User Modal -->
            <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            <div class="text-center mb-6">
                                <h4 class="mb-2">Edit {{ $data->emo_name ?? '' }} Information</h4>
                            </div>
                            <form action="{{ route('admin.profile.update') }}" method="post" id="editUserForm"
                                class="row g-5 fv-plugins-bootstrap5 fv-plugins-framework myForm"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="user_id" name="user_id" value="{{ $data->id ?? '' }}">
                                <div class="col-12 col-md-6 fv-plugins-icon-container">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="emp_name" class="form-control" id="emp_name"
                                            placeholder="Enter Name" value="{{ $data->emo_name ?? '' }}">
                                        @error('emp_name')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="modalEditUserFirstName">Full Name</label>
                                    </div>
                                    <label id="emp_name-error" class="error" for="emp_name"></label>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 fv-plugins-icon-container">
                                    <div class="form-floating form-floating-outline">
                                        <input type="email" class="form-control emp_email" name="emp_email"
                                            id="emp_email" placeholder="Enter Email" value="{{ $data->email ?? '' }}">
                                        @error('emp_email')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="modalEditUserLastName">Email</label>
                                    </div>
                                    <label id="emp_email-error" class="error" for="emp_email"></label>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="number" class="form-control mobile" name="emp_mobile_no[main]"
                                            id="" placeholder="Enter Mobile no"
                                            value="{{ $data->emp_mobile_no ?? '' }}">

                                        @error('emp_mobile_no.main')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="modalEditUserName">Mobile Number</label>
                                    </div>
                                    <label id="emp_mobile_no[main]-error" class="error"
                                        for="emp_mobile_no[main]"></label>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" readonly class="form-control dob-picker" name="emp_birthday_date"
                                            id="emp_birthday_date" value="{{ $data->emp_birthday_date ?? '' }}"
                                            placeholder="Select Birthday Date">
                                        @error('emp_birthday_date')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="modalEditUserEmail">Birthday Date</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <textarea name="address" class="form-control" row="3" placeholder="Enter Address">{{ $data->emp_address ?? '' }}</textarea>
                                        @error('emp_birthday_date')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="modalEditUserEmail">Address</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input type="file" class="form-control" name="profile_image"
                                            id="profile_image" />
                                        @error('profile_image')
                                            <div class="text-danger fw-semibold">{{ $message }}</div>
                                        @enderror
                                        <label for="modalEditUserEmail">Profile Picture</label>
                                    </div>
                                    <label id="profile_image-error" class="error" for="profile_image"></label>
                                    <div class="mt-2" style="position: relative;">
                                        @if (isset($data) && !empty($data->profile_image) && file_exists(public_path('profile_image/' . $data->profile_image)))
                                            <!-- Only show the image and delete button if the file exists -->
                                            <img class="toZoom"
                                                src="{{ asset('profile_image/' . $data->profile_image) }}" width="150"
                                                height="150" alt="Document">
                                            <div class="icon-container" style="position: absolute;top:1px;left:130px;">
                                                <a href="{{ asset('profile_image/' . $data->profile_image) }}"
                                                    style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;"
                                                    class="btn btn-primary btn-sm" download title="Download">
                                                    <i class="ri-download-2-line"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn me-3 waves-effect waves-light"
                                        style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary waves-effect"
                                        data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                </div>
                                <input type="hidden">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Edit User Modal -->

            <!-- /Modal -->
        </div>


        {{-- datable java script --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

        <script>
            function openPage(pageName, elmnt, color) {
                var i, tabcontent, tablinks;

                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }

                tablinks = document.getElementsByClassName("nav-link");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                    tablinks[i].style.backgroundColor = "transparent"; // Reset background color for inactive tabs
                }

                document.getElementById(pageName).style.display = "block";
                elmnt.className += " active";
                elmnt.style.backgroundColor = color; // Set background color for active tab
            }

            // Set default open tab
            document.getElementById("defaultOpen").click();
        </script>

        <script>
            $(document).ready(function() {
                var deleteDocument = null; // To store the document or image name
                var deleteId = null; // To store the document or image ID
                var deleteRow = null; // To store the document or image row element for removal

                // Handle delete button click for the second modal
                $(".profile-delete-btn").click(function() {
                    deleteDocument = $(this).data("profile_document");
                    deleteId = $(this).data("user_id");
                    deleteRow = $(this).closest('.mt-2'); // Get the row that contains the image

                    // Show the second modal
                    $("#profileConfirmDeleteModal").show();
                });

                // Close the second modal when the user clicks "Cancel"
                $("#profileCancelDelete").click(function(event) {
                    event.preventDefault();
                    $("#profileConfirmDeleteModal").hide();
                });

                // Handle the confirmation of deletion in the second modal
                $("#profileConfirmDelete").click(function() {
                    $.ajax({
                        url: '{{ route('admin.delete.emp.profile.document') }}', // Backend route for deleting the document
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}', // CSRF token for security
                            document: deleteDocument,
                            id: deleteId
                        },
                        success: function(response) {
                            if (response.success) {
                                deleteRow.remove(); // Remove the image and button
                                $("#profileConfirmDeleteModal").hide(); // Hide the second modal
                            } else {
                                alert('Error deleting document');
                            }
                        },
                        error: function() {
                            alert('An error occurred while deleting the document.');
                        }
                    });
                });

                // Close the second modal when the user clicks the close button (X)
                $(".delete-close").click(function() {
                    $("#profileConfirmDeleteModal").hide();
                });
            });
        </script>

        <script>
            $(document).ready(function() {

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
                                    },
                                    user_id: function() {
                                        return $('.user_id')
                                    .val(); // Get the user_id value (e.g., from a hidden input)
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
                        profile_image: {
                            profile_image: true,
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
                        profile_image: {
                            profile_image: "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) files are allowed.",
                        }
                    },
                });

                $('#passwordForm').validate({
                    rules: {
                        emp_password: {
                            required: true,
                        },
                        confirm_password: {
                            required: true,
                            equalTo: "#emp_password"
                        },
                    },
                    messages: {
                        emp_password: {
                            required: "The password is required",
                        },
                        confirm_password: {
                            required: "The confirm password is required",
                            equalTo: "The confirm password must match the password"
                        },
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });
        </script>
    @endsection
