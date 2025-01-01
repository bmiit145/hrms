@extends('admin_layout.sidebar')
@section('content')
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

        body.dark-mode .list-btn {
            color: #b0acc7 !important;
        }

        .list-btn {
            color: #8b8693;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            color: #fff !important;
        }

        label.error {
            display: block;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Festival List</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons btn-group flex-wrap">
                                <div class="dt-buttons btn-group flex-wrap">
                                    <a href="#" class="add_recode"><button
                                            class="btn create-new waves-effect waves-light employee"
                                            style=" background: #7e4ee6;color: #f0f8ff;border: none;" tabindex="0"
                                            aria-controls="DataTables_Table_0" type="button"><span><i
                                                    class="ri-add-line"></i> <span class="d-none d-sm-inline-block">Add New
                                                    Festival</span></span>
                                        </button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <table class="datatables-basic table table-bordered dataTable no-footer dtr-column" id="example"
                        aria-describedby="DataTables_Table_0_info" style="width: 1395px;">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select_all">
                                </th>
                                <th>Sr No.</th>
                                <th>Festival image</th>
                                <th>Festival Name</th>
                                <th>Festival Date</th>
                                <th>Notes</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($festival as $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="select_row" data-id="{{ $item->id }}">
                                    </td>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        @php
                                            $imagePath = public_path('festival_image/' . $item->festival_image);
                                        @endphp

                                        @if (file_exists($imagePath) && $item->festival_image)
                                            <img src="{{ asset('festival_image/' . $item->festival_image) }}"
                                                alt="Festival Image" height="50" width="50">
                                        @else
                                            <img src="{{ asset('assets/img/default_festival_image.jpg') }}" height="50"
                                                width="50" alt="Festival Image">
                                        @endif
                                    </td>
                                    <td>{{ $item->fetival_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->festival_date)->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="notes-display">
                                            <!-- Initially show the first 20 characters of notes -->
                                            <span class="notes-short">{{ \Str::limit($item->notes, 20) }}</span>

                                            <!-- Show "Show More" link if notes are longer than 20 characters -->
                                            @if (strlen($item->notes) > 20)
                                                <span class="notes-more">
                                                    <a href="javascript:void(0)" class="show-more">Show More</a>
                                                </span>
                                            @endif

                                            <!-- Full notes that will be shown when "Show More" is clicked -->
                                            <span class="notes-full" style="display: none;">{{ $item->notes }}</span>

                                            <!-- Show Less link -->
                                            <span class="show-less" style="display: none;">
                                                <a href="javascript:void(0)" class="show-less">Show Less</a>
                                            </span>
                                        </span>
                                    </td>
                                    <td><a class="edit" href="#" data-id='{{ $item->id }}'
                                            data-festival_image='{{ $item->festival_image }}'
                                            data-fetival_name='{{ $item->fetival_name }}'
                                            data-festival_date='{{ $item->festival_date }}'
                                            data-notes='{{ $item->notes }}'>
                                            <i class="ri-edit-box-line ri-22px list-btn"></i>
                                        </a>
                                        <a href="#" class="delete"  id="delete_btn"data-id='{{ $item->id }}'>
                                            <i class="ri-delete-bin-7-line ri-22px list-btn"></i>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button class="dt-button buttons-delete btn btn-danger buttons-html5 btn-delete" tabindex="0"
                        aria-controls="example" type="button" style="display:none !important;" id="delete_button">
                        <i class="ri-delete-bin-7-line" style="position: absolute;margin-left: -9px;margin-top: -9px;"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Add modal -->
        <div class="offcanvas offcanvas-end" id="addFestival" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="addFestival">Add Festival</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="{{ route('admin.festival_store') }}" method="post" id="myForm"
                    enctype="multipart/form-data"
                    class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework myForm">
                    @csrf
                    <!-- Full Name -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-cake-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="Enter Festival Name"
                                    name="fetival_name" />
                                <label for="basicFullname">Festival</label>
                            </div>
                        </div>
                        <label id="fetival_name-error" class="error remove-error" for="fetival_name"></label>
                    </div>

                    <!-- Email -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" readonly class="form-control dob-picker"
                                    placeholder="Select Festival Date" name="festival_date" />
                                <label for="basicFullname">Date</label>
                            </div>
                        </div>
                        <label id="festival_date-error" class="error remove-error" for="festival_date"></label>
                    </div>

                    <!-- Mobile Number -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-image-ai-line"></i></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="file" class="form-control" name="festival_image" />
                                <label for="basicFullname">Festival Image</label>
                            </div>
                        </div>
                        <label id="add_emp_mobile_no-error" class="error remove-error" for="add_emp_mobile_no"></label>
                    </div>

                    <!-- Address -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-sticky-note-add-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="Enter Notes" name="notes" />
                                <label for="basicFullname">Notes</label>
                            </div>
                        </div>
                        <label id="add_emp_address-error" class="error remove-error" for="add_emp_address"></label>
                    </div>

                    <!-- Buttons -->
                    <div class="col-sm-12">
                        <button type="submit" class="btn data-submit me-sm-4 me-1 waves-effect waves-light"
                        style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;">Save</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!--  Edit modal -->
        <div class="offcanvas offcanvas-end" id="editFestival" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="editFestival">Edit Festival</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="{{ route('admin.festival_edit') }}" method="post" id="editForm"
                    enctype="multipart/form-data"
                    class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework myForm">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <!-- Festival Name -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-cake-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="Enter Festival Name"
                                    name="fetival_name" id="fetival_name" />
                                <label for="basicFullname">Festival</label>
                            </div>
                        </div>
                        <label id="fetival_name-error" class="error remove-error" for="fetival_name"></label>
                    </div>

                    <!-- Date -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" readonly class="form-control dob-picker"
                                    placeholder="Select Festival Date" name="festival_date" id="festival_date" />
                                <label for="basicFullname">Date</label>
                            </div>
                        </div>
                        <label id="festival_date-error" class="error remove-error" for="festival_date"></label>
                    </div>

                    <!-- Image -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-image-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="file" class="form-control" name="festival_image" id="festival_image" />
                                <label for="basicFullname">Festival Image </label>
                            </div>
                        </div>
                        <label id="festival_image-error" class="error remove-error" for="profile_image"></label>
                        <div class="mt-3" style="cursor: pointer;" id="festival_image_preview"></div>
                    </div>

                    <!-- Address -->
                    <div class="col-sm-12 fv-plugins-icon-container mt-5">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-sticky-note-add-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="Enter Notes" name="notes"
                                    id="notes" />
                                <label for="basicFullname">Notes</label>
                            </div>
                        </div>
                        <label id="add_emp_address-error" class="error remove-error" for="add_emp_address"></label>
                    </div>

                    <!-- Buttons -->
                    <div class="col-sm-12">
                        <button type="submit" class="btn  data-submit me-sm-4 me-1 waves-effect waves-light"
                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;">Update</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Image Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="" alt="Image Preview" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>


        <!-- Delete Confirmation Modal (Offcanvas) -->
        <div class="offcanvas offcanvas-end" id="deleteMultiplateRowModal" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title">Delete Festivals</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <h5 class="text-center">Are you sure you want to delete the selected festivals?</h5>
                <form method="POST" id="delete-form">
                    <input type="hidden" name="ids" id="delete-ids">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal (Offcanvas) -->
        <div class="offcanvas offcanvas-end" id="deletemodal" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title">Delete Festival</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <h5 class="text-center">Are you sure you want to delete this festival?</h5>
                <button id="deletemember" class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </div>        
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
    
<script>
    $(document).ready(function() {
        $(document).on('click', '.add_recode', function(event) {
            event.preventDefault();
            const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('addFestival'));
            offcanvasEdit.show();

            // Custom validation methods
            $.validator.addMethod("festival_image_val", function(value, element) {
                // Check if a file is selected
                if (element.files && element.files.length > 0) {
                    let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp)$/i;
                    return allowedTypes.test(element.files[0].name);
                }
                return true; // If no file is selected, validation passes
            }, "Only image files (jpg, jpeg, png, svg, gif, jfif, webp) are allowed.");

            // Initialize validation plugin
            $('#myForm').validate({
                rules: {
                    fetival_name: {
                        required: true
                    },
                    festival_date: {
                        required: true
                    },
                    festival_image: {
                        festival_image_val: true, // Only validate the image if it's selected
                    }
                },
                messages: {
                    fetival_name: {
                        required: "Festival name is required"
                    },
                    festival_date: {
                        required: "Festival date is required"
                    },
                    festival_image: {
                        festival_image_val: "Only image files (jpg, jpeg, png, svg, gif, jfif, webp) are allowed."
                    }
                },
                // Submit handler
                submitHandler: function(form) {
                    form.submit(); // Submit the form if validation passes
                }
            });
        });
    });

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function formatDate(date) {
            var d = new Date(date);
            var day = ("0" + d.getDate()).slice(-2); // Ensures two digits
            var month = ("0" + (d.getMonth() + 1)).slice(-2); // Months are zero-indexed
            var year = d.getFullYear();

            return day + '-' + month + '-' + year;
        }

        $(document).on('click', '.edit', function(event) {
            event.preventDefault();

            // Fetching data attributes
            var id = $(this).data('id');
            var fetival_name = $(this).data('fetival_name');
            var festival_date = $(this).data('festival_date');
            var festival_image = $(this).data('festival_image');
            var notes = $(this).data('notes');

            // Showing the offcanvas
            const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('editFestival'));
            offcanvasEdit.show();

            var formattedFestival_date = formatDate(festival_date);

            // Setting values to the form fields
            $('#id').val(id);
            $('#fetival_name').val(fetival_name);
            $('#festival_date').val(formattedFestival_date);
            $('#notes').val(notes);

            if (festival_image) {
                var bankFileExt = festival_image.split('.').pop()
                    .toLowerCase(); // Get the file extension
                var bankFilePath = '{{ asset('festival_image/') }}' + '/' +
                    festival_image; // Construct the image path

                // Check if the file exists using an AJAX HEAD request
                $.ajax({
                    url: bankFilePath,
                    type: 'HEAD',
                    success: function() {
                        // File exists, display the image
                        $('#festival_image_preview').empty();
                        var bankImgElement = $('<img>')
                            .attr('src', bankFilePath)
                            .addClass('img-thumbnail')
                            .css('max-width', '100px')
                            .css('margin-right', '10px')
                            .addClass('preview-img');
                        $('#festival_image_preview').append(bankImgElement).show();
                    },
                    error: function() {
                        // File does not exist, show a placeholder
                        $('#festival_image_preview').empty();
                    }
                });
            } else {
                // If festival_image is null or empty, show a placeholder
                $('#festival_image_preview').empty();
            }

        });

        // Handle the form submission for the edit
        $.validator.addMethod("festival_image_val", function(value, element) {
            // Check if a file is selected
            if (element.files && element.files.length > 0) {
                let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp)$/i;
                return allowedTypes.test(element.files[0].name);
            }
            return true; // If no file is selected, validation passes
        }, "Only image files (jpg, jpeg, png, svg, gif, jfif, webp) are allowed.");

        // Apply validation to the form
        $('#editForm').validate({
            // Validation rules
            rules: {
                fetival_name: {
                    required: true // Festival name is required
                },
                festival_date: {
                    required: true // Festival date is required
                },
                festival_image: {
                    festival_image_val: true, // Only validate the image if it's selected
                }
            },
            // Validation messages
            messages: {
                fetival_name: {
                    required: "Festival name is required"
                },
                festival_date: {
                    required: "Festival date is required"
                },
                festival_image: {
                    festival_image_val: "Only image files (jpg, jpeg, png, svg, gif, jfif, webp) are allowed."
                }
            },
            // Submit handler (submit the form if validation is successful)
            submitHandler: function(form) {
                var formData = new FormData(form); // Get form data including files
                var url = $(form).attr('action'); // Get form action URL

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        location
                            .reload(); // Reload the page after successful submission
                    },
                    error: function(response) {
                        // Handle any error if needed
                        alert('An error occurred. Please try again.');
                    }
                });
            }
        });

        // Handling image click to open in modal
        $(document).on('click', '.preview-img', function() {
            var imgSrc = $(this).attr('src');
            $('#imageModal img').attr('src', imgSrc); // Set the image in the modal
            $('#imageModal').modal('show'); // Show the modal
        });

        // Handling PDF icon click to open PDF in modal
        $(document).on('click', '.preview-pdf', function() {
            var pdfUrl = $(this).data('pdf-url'); // Get the PDF URL from the data attribute

            // Set the PDF URL to the iframe
            $('#pdfPreview').attr('src', pdfUrl);

            // Show the modal
            $('#pdfModal').modal('show');
        });

        $(document).on('click', '.delete', function(event) {
            event.preventDefault();
            var id = $(this).data('id'); // Get the festival ID from data attribute

            // Show the delete modal
            const offcanvasDelete = new bootstrap.Offcanvas(document.getElementById('deletemodal'));
            offcanvasDelete.show();

            // Assign the festival ID to the delete button (hidden input)
            $('#deletemember').data('id', id); // Use data() to store the ID directly
        });

        $('#deletemember').click(function() {
            var id = $(this).data('id'); // Get the festival ID from the button's data attribute

            // Send an AJAX request to delete the festival
            $.ajax({
                url: "{{ route('admin.delete-festival') }}",
                type: "DELETE",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}" // CSRF token for security
                },
                success: function(response) {
                    if (response.success) {
                        $('#deletemodal').modal('hide'); // Close the modal
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert(response.message || 'Error deleting the festival.');
                    }
                },
            });
        });


    });
