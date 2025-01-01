@extends('admin_layout.sidebar')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

{{-- mobile flage and country code selected script --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>

{{-- fa fa icon sacript --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />


<style>
    /* .mobile{
        width: 754px;
    } */
    .iti {
        width: 100%;
    }

    .form-control {
        color: #a0acb7;
    }

    .toZoom {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    .toZoom:hover {
        opacity: 0.7;
    }

    .modal {
        display: none;
        /* Hidden by default */
        position: absolute;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9);
        /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        /* max-width: 700px; */
    }

    /* Add Animation */
    .modal-content {
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @keyframes zoom {
        from {
            transform: scale(0.1)
        }

        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }

    .document-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        /* 6 items per row */
        gap: 10px;
        /* Space between items */
        margin-top: 10px;
    }

    .document-item img {
        width: 100%;
        height: auto;
        border: 1px solid #ddd;
        /* Optional: for styling */
        border-radius: 5px;
        /* Optional: for rounded corners */
    }
    


    .delete-modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
        padding-top: 60px;
    }

    /* Modal Content */
    .delete-modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
    }

    /* Close Button */
    .delete-close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .delete-close:hover,
    .delete-close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Button styles */
    .delete-modal button {
        margin: 5px;
    }
    .modal-backdrop.show {
        z-index: -1;
    }
</style>


<!-- Basic Layout -->
<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Employee Edit</h5> <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <form action="{{route('admin.employee.update', $data->id)}}" method="post" id="inquiry_form"
                    class="myForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="user_id" name="user_id" id="" value="{{$data->id ?? ''}}">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <strong>Full Name <span class="text-danger">*</span></strong>
                            <input type="text" name="emp_name" class="form-control" id="emp_name"
                                placeholder="Enter Employee Name" value="{{$data->emo_name ?? ''}}">
                            @error('emp_name')
                                <div class="text-danger fw-semibold">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group mt-3 mt-md-0">
                            <strong>Email <span class="text-danger">*</span></strong>
                            <input type="email" class="form-control emp_email" name="emp_email" id="emp_email"
                                placeholder="Enter Employee Email" value="{{$data->email ?? ''}}">
                            @error('emp_email')
                                <div class="text-danger fw-semibold">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6 form-group">
                            <strong style="display:flow-root;">Mobile no. <span class="text-danger">*</span></strong>
                            <input type="number" class="form-control mobile" name="emp_mobile_no[main]" id=""
                                placeholder="Enter Employee Mobile no" value="{{$data->emp_mobile_no ?? ''}}">

                            @error('emp_mobile_no.main')
                                <div class="text-danger fw-semibold">{{ $message }}</div>
                            @enderror
                            <label id="mobile_no-error" class="error" for="mobile_no" style=""></label>
                        </div>
                        <div class="col-md-6 form-group mt-3 mt-md-0">
                            <strong>Address <span class="text-danger">*</span></strong>
                            <input type="text" class="form-control" name="emp_address" id="emp_address"
                                placeholder="Enter Employee Address" value="{{$data->emp_address ?? ''}}">
                            @error('emp_address')
                                <div class="text-danger fw-semibold">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6 form-group">
                            <strong>Department Name <span class="text-danger">*</span></strong>
                            <select class="form-control" name="emp_department_name" id="emp_department_name"
                                style="color:#a0acb7;">
                                <option value="">Select Department Name</option>
                                @foreach ($department_name as $item)
                                    <option value="{{ $item->id }}" @if(isset($data->emp_department_name) && $data->emp_department_name == $item->id) selected @endif>
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
                            <input type="date" class="form-control" name="joining_date" id="joining_date" placeholder=""
                                value="{{ $data->joining_date ?? '' }}">
                            @error('joining_date')
                                <div class="text-danger fw-semibold">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6 form-group mt-3 mt-md-0">
                            <strong>Upload Employee Document</strong>
                            <input type="file" class="form-control" name="emp_document[]" id="emp_document" multiple>

                            @error('emp_document')
                                <div class="text-danger fw-semibold">{{ $message }}</div>
                            @enderror

                            <div class="mt-2">
                                <!-- Check if there are any documents in the emp_document field -->
                                @if($data->emp_document)
                                    @php
                                        // Convert the comma-separated string back into an array of file names
                                        $empDocuments = explode(',', $data->emp_document);
                                    @endphp

                                    <!-- Container for documents -->
                                    <div class="document-grid">
                                        <!-- Loop through each document and display it -->
                                        @foreach($empDocuments as $index => $document)
                                            @php
                                                // Check if the document exists in the folder
                                                $filePath = public_path('emp_document/' . $document);
                                                $extension = pathinfo($document, PATHINFO_EXTENSION);
                                            @endphp

                                            <!-- Only display the document if it exists -->
                                            @if(file_exists($filePath))
                                                <input type="hidden" value="{{$document}}" class="document-name">
                                                <div class="document-item mb-2" style="position: relative; display: inline-block; width: 120px; margin: 10px;">
                                                    
                                                    <!-- Check if it's an image or PDF -->
                                                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
                                                        <!-- Image Thumbnail -->
                                                        <img class="toZoom" src="{{ asset('emp_document/' . $document) }}" width="100" height="100" alt="Document" />
                                                        
                                                        <!-- Delete Icon (Positioned at the top-right corner) -->
                                                        <div class="icon-container delete-icon" style="position: absolute; top: 5px; right: 5px;">
                                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                                    data-index="{{ $index }}" data-document="{{ $document }}" title="Delete">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>

                                                    @elseif(strtolower($extension) == 'pdf')
                                                        <!-- PDF Icon using Font Awesome -->
                                                        <div class="pdf-icon-container" style="position: relative; cursor: pointer;">
                                                            <img src="{{ asset('assets/img/pdf.svg') }}" alt="PDF Icon" 
                                                                class="toPdf" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#pdfModal{{ $index }}"
                                                                data-pdf-src="{{ asset('emp_document/' . $document) }}"> <!-- Store the PDF source path in data-pdf-src -->
                                                            
                                                            <!-- Delete Icon (Positioned at the top-right corner) -->
                                                            <div class="icon-container delete-icon" style="position: absolute; top: 5px; right: 5px;">
                                                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                                        data-index="{{ $index }}" data-document="{{ $document }}" title="Delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <!-- Download Button (For both image and PDF) -->
                                                    <div class="icon-container" style="position: absolute; top: 40px; right: 5px;">
                                                        <a href="{{ asset('emp_document/' . $document) }}" class="btn btn-primary btn-sm" download title="Download">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                    </div>
                                                </div>

                                                <!-- Add a break after every 5 documents (if required) -->
                                                @if(($index + 1) % 5 == 0)
                                                    <div style="clear:both;"></div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                @endif



                                <!-- Modal for zooming in images -->
                                <div class="idMyModal modal">
                                    <span class="close">&times;</span>
                                    <img class="modal-content">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 form-group mt-3 mt-md-0">
                            <strong>Uplode Employee Bank Document </strong>
                            <input type="file" class="form-control" name="emp_bank_document" id="emp_bank_document">
                            @error('emp_bank_document')
                                <div class="text-danger fw-semibold">{{ $message }}</div>
                            @enderror
                            <div class="mt-2" style="position: relative;">
                                @php
                                    $filePath = public_path('emp_bank_document/' . $data->emp_bank_document); // Get full server path
                                @endphp

                                @if(!empty($data->emp_bank_document) && file_exists($filePath))
                                    <!-- Only show the image and delete button if the file exists -->
                                    <img class="toZoom" src="{{ asset('emp_bank_document/' . $data->emp_bank_document) }}" width="100" height="100" alt="Document">
                                    
                                    <!-- Delete Button -->
                                    <div class="emp_bank_document-icon-container delete-icon" style="position: absolute;top:5px;left:63px;">
                                        <button type="button" class="btn btn-danger btn-sm emp_bank_document-delete-btn"
                                                data-bank_document="{{ $data->emp_bank_document }}"
                                                data-id="{{ $data->id }}"
                                                title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="icon-container" style="position: absolute;top:75px;left:63px;">
                                        <a href="{{ asset('emp_bank_document/' . $data->emp_bank_document) }}"
                                            class="btn btn-primary btn-sm" download title="Download">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6 form-group">
                            <strong>Birthday Date <span class="text-danger">*</span></strong>
                            <input type="date" class="form-control" name="emp_birthday_date"
                                value="{{$data->emp_birthday_date ?? ''}}" id="emp_birthday_date"
                                placeholder="Enter Employee Birthday Date">
                            @error('emp_birthday_date')
                                <div class="text-danger fw-semibold">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group mt-3 mt-md-0">
                            <strong>Notes</strong>
                            <input type="text" class="form-control" name="notes" id="notes"
                                placeholder="Enter Employee Notes" value="{{ $data->emp_notes ?? '' }}">
                            @error('notes')
                                <div class="text-danger fw-semibold">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- <div class="row mt-3">
                    <div class="col-md-6 form-group mt-3 mt-md-0">
                        <strong>Password <span class="text-danger">*</span></strong>
                        <div class="input-group">
                            <input type="password" class="form-control" name="emp_password" id="emp_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="basic-default-password2" value="{{$data->password ?? ''}}" readonly/>
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
                            <input type="password" class="form-control" name="confirmed_emp_password" id="confirmed_emp_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="basic-default-password2" value="{{$data->password ?? ''}}" readonly/>
                            <span id="basic-default-password2" class="input-group-text cursor-pointer"><i class="fa fa-fw fa-eye field_icon toggle-password12"></i></span>
                        </div>
                        <label id="confirmed_emp_password-error" class="error" for="confirmed_emp_password"></label>
                        @error('emp_password')
                        <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                </div> -->
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
                            <div class="mt-2" style="position: relative;cursor: pointer;">
                                @php
                                    $filePath = public_path('profile_image/' . $data->profile_image); // Get full server path
                                @endphp

                                @if(!empty($data->profile_image) && file_exists($filePath)) 
                                    <!-- Only show the image and delete button if the file exists -->
                                    <img class="toZoom" src="{{ asset('profile_image/' . $data->profile_image) }}" width="100" height="100" alt="Document">
                                    
                                    <!-- Delete Button -->
                                    <div class="profile-icon-container delete-icon" style="position: absolute;top:5px;left:63px;">
                                        <button type="button" class="btn btn-danger btn-sm profile-delete-btn"
                                                data-profile_document="{{ $data->profile_image }}"
                                                data-user_id="{{ $data->id }}"
                                                title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="icon-container" style="position: absolute;top:75px;left:63px;">
                                        <a href="{{ asset('profile_image/' . $data->profile_image) }}"
                                            class="btn btn-primary btn-sm" download title="Download">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <strong>Role <span class="text-danger">*</span></strong>
                            <select class="form-control" name="role" id="role" style="color:#a0acb7">
                                <option value="">Select Role</option>
                                <option value="0" @if($data->role == '0') selected @endif>Admin</option>
                                <option value="1" @if($data->role == '1') selected @endif>Team Head</option>
                                <option value="2" @if($data->role == '2') selected @endif>Employee</option>
                                <option value="3" @if($data->role == '3') selected @endif>HR</option>
                            </select>
                            @error('role')
                                <div class="text-danger fw-semibold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6 form-group">
                                <strong>Team Head Name </strong>
                                <select class="form-control" name="emp_team_head_id" id="emp_team_head_id" style="color:#a0acb7;">
                                    <option value="">Select Team Head Name</option>
                                    @foreach ($team_head_name as $item)
                                        <option value="{{ $item->id }}" @if(isset($data->emp_team_head_id) && $data->emp_team_head_id == $item->id) selected @endif>
                                            {{ $item->emo_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('emp_team_head_id')
                                    <div class="text-danger fw-semibold">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>


                    <div class="mt-3">
                        <button type="submit" class="text-white p-2 border-0 rounded px-3 fw-bold send_inquiry_btn"
                            style="background-color: #ff004c;">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- Confirmation Modal for Delete -->
<div id="confirmDeleteModal" class="delete-modal" style="display: none;">
    <div class="delete-modal-content">
        <span class="delete-close" style="cursor: pointer;">&times;</span>
        <h4>Are you sure you want to delete this document?</h4>
        <button id="confirmDeleteBtn" class="btn btn-danger">Yes, Delete</button>
        <button id="cancelDeleteBtn" class="btn btn-secondary">Cancel</button>
    </div>
</div>

<!-- Confirmation Modal for Delete (Second Modal) -->
<div id="confirmDeleteModalSecond" class="delete-modal" style="display: none;">
    <div class="delete-modal-content">
        <span class="delete-close" style="cursor: pointer;">&times;</span>
        <h4>Are you sure you want to delete this image?</h4>
        <button id="confirmDeleteSecondBtn" class="btn btn-danger">Yes, Delete</button>
        <button id="cancelDeleteSecondBtn" class="btn btn-secondary">Cancel</button>
    </div>
</div>

<!-- Confirmation Modal for Delete (Second Modal) -->
<div id="profileConfirmDeleteModal" class="delete-modal" style="display: none;">
    <div class="delete-modal-content">
        <span class="delete-close" style="cursor: pointer;">&times;</span>
        <h4>Are you sure you want to delete this image?</h4>
        <button id="profileConfirmDelete" class="btn btn-danger">Yes, Delete</button>
        <button id="profileCancelDelete" class="btn btn-secondary">Cancel</button>
    </div>
</div>

@php
    // Convert the comma-separated string back into an array of file names
    $empDocuments = explode(',', $data->emp_document);
@endphp

@foreach($empDocuments as $index => $document)
    <div class="modal fade" id="pdfModal{{ $index }}" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="width: 1200px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">PDF Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- PDF Embed (Initially empty, will be populated dynamically) -->
                    <embed class="pdf-preview" type="application/pdf" width="100%" height="500px" />
                </div>
                <div class="modal-footer">
                    <!-- Add a download button -->
                    <a href="{{ asset('emp_document/' . $document) }}" class="btn btn-primary" download>
                        <i class="fa fa-download"></i> Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach

<div class="idMyModal modal">
    <span class="close">&times;</span>
    <img class="modal-content">
</div>

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
                            email: function () {
                                return $('.emp_email').val(); // Get the email value
                            },
                            user_id: function () {
                                return $('.user_id').val(); // Get the user_id value (e.g., from a hidden input)
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
                    required: "Employee adress is required"
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
                role: {
                    required: "Employee role is required"
                },
                "emp_document[]": {
                    emp_document: "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) and PDF files are allowed.",
                },
                emp_bank_document:{
                    emp_bank_document: "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) files are allowed.",
                },
                profile_image:{
                    profile_image: "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) files are allowed.",
                },
                emp_team_head_id: {
                    required: "Employee team head name is required"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        $('#role').on('change', function() {
            $('.myForm').validate().element($('#emp_team_head_id'));  // Re-validate emp_team_head_id when role changes
        });

    });

</script>

<script>
    // Get the modal
    var modal = document.querySelector(".idMyModal");
    var modalImg = document.querySelector(".modal-content");
    var closeModal = document.querySelector(".close");

    // Get all images with the 'toZoom' class
    var images = document.querySelectorAll(".toZoom");

    // When an image is clicked, show it in the modal
    images.forEach(function (image) {
        image.addEventListener("click", function () {
            modal.style.display = "block";
            modalImg.src = image.src;
        });
    });

    // When the user clicks the close button, hide the modal
    closeModal.addEventListener("click", function () {
        modal.style.display = "none";
    });

    // Optional: When the user clicks outside of the modal, hide it
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });

    // When a PDF icon is clicked, open the modal and load the PDF
document.querySelectorAll(".toPdf").forEach(function (pdfIcon) {
    pdfIcon.addEventListener("click", function () {
        // Get the PDF source from the data-pdf-src attribute
        var pdfSrc = pdfIcon.getAttribute("data-pdf-src");

        // Get the corresponding modal and PDF embed element
        var modalId = pdfIcon.getAttribute("data-bs-target");
        var modal = document.querySelector(modalId);
        var pdfEmbed = modal.querySelector(".pdf-preview");

        // Set the PDF source to the embed tag inside the modal
        pdfEmbed.src = pdfSrc;
    });
});

// Close the modal and clear the PDF source when the modal is closed
document.querySelectorAll(".btn-close").forEach(function (closeButton) {
    closeButton.addEventListener("click", function () {
        var modal = closeButton.closest(".modal");
        var pdfEmbed = modal.querySelector(".pdf-preview");
        pdfEmbed.src = ''; // Clear the PDF source when closing the modal
    });
});

// Optional: Close modal when clicking outside (if you want this behavior)
document.querySelectorAll('.modal').forEach(function (modal) {
    modal.addEventListener('hidden.bs.modal', function () {
        var pdfEmbed = modal.querySelector(".pdf-preview");
        pdfEmbed.src = ''; // Clear the PDF when the modal is fully hidden
    });
});
</script>

<script>
    $(document).ready(function () {
        var deleteIndex = null;  // To store the document index
        var deleteDocument = null;  // To store the document name
        var deleteRow = null; // To store the document row element for removal
        $(".delete-btn").click(function () {
            deleteIndex = $(this).data("index");
            deleteDocument = $(this).data("document");
            deleteRow = $(this).closest('.document-item');
            user_id = $('.user_id').val();

            // Show the modal
            $("#confirmDeleteModal").show();
        });

        // Close the modal when the user clicks "Cancel"
        $("#cancelDeleteBtn").click(function (event) {
            event.preventDefault(); 
            $("#confirmDeleteModal").hide();
        });

        // Handle the confirmation of deletion
        $("#confirmDeleteBtn").click(function () {
            $.ajax({
                url: '{{route('admin.delete-emp-document')}}',  // Backend route for deleting the document
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',  // CSRF token for security
                    index: deleteIndex,
                    document: deleteDocument,
                    user_id: user_id
                },
                success: function (response) {
                    if (response.success) {
                        deleteRow.remove();
                        $("#confirmDeleteModal").hide();
                    } else {
                        alert('Error deleting document');
                    }
                },
                error: function () {
                    alert('An error occurred while deleting the document.');
                }
            });
        });
        $(".delete-close").click(function () {
            $("#confirmDeleteModal").hide();
        });
    });

    $(document).ready(function () {
    var deleteDocument = null;  // To store the document or image name
    var deleteId = null;        // To store the document or image ID
    var deleteRow = null;       // To store the document or image row element for removal

    // Handle delete button click for the second modal
    $(".emp_bank_document-delete-btn").click(function () {
        deleteDocument = $(this).data("bank_document");
        deleteId = $(this).data("id");
        deleteRow = $(this).closest('.mt-2'); // Get the row that contains the image

        // Show the second modal
        $("#confirmDeleteModalSecond").show();
    });

    // Close the second modal when the user clicks "Cancel"
    $("#cancelDeleteSecondBtn").click(function (event) {
        event.preventDefault(); 
        $("#confirmDeleteModalSecond").hide();
    });

    // Handle the confirmation of deletion in the second modal
    $("#confirmDeleteSecondBtn").click(function () {
        $.ajax({
            url: '{{route('admin.delete.emp.bank.document')}}',  // Backend route for deleting the document
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',  // CSRF token for security
                document: deleteDocument,
                id: deleteId
            },
            success: function (response) {
                if (response.success) {
                    deleteRow.remove();  // Remove the image and button
                    $("#confirmDeleteModalSecond").hide();  // Hide the second modal
                } else {
                    alert('Error deleting document');
                }
            },
            error: function () {
                alert('An error occurred while deleting the document.');
            }
        });
    });

    // Close the second modal when the user clicks the close button (X)
    $(".delete-close").click(function () {
        $("#confirmDeleteModalSecond").hide();
    });
});

    $(document).ready(function () {
    var deleteDocument = null;  // To store the document or image name
    var deleteId = null;        // To store the document or image ID
    var deleteRow = null;       // To store the document or image row element for removal

    // Handle delete button click for the second modal
    $(".profile-delete-btn").click(function () {
        deleteDocument = $(this).data("profile_document");
        deleteId = $(this).data("user_id");
        deleteRow = $(this).closest('.mt-2'); // Get the row that contains the image

        // Show the second modal
        $("#profileConfirmDeleteModal").show();
    });

    // Close the second modal when the user clicks "Cancel"
    $("#profileCancelDelete").click(function (event) {
        event.preventDefault(); 
        $("#profileConfirmDeleteModal").hide();
    });

    // Handle the confirmation of deletion in the second modal
    $("#profileConfirmDelete").click(function () {
        $.ajax({
            url: '{{route('admin.delete.emp.profile.document')}}',  // Backend route for deleting the document
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',  // CSRF token for security
                document: deleteDocument,
                id: deleteId
            },
            success: function (response) {
                if (response.success) {
                    deleteRow.remove();  // Remove the image and button
                    $("#profileConfirmDeleteModal").hide();  // Hide the second modal
                } else {
                    alert('Error deleting document');
                }
            },
            error: function () {
                alert('An error occurred while deleting the document.');
            }
        });
    });

    // Close the second modal when the user clicks the close button (X)
    $(".delete-close").click(function () {
        $("#profileConfirmDeleteModal").hide();
    });
});
</script>


@endsection 