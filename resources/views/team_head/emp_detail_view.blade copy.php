@extends('team_head.team_head_layout.sidebar')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    /* Custom styles for Employee and Modal */
    .employee {
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

    .editmodel {
        width: 200%;
        margin-left: -45%;
    }

    .iti {
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
        .editmodel {
            width: 100%;
            margin-left: 0%;
        }
    }

    /* Employee detail styling */
    .employee-details-card {
        margin: 20px auto;
        padding: 20px;
        border-radius: 10px;
        background-color: #f9f9f9;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .employee-details-card h5 {
        font-weight: bold;
        color: #333;
    }

    .employee-info {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .employee-info .info-item {
        flex: 1 1 30%;
        margin-bottom: 15px;
    }

    .employee-info .info-item label {
        font-weight: bold;
        display: block;
    }

    .employee-info .info-item p {
        margin: 0;
    }

    .employee-actions {
        text-align: center;
        margin-top: 30px;
    }

    .employee-actions button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #696cff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .employee-actions button:hover {
        background-color: #4e55e0;
    }

    .employee-detail {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .employee-detail h4 {
        color: black;
        margin: 0;
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

<div class="employee-detail">
    <h4>
        Employee <strong>{{$data->emo_name ?? ''}}</strong> Detail
    </h4>
    <div class="profile-image">
        @php
            // Path to the image
            $imagePath = public_path('profile_image/' . $data->profile_image);
            $imageExists = file_exists($imagePath); // Checks if the image exists in the folder
        @endphp
    
        @if($imageExists && !empty($data->profile_image))
            <!-- Show image if it exists in folder -->
            <img class="toZoom" src="{{ asset('profile_image/' . $data->profile_image) }}" width="100" height="100" alt="Profile Image" />
        @endif
    </div>
</div>

<div class="card employee-details-card">
    <div class="employee-info">
        <!-- Employee Profile Section -->
        <div class="info-item">
            <label for="employee-name">Name</label>
            <p id="employee-name">{{ $data->emo_name ?? 'No Name available' }}</p>
            <hr>
        </div>
        
        <div class="info-item">
            <label for="employee-position">Email</label>
            <p id="employee-position">{{ $data->email ?? 'No Email available' }}</p>
            <hr>
        </div>
        
        <div class="info-item">
            <label for="employee-email">Mobile Number</label>
            <p id="employee-email">{{ $data->emp_mobile_no ?? 'No Mobile Number available' }}</p>
            <hr>
        </div>
        
        <div class="info-item">
            <label for="employee-phone">Department Name</label>
            <p id="employee-phone">{{ $data->department->department_name ?? 'No Department Name available' }}</p>
            <hr>
        </div>
        
        <div class="info-item">
            <label for="employee-department">Joining Date</label>
            <p id="employee-department">{{ $data->joining_date ?? 'No Joining Date available' }}</p>
            <hr>
        </div>
        
        <div class="info-item">
            <label for="employee-hire-date">Birthday Date</label>
            <p id="employee-hire-date">{{ $data->emp_birthday_date ?? 'No Birthday Date available' }}</p>
            <hr>
        </div>
        
        <div class="info-item">
            <label for="employee-hire-date">Role</label>
            <p id="employee-hire-date">
                {{ $data->role == 1 ? 'Team Head' : ($data->role == 2 ? 'Employee' : ($data->role == 3 ? 'HR' : 'No Role available')) }}
            </p>
            <hr>
        </div>
        
        <div class="info-item">
            <label for="employee-hire-date">Address</label>
            <p id="employee-hire-date">{{ $data->emp_address ?? 'No Address available' }}</p>
            <hr>
        </div>
        
        <div class="info-item">
            <label for="employee-hire-date">Notes</label>
            <p id="employee-hire-date">{{ $data->emp_notes ?? 'No Notes available' }}</p>
            <hr>
        </div>

        <div class="row col-12 col-md-4">
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
                            <input type="hidden" value="{{ $document }}" class="document-name">
                            <div class="document-item mb-2" style="position: relative; display: inline-block; width: 120px; margin: 10px;">
                                @php
                                    // Get the file extension and full server path
                                    $extension = strtolower(pathinfo($document, PATHINFO_EXTENSION));
                                    $filePath = public_path('emp_document/' . $document); // Get full server path
                                @endphp
        
                                <!-- Check if the document exists -->
                                @if(!empty($document) && file_exists($filePath))
                                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
                                        <!-- Image Thumbnail -->
                                        <img class="toZoom" src="{{ asset('emp_document/' . $document) }}" width="100" height="100" alt="Document" />
                                    @elseif($extension == 'pdf')
                                        <!-- PDF Icon -->
                                        <div class="pdf-icon-container" style="position: relative; cursor: pointer;">
                                            <img src="{{ asset('assets/img/pdf.svg') }}" alt="PDF Icon" 
                                                class="toPdf" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#pdfModal{{ $index }}"
                                                data-pdf-src="{{ asset('emp_document/' . $document) }}">
                                        </div>
                                    @endif
        
                                    <!-- Download Button -->
                                    <div class="icon-container" style="position: absolute; top: 5px; right: 5px;">
                                        <a href="{{ asset('emp_document/' . $document) }}" class="btn btn-primary btn-sm" download title="Download">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </div>
                                @else
                                    <!-- Show blank space if document is not found -->
                                    <div style="width: 100px; height: 100px; background-color: #f0f0f0; border: 1px solid #ccc;"></div>
                                @endif
                            </div>
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
    </div>
</div>


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


<Script>
document.addEventListener('DOMContentLoaded', function () {
    // Click event for the profile image
    document.getElementById("profileImage").addEventListener("click", function () {
        var modal = document.getElementById("imageModal");
        var modalImage = document.getElementById("modalImage");

        // Set the profile image to the modal image
        modalImage.src = this.src; // Get the src of the clicked image

        // Show the modal
        modal.style.display = "block";
    });

    // Close modal when clicking close button
    document.querySelector(".btn-close").addEventListener("click", function () {
        var modal = document.getElementById("imageModal");
        var modalImage = document.getElementById("modalImage");

        // Close the modal
        modal.style.display = "none";
        modalImage.src = ""; // Clear the modal image source
    });

    // Close modal when clicking outside the modal (overlay)
    window.addEventListener("click", function (event) {
        var modal = document.getElementById("imageModal");
        var modalImage = document.getElementById("modalImage");

        if (event.target === modal) {
            modal.style.display = "none"; // Close modal
            modalImage.src = ""; // Clear the modal image source
        }
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

@endsection