</script>

<script>
    // jQuery to toggle between Show More and Show Less
    $(document).ready(function() {
        $('.show-more').click(function() {
            var parent = $(this).closest('.notes-display');
            parent.find('.notes-short').hide(); // Hide the short text
            parent.find('.notes-more').hide(); // Hide the "Show More" link
            parent.find('.notes-full').show(); // Show the full notes
            parent.find('.show-less').show(); // Show the "Show Less" link
        });

        $('.show-less').click(function() {
            var parent = $(this).closest('.notes-display');
            parent.find('.notes-short').show(); // Show the short text
            parent.find('.notes-more').show(); // Show the "Show More" link
            parent.find('.notes-full').hide(); // Hide the full notes
            parent.find('.show-less').hide(); // Hide the "Show Less" link
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Function to toggle the Delete button visibility based on selected checkboxes
        function toggleDeleteButton() {
            var selectedCount = $('.select_row:checked').length; // Count how many checkboxes are checked
            if (selectedCount > 0) {
                $('#delete_button').attr('style',
                    'display: block !important;width: 16px !important;height: 32px !important;'
                    ); // Show the delete button
            } else {
                $('#delete_button').attr('style', 'display: none !important;'); // Hide the delete button
            }
        }

    // Select/Deselect all checkboxes when the 'Select All' checkbox is clicked
    $('#select_all').on('click', function() {
        var isChecked = $(this).prop('checked'); // Get the checked status of 'Select All'
        $('.select_row').prop('checked', isChecked); // Set the checked status of all rows
        toggleDeleteButton(); // Update Delete button visibility
    });

    // Update the 'Select All' checkbox based on individual row checkboxes
    $('.select_row').on('click', function() {
        var allChecked = $('.select_row').length === $('.select_row:checked').length; // Check if all checkboxes are selected
        $('#select_all').prop('checked', allChecked); // Update 'Select All' checkbox
        toggleDeleteButton(); // Update Delete button visibility
    });

    // Handle multiple delete button click
    $('#delete_button').on('click', function () {
        var selectedIds = $('.select_row:checked').map(function () {
            return $(this).data('id');
        }).get(); // Collect selected IDs

        if (selectedIds.length > 0) {
            // Open delete confirmation modal for multiple deletions
            const offcanvasDelete = new bootstrap.Offcanvas(document.getElementById('deleteMultiplateRowModal'));
            offcanvasDelete.show();
            $('#delete-ids').val(selectedIds.join(',')); // Set IDs in hidden input
        }
    });

    // Handle single delete icon click
    $(document).on('click', '.delete', function (event) {
        event.preventDefault();
        var id = $(this).data('id'); // Get selected ID

        // Open delete confirmation modal for single deletion
        const offcanvasDelete = new bootstrap.Offcanvas(document.getElementById('deletemodal'));
        offcanvasDelete.show();
        $('#delete-ids').val(id); // Set ID in hidden input
    });

    // Handle delete submission for both single and multiple entries
    $('#deletemember, #delete-form button[type="submit"]').click(function (event) {
        event.preventDefault();
        var ids = $('#delete-ids').val(); // Get IDs from hidden input

        $.ajax({
            url: "{{ route('admin.delete-festival') }}",
            type: "POST",
            data: {
                ids: ids,
                _token: "{{ csrf_token() }}" // CSRF token
            },
            success: function (response) {
                if (response.success) {
                    location.reload(); // Reload page on success
                } else {
                    alert(response.message || 'Error deleting the festival(s).');
                }
            },
            error: function () {
                alert('An error occurred while deleting the festival(s).');
            }
        });
    });
});

</script>
@endsection
