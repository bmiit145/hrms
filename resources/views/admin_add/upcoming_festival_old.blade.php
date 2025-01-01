@extends('admin_layout.sidebar')
@section('content')

{{-- fa fa icon sacript --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

{{-- data-table css --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" />


<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
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

    html:not(.layout-footer-fixed) .content-wrapper {
        padding-bottom: 520px !important;
    }


    @media (max-width: 767px) {
        .employee {
            margin-left: 41%;
            /* Adjust the margin for smaller screens */
            width: 13%;
            /* Make the button full width */
        }

        .editmodel {
            width: 100%;
            margin-left: 0%;
        }
    }
</style>
<h4 style="color: black">Add Upcoming Festivals</h4>
<div class="card">

    <button class="employee"><i class="fa fa-plus" aria-hidden="true"></i></button>
    <div class="table-responsive text-nowrap">


        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
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
                        <td>{{ $loop->index + 1 }}</td>
                        <td> <img src="{{asset('festival_image/' . $item->festival_image)}}" alt="" style="width:8%"></td>
                        <td>{{$item->fetival_name}}</td>
                        <td>{{ \Carbon\Carbon::parse($item->festival_date)->format('d-m-Y') }}</td>
                        <td>{{$item->notes}}</td>
                        <td><a class="edit" href="#" data-id='{{$item->id}}' data-festival_image='{{$item->festival_image}}'
                                data-fetival_name='{{$item->fetival_name}}' data-festival_date='{{$item->festival_date}}'
                                data-notes='{{$item->notes}}'>
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
                <h5 class="modal-title" id="myModalLabel">Add Festival</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.festival_store')}}" method="post" id="myForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-3">
                        <strong>Festival <span class="text-danger">*</span></strong>
                        <input type="text" class="form-control" placeholder="Enter Festival name" name="fetival_name" />

                    </div>
                    <div class="row mt-3">
                        <strong>Date<span class="text-danger">*</span></strong>
                        <input type="date" class="form-control" name="festival_date" />

                    </div>
                    <div class="row mt-3">
                        <strong>Festival Image</strong>
                        <input type="file" class="form-control" name="festival_image" />

                    </div>
                    <div class="row mt-3">
                        <strong>Notes</strong>
                        <input type="text" class="form-control" placeholder="Enter Notes" name="notes" />

                    </div>

                    <div class="mt-3">
                        <button type="submit" class="text-white p-2 border-0 rounded px-3 fw-bold send_inquiry_btn"
                            style="background-color: #16ae71;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Festival Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dfe8eb">
                <h5 class="modal-title" id="myModalLabel">Edit Festival</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.festival_edit')}}" method="post" id="editForm"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id">

                    <!-- Festival Name -->
                    <div class="row mt-3">
                        <strong>Festival <span class="text-danger">*</span></strong>
                        <input type="text" class="form-control" placeholder="Enter Festival name" name="fetival_name"
                            id="fetival_name" />
                    </div>

                    <!-- Festival Date -->
                    <div class="row mt-3">
                        <strong>Date<span class="text-danger">*</span></strong>
                        <input type="date" class="form-control" name="festival_date" id="festival_date" />
                    </div>

                    <!-- Festival Image -->
                    <div class="row mt-3">
                        <strong>Festival Image</strong>
                        <div>
                            <!-- Display existing image (if available) -->
                            <img id="current-image" style="max-width: 200px; margin-bottom: 10px; display: none;" />
                        </div>
                        <input type="file" class="form-control" name="festival_image" id="festival_image" />
                    </div>

                    <!-- Notes -->
                    <div class="row mt-3">
                        <strong>Notes</strong>
                        <input type="text" class="form-control" placeholder="Enter Notes" name="notes" id="notes" />
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="text-white p-2 border-0 rounded px-3 fw-bold send_inquiry_btn"
                            style="background-color: #16ae71;">Submit</button>
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
                <h5 class="modal-title" id="myModalLabel">Delete Holiday</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="text-center" style="margin-right: 8%;">Are you sure you want to delete Holiday?</h5>
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


{{-- datable java script --}}
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

<script>
    $(document).on('click', '.employee', function (event) {
        event.preventDefault();
        $('#enterdepartmentmodal').modal('show');
    });
    $(document).ready(function () {

        $.validator.addMethod("festival_image_val", function (value, element) {
            // Check if a file is selected
            if (element.files && element.files.length > 0) {
                let allowedTypes = /(\.jpg|\.jpeg|\.png|\.svg|\.gif|\.jfif|\.webp)$/i;
                return allowedTypes.test(element.files[0].name);
            }
            return true; // If no file is selected, validation passes
        }, "Only image files (jpg, jpeg, png, svg, gif, jfif, webp) are allowed.");

        $('#myForm').validate({
            // initialize the plugin
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
            }
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize DataTable
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'pdfHtml5',
            ]
        });

        // When 'Edit' button is clicked
        $(document).on('click', '.edit', function (event) {
            event.preventDefault();

            var id = $(this).data('id');
            var festival_image = $(this).data('festival_image');
            var festival_name = $(this).data('fetival_name');
            var festival_date = $(this).data('festival_date');
            var notes = $(this).data('notes');

            // Show the edit modal
            $('#editmodal').modal('show');

            // Populate modal fields with data
            $('#id').val(id);
            $('#fetival_name').val(festival_name);
            $('#festival_date').val(festival_date);
            $('#notes').val(notes);

            // Handle the image display
            if (festival_image) {
                // If there is an image, show it in the modal
                $('#current-image').show(); // Show the existing image
                $('#current-image').attr('src', '{{ asset('festival_image/') }}' + '/' + festival_image); // Generate the correct image URL
            } else {
                // Hide the image if no image exists
                $('#current-image').hide();
            }
        });

        // Handle the form submission for the edit
        $.validator.addMethod("festival_image_val", function (value, element) {
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
            submitHandler: function (form) {
                var formData = new FormData(form); // Get form data including files
                var url = $(form).attr('action'); // Get form action URL

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $('#editmodal').modal('hide');
                        location.reload(); // Reload the page after successful submission
                    },
                    error: function (response) {
                        // Handle any error if needed
                        alert('An error occurred. Please try again.');
                    }
                });
            }
        });

        // Delete button handler
        $(document).on('click', '.delete', function (event) {
            event.preventDefault();
            var id = $(this).data('id');
            $('#deletemodal').modal('show');
            $('#deletemember').val(id);
        });

        $('#deletemember').click(function () {
            var id = $(this).val();
            $.post("{{ URL::to('admin/holidat_delete') }}", { id: id }, function () {
                $('#deletemodal').modal('hide');
                location.reload();
            });
        });
    });
</script>
@endsection