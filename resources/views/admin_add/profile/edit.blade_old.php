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
        position: absolute;
        z-index: 1;
        padding-top: 100px;
        left: 319px;
        top: 114px;
        width: 100%;
        height: 100%;
        width: 1500px;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.9);
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
          <h5 class="mb-0">Edit Profile</h5> <small class="text-muted float-end"></small>
        </div>
        <div class="card-body">
            <form action="{{ isset($data) ? route('admin.profile.update', $data->id) : '#' }}" method="post" id="inquiry_form" class="myForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="user_id" name="user_id" id="" value="{{$data->id ?? ''}}">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <strong>Full Name <span class="text-danger">*</span></strong>
                        <input type="text" name="emp_name" class="form-control" id="emp_name" placeholder="Enter Employee Name" value="{{ $data->emo_name ?? '' }}">
                        @error('emp_name')
                            <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mt-3 mt-md-0">
                        <strong>Email <span class="text-danger">*</span></strong>
                        <input type="email" class="form-control emp_email" name="emp_email" id="emp_email"
                            placeholder="Enter Employee Email" value="{{ $data->email ?? '' }}" >
                        @error('emp_email')
                            <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 form-group">
                        <strong style="display:flow-root;">Mobile no. <span class="text-danger">*</span></strong>
                        <input type="number" class="form-control mobile" name="emp_mobile_no[main]" id=""
                        placeholder="Enter Employee Mobile no" value="{{ $data->emp_mobile_no ?? '' }}" >

                        @error('emp_mobile_no.main')
                            <div class="text-danger fw-semibold">{{ $message }}</div>
                        @enderror
                        <label id="mobile_no-error" class="error" for="mobile_no" style=""></label>
                    </div>
                    <div class="col-md-6 form-group">
                        <strong>Birthday Date</strong>
                        <input type="date" class="form-control" name="emp_birthday_date" id="emp_birthday_date" value="{{ $data->emp_birthday_date ?? '' }}" placeholder="Enter Employee Birthday Date">
                        @error('emp_birthday_date')
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
                        <div class="mt-2" style="position: relative;">
                            @if(isset($data) && !empty($data->profile_image) && file_exists(public_path('profile_image/' . $data->profile_image)))
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
                </div>               
                <div class="mt-3">
                    <button type="submit"
                        class="text-white p-2 border-0 rounded px-3 fw-bold send_inquiry_btn btn btn-success">Update</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  
  </div>

  <div id="profileConfirmDeleteModal" class="delete-modal" style="display: none;">
    <div class="delete-modal-content">
        <span class="delete-close" style="cursor: pointer;">&times;</span>
        <h4>Are you sure you want to delete this image?</h4>
        <button id="profileConfirmDelete" class="btn btn-danger">Yes, Delete</button>
        <button id="profileCancelDelete" class="btn btn-secondary">Cancel</button>
    </div>
</div>

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
            profile_image:{
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
            profile_image:{
                profile_image: "Only image files (jpg, jpeg, png, svg, gif, jfif,webp) files are allowed.",
            }
        },
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

