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
            border-bottom: 0px solid rgb(230 229 232);
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

        .multipleChosen,
        .multipleSelect2 {
            width: 300px;
        }

        li.search-field {
            height: 44px;
            border: none !important;
        }

        li.search-field {
            padding: 10px !important;
            color: #9a96a1 !important;
        }

        ul.chosen-choices {
            padding: 2px !important;
        }

        body.dark-mode a.paginate_button {
            background-color: #403c59 !important;
            border-radius: 50% !important;
        }

        a.paginate_button {
            background-color: #eeeeef !important;
            border-radius: 50% !important;
        }

        body.dark-mode a.paginate_button.current {
            background-color: #8c57ff !important;
        }
    </style>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0">Invoice List</h5>
                    </div>
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <div class="dt-buttons btn-group flex-wrap">
                            <div class="dt-buttons btn-group flex-wrap">
                                <a href="{{ route('admin.invoice.create') }}" class="add_recode"><button
                                        class="btn btn-primary create-new btn-primary waves-effect waves-light employee"
                                        style=" background: #7e4ee6;color: #f0f8ff;" tabindex="0"
                                        aria-controls="DataTables_Table_0" type="button"><span><i
                                                class="ri-add-line"></i> <span class="d-none d-sm-inline-block">Add New
                                                Project</span></span>
                                    </button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-0">
                <table class="datatables-basic table table-bordered dataTable no-footer dtr-column" id="example">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Invoice Number</th>
                            <th>Date Issued</th>
                            <th>Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $key => $invoice)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->date_issued }}</td>
                                <td>{{ $invoice->due_date }}</td>
                                <td>
                                    <a href="{{ route('admin.invoice.restore', $invoice->id) }}" class="restore" data-id="{{ $invoice->id }}">Restore</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>                   
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal (Offcanvas) -->
<div class="offcanvas offcanvas-end" id="delete-new-record" aria-labelledby="myModalLabel" aria-modal="true"
    tabindex="-1" role="dialog">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="myModalLabel">Delete Invoice</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <h5 class="text-center mb-4">Are you sure you want to delete this invoice?</h5>
        <input type="hidden" name="id" id="delete-id"> <!-- Hidden field for the invoice ID -->
        <div class="d-flex justify-content-center gap-3">
            <button type="button" class="btn btn-danger" id="confirm-delete-btn">Delete</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $('.restore').on('click', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: "{{ route('admin.invoice.restore', '') }}/" + id,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                location.reload(); // Reload the page
            },
            error: function (xhr) {
                alert('Error: ' + (xhr.responseJSON.message || 'Unable to restore the record.'));
            }
        });
    });

</script>

@endsection
