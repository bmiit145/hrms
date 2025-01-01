@extends('team_head.team_head_layout.sidebar')
@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

{{-- mobile flage and country code selected script --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>

{{-- fa fa icon sacript --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

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

    .layout-content-navbar .content-wrapper {
    align-content: center;
    width: 88%;
    margin: auto;
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

        body.dark-mode strong ,.info{
            color: #b0acc7 !important;
        }
        body.dark-mode .employee-details-card{
            background-color: #312d4b !important;
        }

    

</style>

<div class="employee-detail">
    <h4 class="d-flex">
         <strong>{{$data->emo_name ?? ''}}'s</strong>&nbsp;<p class="info">Information</p> 
    </h4>
    <div class="profile-image">
        @php
            // Path to the image
            $imagePath = public_path('profile_image/' . $data->profile_image);
            $imageExists = file_exists($imagePath); // Checks if the image exists in the folder
        @endphp
    
        @if($imageExists && !empty($data->profile_image))
            <!-- Show image if it exists in folder -->
            <div style="position: relative; display: inline-block; width: 100px;">
                <img class="profile-img" src="{{ asset('profile_image/' . $data->profile_image) }}" 
                    width="100" height="100" alt="Profile Image"  data-src="{{ asset('profile_image/' . $data->profile_image) }}"
                    data-bs-toggle="modal" 
                    data-bs-target="#imageModal" />
                <!-- Download Button -->
                {{-- <a href="{{ asset('profile_image/' . $data->profile_image) }}" 
                   class="btn btn-sm btn-primary"
                   download title="Download" 
                   style="position: absolute; top: 5px; left: 5px; background-color: #7e4ee6;color: #fff;">
                    <i class="fa fa-download"></i>
                </a> --}}
            </div>
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
            <p id="employee-department">   {{ $data->joining_date ? \Carbon\Carbon::parse($data->joining_date)->format('d-m-Y') : 'No Joining Date available' }}</p>
            <hr>
        </div>
        
        <div class="info-item">
            <label for="employee-hire-date">Birthday Date</label>
            <p id="employee-hire-date">{{ $data->emp_birthday_date ? \Carbon\Carbon::parse($data->emp_birthday_date)->format('d-m-Y') : 'No Birthday Date available' }}</p>
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

        <div class="info-item">
            <label for="employee-hire-date">Father Mobile Number</label>
            <p id="employee-hire-date">{{ $data->emp_father_mobile_no ?? 'No Notes available' }}</p>
            <hr>
        </div>

        <div class="info-item">
            <label for="employee-hire-date">Mother Mobile Number</label>
            <p id="employee-hire-date">{{ $data->emp_mother_mobile_no ?? 'No Notes available' }}</p>
            <hr>
        </div>

        <div class="info-item">
            <label for="employee-hire-date">Brother / Sister Mobile Number</label>
            <p id="employee-hire-date">{{ $data->emp_brother_sister_mobile_no ?? 'No Notes available' }}</p>
            <hr>
        </div>

        <div class="info-item">
            <label for="employee-hire-date">Monthly Salary</label>
            <p id="employee-hire-date">{{ $data->monthly_selery ?? 'No Notes available' }}</p>
            <hr>
        </div>

        <div class="info-item">
            <label for="employee-hire-date">Bank Number</label>
            <p id="employee-hire-date">{{ $data->bank_no ?? 'No Notes available' }}</p>
            <hr>
        </div>

        <div class="info-item">
           <label for="employee-hire-date">Bank Name</label>
            <p id="employee-hire-date">{{ $data->bank_name ?? 'No Notes available' }}</p>
            <hr>
        </div>

        <div class="info-item">
            <label for="employee-hire-date">Bank Document</label>
            <div class="profile-image mt-2">
                @php
                    // Path to the image
                    $imagePath = public_path('emp_bank_document/' . $data->emp_bank_document);
                    $imageExists = file_exists($imagePath); // Checks if the image exists in the folder
                @endphp
            
                @if($imageExists && !empty($data->emp_bank_document))
                    <!-- Show image if it exists in folder -->
                    <div style="position: relative; display: inline-block; width: 100px;">
                        <img class="profile-img" src="{{ asset('emp_bank_document/' . $data->emp_bank_document) }}" 
                            width="100" height="100" alt="Profile Image"  data-src="{{ asset('emp_bank_document/' . $data->emp_bank_document) }}"
                            data-bs-toggle="modal" 
                            data-bs-target="#imageModal" />
                        <!-- Download Button -->
                        <a href="{{ asset('emp_bank_document/' . $data->emp_bank_document) }}" 
                           class=" btn-sm "
                           download title="Download" 
                           style="position: absolute; top: 5px; left: 5px;color: #7e4ee6;">
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                @endif
            </div>
            <hr>
        </div>

        <div class="info-item">
            {{-- <label for="employee-hire-date">Bank Number</label>
            <p id="employee-hire-date">{{ $data->bank_no ?? 'No Notes available' }}</p>
            <hr> --}}
        </div>

        <div class="info-item">
            {{-- <label for="employee-hire-date">Bank Name</label>
            <p id="employee-hire-date">{{ $data->bank_name ?? 'No Notes available' }}</p>
            <hr> --}}
        </div>
        
        <!-- Document/Grid Container -->
        <div class="row col-12 col-md-4">
            <div class="info-item">            
                <label for="">Empolyee Document</label>
            </div>
            <div class="profile-image">
                @if($data->emp_document)
                    @php
                        $empDocuments = explode(',', $data->emp_document);
                    @endphp

                    <div class="document-grid">
                        @foreach($empDocuments as $index => $document)
                            @php
                                $extension = strtolower(pathinfo($document, PATHINFO_EXTENSION));
                                $filePath = public_path('emp_document/' . $document);
                            @endphp
                            @if(!empty($document) && file_exists($filePath))
                                <div class="document-item mb-2" style="position: relative; display: inline-block; width: 120px; margin: 10px;">
                                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
                                        <!-- Image Thumbnail -->
                                        <img class="preview-img" src="{{ asset('emp_document/' . $document) }}" width="100" height="100" alt="Document" data-bs-toggle="modal" data-bs-target="#imageModal" data-src="{{ asset('emp_document/' . $document) }}" />
                                    @elseif($extension == 'pdf')
                                        <!-- PDF Icon -->
                                        <div class="pdf-icon-container" style="cursor: pointer;">
                                            <img src="{{ asset('assets/img/icons/misc/pdf.png') }}" alt="PDF Icon" class="preview-pdf" data-bs-toggle="modal" data-bs-target="#pdfModal" data-pdf-src="{{ asset('emp_document/' . $document) }}">
                                        </div>
                                    @endif

                                    <!-- Download Button -->
                                    <div class="icon-container" style="position: absolute; top: 5px; right: 5px;">
                                        <a href="{{ asset('emp_document/' . $document) }}"  class=" btn-sm" download title="Download">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Modals -->
        <!-- Image Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="" alt="Image Preview" class="img-fluid" id="image-preview" />
                    </div>
                </div>
            </div>
        </div>

        <!-- PDF Modal -->
        <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="height: 1000%;width: 100%">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pdfModalLabel">Document Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <iframe id="pdfPreview" src="" width="100%" height="700px" style="border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>



<script>
    // Image Preview in Modal
    $(document).on('click', '.preview-img, .profile-img', function () {
        var imgSrc = $(this).data('src'); // Get the image source
        console.log(imgSrc);
        $('#image-preview')
        .attr('src', imgSrc) // Set the image source in the modal
        .css({
            objectFit: 'cover' // Ensure the image fits well
        });// Set the image in the modal
        $('#imageModal').modal('show'); // Show the modal
    });

    // PDF Preview in Modal
    $(document).on('click', '.preview-pdf', function () {
        var pdfSrc = $(this).data('pdf-src'); // Get the PDF source
        $('#pdfPreview').attr('src', pdfSrc); // Set the PDF in the iframe
        $('#pdfModal').modal('show'); // Show the modal
    });
</script>
@endsection
