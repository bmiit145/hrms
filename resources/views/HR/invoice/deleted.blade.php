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
                            <h5 class="card-title mb-0">Deleted Invoice List</h5>
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
                                <th>Currency</th>
                                <th>Invoice To</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deletedInvoices as $key => $invoice)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->date_issued)->format('d-m-Y') ?? '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d-m-Y') ?? '' }}</td>
                                    <td>{{ $invoice->currency->name ?? 'N/A' }}</td>
                                    <td>{{ $invoice->client->name ?? 'N/A' }}</td>
                                    <td>{{ $invoice->total }}</td>
                                    <td>
                                        <form action="{{ route('hr.invoice.restore', $invoice->id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn" style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;"><i class="ri-reset-left-line" style="font-size: 15px;"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
