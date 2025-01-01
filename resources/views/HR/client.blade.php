@extends('HR.hr_layout.sidebar')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    <style>
        .note-editable.card-block {
            min-height: 173.266px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            color: #ffff !important;
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

        .select2-container--default .select2-selection--single {
            height: 48px !important;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding: 8px 3px 9px 20px !important;
            color: #c1bddb;
        }

         body.dark-mode .select2-container .select2-selection--single .select2-selection__rendered {
            padding: 8px 3px 9px 20px !important;
            color: #c1bddb;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 9px !important;
        }

        input#edit_phone {
            padding-left: 8px;
        }

        input#phone {
            padding-left: 8px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            color: #fff !important;
        }

        a#example1_previous {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
            border-radius: 5% !important;
            margin-right: 5px !important;
            color: white !important;
        }

        a#example1_next {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
            border-radius: 5% !important;
            margin-left: 5px !important;
            color: white !important;
        }

        table.dataTable.no-footer {
            border-bottom: 1px solid rgb(0 0 0 / 12%) !important;

        }

        body.dark-mode span.select2-selection.select2-selection--single {
            background: #312d4b;
            border-color: #595572;
        }

        body.dark-mode span#select2-country_code-container {
            color: #d5d1ef;
        }

        body.dark-mode span.select2-dropdown.select2-dropdown--below {
            background: #312d4b;
            color: #d5d1ef;
        }

        body.dark-mode input.select2-search__field {
            background: #312d4b;
        }
        .select2-container--default .select2-results__option--selected {
            background-color: #8c57ff;
        }
       

        
     
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Client List</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons btn-group flex-wrap">
                                <button class="btn create-new  waves-effect waves-light employee"
                                    style=" background: #7e4ee6;color: #f0f8ff;" tabindex="0"
                                    aria-controls="DataTables_Table_0" type="button"><span><i class="ri-add-line"></i>
                                        <span class="d-none d-sm-inline-block">Add New
                                            Client</span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <table class="datatables-basic table table-bordered dataTable no-footer dtr-column" id="example1"
                        aria-describedby="DataTables_Table_0_info" style="width: 1395px;">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Name</th>
                                <th>Currency</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Company Name</th>
                                {{-- <th>Project Name</th>
                                <th>Total Earning</th>
                                <th>Earning Date</th> --}}
                                <th>Client Payment Details</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td> {{ $loop->index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->currency }}</td>
                                    <td style="white-space: nowrap;">{{ $item->phone }}</td>
                                    <td>
                                        <span class="address-display">
                                            <!-- Initially show the first 20 characters of address -->
                                            <span class="address-short">{{ \Str::limit($item->address, 20) }}</span>

                                            <!-- Show "Show More" link if address is longer than 20 characters -->
                                            @if (strlen($item->address) > 20)
                                                <span class="address-more">
                                                    <a href="javascript:void(0)" class="show-more">Show More</a>
                                                </span>
                                            @endif

                                            <!-- Full address that will be shown when "Show More" is clicked -->
                                            <span class="address-full" style="display: none;">{{ $item->address }}</span>

                                            <!-- Show Less link -->
                                            <span class="show-less" style="display: none;">
                                                <a href="javascript:void(0)" class="show-less">Show Less</a>
                                            </span>
                                        </span>
                                    </td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->company_name }}</td>
                                    {{-- <td>{{ $item->project_name }}</td>
                                    <td>{{ $item->total_earning }}</td>
                                    <td>{{ $item->earning_date }}</td> --}}
                                    <td style="text-align: center;"><span
                                            style="display: none;">{!! $item->client_payment_details !!}</span>
                                        <a class="payment" data-id="{{ $item->id }}"
                                            data-client_payment_details='{{ $item->client_payment_details }}'>
                                            <i class="ri-wallet-line ri-18px"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="edit" href="#" data-id='{{ $item->id }}'
                                            data-name='{{ $item->name }}' data-currency="{{ $item->currency }}"
                                            data-phone="{{ $item->phone }}" data-address="{{ $item->address }}"
                                            data-email='{{ $item->email }}' data-company_name='{{ $item->company_name }}'
                                            data-project_name='{{ $item->project_name }}'
                                            data-client_payment_details='{{ $item->client_payment_details }}'
                                            data-total_earning='{{ $item->total_earning }}'
                                            data-earning_date='{{ $item->earning_date }}'>
                                            <i class="ri-edit-box-line ri-22px list-btn"></i>
                                        </a>

                                        <a href="#" class="delete" data-id='{{ $item->id }}'>
                                            <i class="ri-delete-bin-7-line ri-22px list-btn"></i>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- Add Modal -->

        <div class="offcanvas offcanvas-end" id="add-new-record" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">New Client</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="{{ route('admin.Client_store') }}" method="post" id="password"
                    enctype="multipart/form-data"
                    class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    @csrf
                    <!-- Name -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-user-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control dt-full-name" name="name"
                                    placeholder="Enter department name" aria-label="Enter name"
                                    aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Name</label>
                            </div>
                        </div>
                    </div>
                    <!-- Currency -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-money-dollar-circle-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                            
                                    <select class="form-control select2" name="currency" required>
                                    @foreach ($currencies as $currenci)
                                        <option value="{{ $currenci->code }}" {{ $currenci->code == 'INR' ? 'selected' : '' }}>
                                            {{ $currenci->code }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- <label for="basicFullname" style="margin-left: 7px;">Currency</label> --}}
                            </div>
                        </div>
                    </div>
                    <!-- Phone -->
                    {{-- <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-phone-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="tel" class="form-control dt-full-name" 
                                    placeholder="Enter Number" 
                                    name="phone" 
                                    id="phone"
                                    minlength="10" 
                                    maxlength="15"  
                                    required>
                                <label for="phone">Phone</label>
                            </div>

                            <!-- Set width for phone number input -->
                            <input type="text" class="form-control" id="phone" name="phone"
                                oninput="this.value = this.value.replace(/\D+/g, '')" placeholder="Enter Mobile Number"
                                style="width: 70%;">
                        </div>
                    </div> --}}
                    <div class="form-group mt-3">
                        <div class="input-group">
                            <div class="form-floating form-floating-outline" style="width: 20%;">
                                <select class="form-control select2" id="country_code" name="country_code">
                                    @foreach ($countrys as $value)
                                        <option value="{{ $value->code }}" {{ $value->code == '91' ? 'selected' : '' }}>
                                            {{ $value->code }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- <label for="mobile_code">Country Code</label> --}}
                            </div>

                            <!-- Set width for phone number input -->
                            <input type="text" class="form-control" id="phone" name="phone"
                                oninput="this.value = this.value.replace(/\D+/g, '')" placeholder="Enter Mobile Number"
                                style="width: 70%;">
                        </div>
                    </div>
                    <!-- Address -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-map-pin-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control dt-full-name" name="address"
                                    placeholder="Enter address" aria-label="Enter Address"
                                    aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Address</label>
                            </div>
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-mail-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="email" class="form-control dt-full-name" name="email"
                                    placeholder="Enter email" aria-label="Enter Email" aria-describedby="basicFullname2"
                                    required>
                                <label for="basicFullname">Email</label>
                            </div>
                        </div>
                    </div>
                    <!-- Company Name -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-building-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control dt-full-name" name="company_name"
                                    placeholder="Enter company name" aria-label="Enter Company Name"
                                    aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Company Name</label>
                            </div>
                        </div>
                    </div>
                    {{-- <!-- Project Name -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-projector-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control dt-full-name" name="project_name"
                                    placeholder="Enter project name" aria-label="Enter Project Name"
                                    aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Project Name</label>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Client Payment Details -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            {{-- <span id="basicFullname2" class="input-group-text"><i class="ri-bank-card-line ri-18px"></i></span> --}}
                            <div class="form-floating form-floating-outline">
                                <textarea class="form-control summernote" name="client_payment_details" placeholder="Enter client payment details"
                                    aria-label="Enter Client Payment Details" required></textarea>
                                {{-- <label for="basicFullname">Client Payment Details</label> --}}
                            </div>
                        </div>
                    </div>
                    {{-- <!-- Total Earning -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-wallet-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control dt-full-name" name="total_earning"
                                    placeholder="Enter total earning" aria-label="Enter Total Earning"
                                    aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Total Earning</label>
                            </div>
                        </div>
                    </div>
                    <!-- Earning Date -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-calendar-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="date" class="form-control dt-full-name dob-picker" name="earning_date"
                                    placeholder="Enter earning date" aria-label="Enter Earning Date"
                                    aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Earning Date</label>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Buttons -->
                    <div class="col-sm-12">
                        <button type="submit" class="btn data-submit me-sm-4 me-1 waves-effect waves-light"
                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit Modal -->

        <div class="offcanvas offcanvas-end" id="edit-new-record" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">Edit Client</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form action="{{ route('admin.Client_update') }}" method="post" id="password"
                    enctype="multipart/form-data"
                    class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    @csrf
                    <!-- Name -->
                    <input type="hidden" id="id" name="id">
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-user-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control dt-full-name" name="edit_name" id="edit_name"
                                    placeholder="Enter department name" aria-label="Enter name"
                                    aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Name</label>
                            </div>
                        </div>
                    </div>
                    <!-- Currency -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-money-dollar-circle-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select class="form-control select2" name="edit_currency" id="edit_currency" required>
                                    @foreach ($currencies as $currenci)
                                        <option value="{{ $currenci->code }}">
                                            {{ $currenci->code }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- <label for="basicFullname">Currency</label> --}}
                            </div>
                        </div>
                    </div>
                    <!-- Phone -->
                    {{-- <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-phone-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control dt-full-name" 
                                    placeholder="Enter Number" 
                                    name="edit_phone" 
                                    id="edit_phone"  
                                    minlength="10" 
                                    maxlength="10"  
                                    required>
                                <label for="edit_phone">Phone</label>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-sm-12 fv-plugins-icon-container ">
                        <div class="input-group input-group-merge">
                    
                            <div class="form-floating form-floating-outline d-flex">
                                <select class="form-control select2" id="edit_country_code" name="edit_country_code" style="width: auto;">
                                @foreach ($countrys as $value)
                                    <option value="{{ $value->code }}">
                                        {{ $value->code }}
                                    </option>
                                @endforeach
                                </select>
                                <div class="form-floating form-floating-outline " style="    width: 83%;">
                                <input type="number" class="form-control dt-full-name" placeholder="Enter Number"  name="edit_phone" id="edit_phone" required>
                                <label for="edit_phone">Phone</label>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="form-group mt-3">
                        <div class="input-group">
                            <div class="form-floating form-floating-outline" style="width: 20%;">
                                <!-- Set width for country code dropdown -->
                                <select class="form-control select2" id="edit_country_code" name="edit_country_code">
                                    @foreach ($countrys as $value)
                                        <option value="{{ $value->code }}" {{ $value->code == '91' ? 'selected' : '' }}>
                                            {{ $value->code }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- <label for="mobile_code">Country Code</label> --}}
                            </div>

                            <!-- Set width for phone number input -->
                            <input type="text" class="form-control" id="edit_phone"
                                oninput="this.value = this.value.replace(/\D+/g, '')" name="edit_phone"
                                placeholder="Enter Mobile Number" style="width: 70%;">
                        </div>
                    </div>
                    <!-- Address -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-map-pin-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control dt-full-name" name="edit_address"
                                    id="edit_address" placeholder="Enter address" aria-label="Enter Address"
                                    aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Address</label>
                            </div>
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-mail-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="email" class="form-control dt-full-name" name="edit_email"
                                    id="edit_email" placeholder="Enter email" aria-label="Enter Email"
                                    aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Email</label>
                            </div>
                        </div>
                    </div>
                    <!-- Company Name -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-building-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control dt-full-name" name="edit_company_name"
                                    id="edit_company_name" placeholder="Enter company name"
                                    aria-label="Enter Company Name" aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Company Name</label>
                            </div>
                        </div>
                    </div>
                    {{-- <!-- Project Name -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-projector-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control dt-full-name" name="edit_project_name"
                                    id="edit_project_name" placeholder="Enter project name"
                                    aria-label="Enter Project Name" aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Project Name</label>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Client Payment Details -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            {{-- <span id="basicFullname2" class="input-group-text"><i class="ri-bank-card-line ri-18px"></i></span> --}}
                            <div class="form-floating form-floating-outline">
                                <textarea class="form-control summernote" name="edit_client_payment_details" id="edit_client_payment_details"
                                    placeholder="Enter client payment details" aria-label="Enter Client Payment Details" required></textarea>
                                {{-- <label for="basicFullname">Client Payment Details</label> --}}
                            </div>
                        </div>
                    </div>
                    {{-- <!-- Total Earning -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-wallet-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control dt-full-name" name="edit_total_earning"
                                    id="edit_total_earning" placeholder="Enter total earning"
                                    aria-label="Enter Total Earning" aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Total Earning</label>
                            </div>
                        </div>
                    </div>
                    <!-- Earning Date -->
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i
                                    class="ri-calendar-line ri-18px"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="date" class="form-control dt-full-name dob-picker"
                                    name="edit_earning_date" id="edit_earning_date" placeholder="Enter earning date"
                                    aria-label="Enter Earning Date" aria-describedby="basicFullname2" required>
                                <label for="basicFullname">Earning Date</label>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Buttons -->
                    <div class="col-sm-12">
                        <button type="submit" class="btn data-submit me-sm-4 me-1 waves-effect waves-light"
                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>


        {{-- paymenr data show  --}}
        <div class="modal fade" id="paymentmodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Client Payment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="password" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id" name="id">
                            <div class="row mt-3">
                                <div id="client_payment_details"></div>

                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Delete Confirmation Modal (Offcanvas) -->
        <div class="offcanvas offcanvas-end" id="delete-new-record" aria-modal="true" role="dialog">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="deleteExampleModalLabel">Delete Client</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <h5 class="text-center">Are you sure you want to delete this Client?</h5>
                <form action="{{ route('admin.Client_delete') }}" method="POST" id="delete-form">
                    @csrf
                    <input type="hidden" name="id" id="delete-id"> <!-- Hidden field to store the department ID -->
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-danger waves-effect waves-light"
                            style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important">Delete</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('.summernote').summernote();

        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.employee', function(event) {
                const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('add-new-record'));
                offcanvasEdit.show();
            });

            $(document).on('click', '.edit', function(event) {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var currency = $(this).data('currency');
                var phone = $(this).data('phone');
                var address = $(this).data('address');
                var email = $(this).data('email');
                var company_name = $(this).data('company_name');
                var project_name = $(this).data('project_name');
                var client_payment_details = $(this).data('client_payment_details');
                var total_earning = $(this).data('total_earning');
                var earning_date = $(this).data('earning_date');

                var phoneParts = phone.split(' '); // Split by space
                var countryCode = phoneParts[0]; // Get country code (e.g., "91")
                var phoneNumber = phoneParts[1];
                $('#id').val(id);
                $('#edit_name').val(name);
                $('#edit_currency').val(currency).trigger('change');
                $('#edit_country_code').val(countryCode).trigger('change');
                $('#edit_phone').val(phoneNumber);
                $('#edit_address').val(address);
                $('#edit_email').val(email);
                $('#edit_company_name').val(company_name);
                $('#edit_project_name').val(project_name);
                $('#edit_total_earning').val(total_earning);
                $('#edit_earning_date').val(earning_date);
                $('#edit_client_payment_details').summernote('code', client_payment_details || '');
                const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('edit-new-record'));
                offcanvasEdit.show();
            });

            $(document).on('click', '.delete', function(event) {
                var id = $(this).data('id');
                $('#delete-id').val(id);
                const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('delete-new-record'));
                offcanvasEdit.show();
            });

            $(document).on('click', '.payment', function(event) {
                var id = $(this).data('id');
                var client_payment_details = $(this).data('client_payment_details');
                $('#client_payment_details').html(client_payment_details);
                $('#paymentmodal').modal('show')
            })


            $('#country_code').select2({
                allowClear: false // Optional: Allows the user to clear the selection
            });
            $('#edit_country_code').select2({
                allowClear: false // Optional: Allows the user to clear the selection
            });


        });
    </script>


    <script>
        $(document).ready(function() {
            var table = $('#example1').DataTable({
                "processing": true,
                "serverside": true,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<span>Excel</span>', // Custom text and color
                        className: 'btn-excel', // Add a custom class for additional styling
                        exportOptions: {
                            columns: ':not(:last-child)', // Exclude the last column
                            format: {
                                body: function(data, row, column, node) {
                                    // Remove hidden span or <a> tag content
                                    return $(node).find('span').text() || $(node).text();
                                }
                            }
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<span>PDF</span>', // Custom text and color
                        className: 'btn-pdf', // Add a custom class for additional styling
                        orientation: 'landscape',
                        pageSize: 'A4', // Set orientation to landscape
                        exportOptions: {
                            columns: ':not(:last-child)', // Exclude the last column
                            format: {
                                body: function(data, row, column, node) {
                                    // Remove hidden span or <a> tag content
                                    return $(node).find('span').text() || $(node).text();
                                }
                            }
                        },
                        customize: function(doc) {
                            // Customize the PDF with table lines
                            doc.styles.tableHeader = {
                                bold: true,
                                fontSize: 14,
                                color: 'black',
                                fillColor: '#d9edf7', // Light blue header
                                alignment: 'center'
                            };
                            doc.defaultStyle.fontSize = 10; // Set default font size

                            // Add borders to table cells
                            var objLayout = {};
                            objLayout['hLineWidth'] = function(i) {
                                return 0.5;
                            }; // Horizontal line width
                            objLayout['vLineWidth'] = function(i) {
                                return 0.5;
                            }; // Vertical line width
                            objLayout['hLineColor'] = function(i) {
                                return '#000000';
                            }; // Horizontal line color
                            objLayout['vLineColor'] = function(i) {
                                return '#000000';
                            }; // Vertical line color
                            objLayout['paddingLeft'] = function(i) {
                                return 8;
                            }; // Padding left
                            objLayout['paddingRight'] = function(i) {
                                return 8;
                            }; // Padding right
                            objLayout['paddingTop'] = function(i) {
                                return 6;
                            }; // Padding top
                            objLayout['paddingBottom'] = function(i) {
                                return 6;
                            }; // Padding bottom
                            doc.content[1].layout =
                                objLayout; // Apply layout to the table (content[1] is the table)
                        }
                    },
                ]
            });
        });
    </script>

    <script>
        // jQuery to toggle between Show More and Show Less for the address
        $(document).ready(function() {
            $('.show-more').click(function() {
                var parent = $(this).closest('.address-display');
                parent.find('.address-short').hide(); // Hide the short text
                parent.find('.address-more').hide(); // Hide the "Show More" link
                parent.find('.address-full').show(); // Show the full address
                parent.find('.show-less').show(); // Show the "Show Less" link
            });

            $('.show-less').click(function() {
                var parent = $(this).closest('.address-display');
                parent.find('.address-short').show(); // Show the short text
                parent.find('.address-more').show(); // Show the "Show More" link
                parent.find('.address-full').hide(); // Hide the full address
                parent.find('.show-less').hide(); // Hide the "Show Less" link
            });
        });
    </script>
@endsection
