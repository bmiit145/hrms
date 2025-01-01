@extends('HR.hr_layout.sidebar')
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
        border-bottom: 0px solid #E6E5E8;
    }

    body.dark-mode table.dataTable.no-footer {
        border-bottom: 0px solid #474360;
    }

    .list-btn {
        color: #8b8693;
    }

    .current {
        color: red !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        color: white !important;
    }


</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0">Department List</h5>
                    </div>
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <div class="dt-buttons btn-group flex-wrap">
                            <button class="btn  create-new  waves-effect waves-light employee" tabindex="0" aria-controls="DataTables_Table_0" type="button" style=" background: #7e4ee6;color: #f0f8ff;"><span><i class="ri-add-line"></i> <span class="d-none d-sm-inline-block">Add New
                                        Department</span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <hr class="my-0">
                <table class="datatables-basic table table-bordered dataTable no-footer dtr-column" id="example" aria-describedby="DataTables_Table_0_info" style="width: 1395px;">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Department Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($department_view as $item)
                        <tr>
                            <td> {{ $loop->index + 1 }}</td>
                            <td>{{$item->department_name}}</td>
                            <td><a class="edit list-btn" href="#" data-id='{{$item->id}}' data-department_name='{{$item->department_name}}'>
                                    <i class="ri-edit-box-line ri-22px"></i>
                                </a>
                                <a href="#" class="delete list-btn" data-id='{{$item->id}}'>
                                    <i class="ri-delete-bin-line ri-22px"></i>
                                </a>

                            </td>
                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script> <!-- Add Modal -->

    <div class="offcanvas offcanvas-end" id="add-new-record" aria-modal="true" role="dialog">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="exampleModalLabel">Add Department</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <form action="{{route('admin.add_department')}}" method="post" id="password" enctype="multipart/form-data" class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                @csrf
                <div class="col-sm-12 fv-plugins-icon-container">
                    <div class="input-group input-group-merge">
                        <span id="basicFullname2" class="input-group-text"><i class="ri-user-line ri-18px"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control dt-full-name" name="department_name" placeholder="Enter department name" aria-label="Enter department name" aria-describedby="basicFullname2" required>
                            <label for="basicFullname">Add Department</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <button type="submit" class="btn data-submit me-sm-4 me-1 waves-effect waves-light" style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;">Submit</button>
                    <button type="reset" class="btn btn-outline-secondary waves-effect" style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </form>

        </div>
    </div>

    <!-- Edit Modal -->

    <div class="offcanvas offcanvas-end" id="edit-new-record" aria-modal="true" role="dialog">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="editExampleModalLabel">Edit Record</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <form action="{{route('admin.edit_department')}}" method="post" id="password" enctype="multipart/form-data" class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                @csrf
                <input type="hidden" id="id" name="id">
                <div class="col-sm-12 fv-plugins-icon-container">
                    <div class="input-group input-group-merge">
                        <span id="basicFullname2" class="input-group-text"><i class="ri-user-line ri-18px"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="texr" class="form-control dt-full-name" placeholder="Enter department name" name="department_name" id="department_name" aria-describedby="basic-default-password2" required />
                            <label for="basicFullname">Add Department</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <button type="submit" class="btn data-submit me-sm-4 me-1 waves-effect waves-light" style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;"> Update</button>
                    <button type="reset" class="btn btn-outline-secondary waves-effect" style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </form>

        </div>
    </div>

    <!-- Delete Confirmation Modal (Offcanvas) -->
    <div class="offcanvas offcanvas-end" id="delete-new-record" aria-modal="true" role="dialog">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="deleteExampleModalLabel">Delete Department</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <h5 class="text-center">Are you sure you want to delete this department?</h5>
            <form action="{{ url('admin.delete_department') }}" method="POST" id="delete-form">
                @csrf
                <input type="hidden" name="id" id="delete-id"> <!-- Hidden field to store the department ID -->
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-danger waves-effect waves-light" style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;">Delete</button>
                    <button type="reset" class="btn btn-outline-secondary waves-effect"  style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script> -->

<script>
    // Wait for the DOM to be ready before executing the script
    document.addEventListener('DOMContentLoaded', function() {
        // Open Add New Record Offcanvas
        const openAddButton = document.querySelector('.create-new');
        const offcanvasAdd = new bootstrap.Offcanvas(document.getElementById('add-new-record'));

        openAddButton.addEventListener('click', function() {
            offcanvasAdd.show();
        });

        // Open Edit Record Offcanvas
        $(document).on('click', '.edit', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            var department_name = $(this).data('department_name');

            // Show the edit offcanvas
            const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('edit-new-record'));
            offcanvasEdit.show();

            // Populate the form fields in the edit offcanvas
            $('#department_name').val(department_name); // Fill department name
            $('#id').val(id); // Fill department id
        });

        // Open Delete Confirmation Offcanvas
        $(document).on('click', '.delete', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            // Set the department ID in the hidden field
            $('#delete-id').val(id);

            // Show the delete offcanvas
            const offcanvasDelete = new bootstrap.Offcanvas(document.getElementById('delete-new-record'));
            offcanvasDelete.show();
        });

        // Handle the delete form submission
        $('#delete-form').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            var id = $('#delete-id').val(); // Get the department ID to delete
            $.ajax({
                url: $(this).attr('action'), // Use the form action URL for deletion
                method: 'POST', // POST method
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    // Hide the delete offcanvas
                    var offcanvasDelete = bootstrap.Offcanvas.getInstance(document.getElementById('delete-new-record'));
                    offcanvasDelete.hide();

                    // Reload the page or update the UI (example: remove the row from the table)
                    location.reload(); // Optionally, you can dynamically remove the row
                }
                , error: function() {
                    alert('There was an error while deleting the department. Please try again.');
                }
            });
        });
    });

</script>
@endsection
