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

        a#example2_previous {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
            border-radius: 5% !important;
            margin-right: 5px !important;
            color: white !important;
        }

        a#example2_next {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
            border-radius: 5% !important;
            margin-left: 5px !important;
            color: white !important;
        }

        body.dark-mode select.expense_desc {
            background: #312d4b;
        }

        table.dataTable.no-footer {
            border-bottom: 0px solid #e6e5e8;
        }

        body.dark-mode table.dataTable.no-footer {
            border-bottom: 0px solid #474360;
        }

        body.dark-mode select {
            background: #312d4b !important;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="GET" action="{{ route('hr.company_progress') }}">
            <div class="row">
                <div class="col-md-3">
                    <label for="month">Select Month</label>
                    <select name="month" id="month" class="form-control">
                        @foreach (range(1, 12) as $month)
                            <option value="{{ $month }}"
                                {{ request('month', Carbon\Carbon::now()->month) == $month ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="year">Select Year</label>
                    <select name="year" id="year" class="form-control">
                        @foreach (range(2020, Carbon\Carbon::now()->year) as $year)
                            <option value="{{ $year }}"
                                {{ request('year', Carbon\Carbon::now()->year) == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn mt-5"
                        style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;">Submit</button>
                    <button type="submit" class="btn  mt-5 refresh-btn"
                        style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;"><i
                            class="ri-refresh-line ri-22px text-white"></i></button>
                </div>
            </div>
        </form>
        <br>
        <div class="row">


            <!-- First Card -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-datatable table-responsive pt-0">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="card-header">
                                <h5 class="card-title mb-0 text-center">Income</h5>
                                <h5 class="card-title mb-0 text-center">₹{{ $total_income }}</h5>
                            </div>
                            <hr class="my-0">
                            <table class="datatables-basic table table-bordered dataTable no-footer dtr-column"
                                id="example1" aria-describedby="DataTables_Table_0_info"
                                style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($income_data as $item)
                                        <tr data-id="{{ $item->id }}">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td class="editable" data-field="date" contenteditable="true">
                                                {{ $item->date }}</td>
                                            <td class="editable" data-field="amount" contenteditable="true">
                                                {{ $item->amount }}</td>
                                            <td class="editable" data-field="desc" contenteditable="true">
                                                {{ $item->desc}}</td>
                                            <td> <a href="#" class="delete" data-id='{{ $item->id }}'>
                                                    <i class="ri-delete-bin-7-line ri-22px list-btn"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type="date" class="form-control " id="income_date">
                                    </td>
                                    <td>
                                        <input type="tel" class="form-control" id="income_amount" placeholder="Amount"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    </td>
                                    <td>
                                        <select class="form-control expense_desc" id="income_desc">
                                            <option>Selecte Option</option>
                                            @foreach ($income_description as $income)
                                                <option value="{{$income->name}}">{{ $income->name }}</option>
                                            @endforeach
                                            <option value="add_new_tag">Start typing...
                                        </select>
                                        <input type="text" id="start_typing" class="form-control" style="display: none;"
                                            placeholder="Enter new Description">
                                            
                                        <input type="hidden" value="1" id="income_type">
                                        <input type="hidden" value="1" id="income_progress_type">
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Card -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-datatable table-responsive pt-0">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="card-header">
                                <h5 class="card-title mb-0 text-center">Expense</h5>
                                <h5 class="card-title mb-0 text-center">₹{{ $total_expense }}</h5>
                            </div>
                            <hr class="my-0">
                            <table class="datatables-basic table table-bordered dataTable no-footer dtr-column"
                                id="example2" aria-describedby="DataTables_Table_0_info"
                                style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expense_data as $item1)
                                        <tr data-id="{{ $item1->id }}">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td class="editable_2" data-field="date">{{ $item1->date }}</td>
                                            <td class="editable_2" data-field="amount">{{ $item1->amount }}</td>
                                            <td class="editable_2" data-field="desc">{{ $item1->desc }}</td>
                                            <td> <a href="#" class="delete" data-id='{{ $item1->id }}'>
                                                    <i class="ri-delete-bin-7-line ri-22px list-btn"></i>
                                                </a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tr>
                                    <td></td>
                                    <td><input type="date" class="form-control" id="expense_date"></td>
                                    <td><input type="tel" class="form-control" id="expense_amount"
                                            placeholder="Amount"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    </td>
                                  
                                      <td>
                                        <select class="form-control expense_desc" id="expense_desc">
                                            <option>Selecte Option</option>
                                            @foreach ($expense_description as $expense)
                                                <option value="{{$expense->name}}">{{ $expense->name }}</option>
                                            @endforeach
                                            <option value="add_new_tag_2">Start typing...
                                        </select>
                                        <input type="text" id="start_typing_2" class="form-control" style="display: none;"
                                            placeholder="Enter new Description">
                                        <input type="hidden" value="2" id="expense_type">
                                        <input type="hidden" value="2" id="expense_progress_type">
                                    </td>

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

            $(document).ready(function() {
                $('.editable').on('click', function() {
                    const cell = $(this);
                    const field = cell.data('field');

                    if (field === 'date') {
                        // Check if the input is already present
                        if (!cell.find('input').length) {
                            const currentDate = cell.text().trim();
                            const input = $('<input>', {
                                type: 'date',
                                class: 'form-control',
                                value: currentDate
                            });

                            cell.html(input);
                            input.focus(); // Focus the input field

                            // Handle when date input loses focus
                            input.on('blur', function() {
                                const newDate = input.val().trim();
                                cell.html(newDate); // Replace input with new value

                                // Send the updated value to the server
                                updateCell(cell, newDate);
                            });
                        }
                    } else if (field === 'desc') {
                        // Check if the select is already present
                        if (!cell.find('select').length) {
                            const currentValue = cell.text().trim();

                            // Create a dropdown
                            const select = $('<select>', {
                                class: 'form-control expense_desc'
                            });

                            // Add options dynamically
                            select.append('<option value="" >Select Option</option>');
                            @foreach ($income_description as $value)
                                select.append(
                                    '<option value="{{ $value->name }}">{{ $value->name }}</option>'
                                );
                            @endforeach

                            // Set the current value as selected
                            select.val(currentValue);

                            // Replace the cell's content with the select element
                            cell.html(select);
                            select.focus(); // Focus the select element

                            // Handle when the dropdown loses focus
                            select.on('blur', function() {
                                const newValue = select.val().trim();
                                cell.html(newValue); // Replace select with selected value

                                // Send the updated value to the server
                                updateCell(cell, newValue);
                            });

                            // Handle when a new option is selected
                            select.on('change', function() {
                                select.blur(); // Trigger blur to save the value
                            });
                        }
                    } else if (field === 'amount') {
                        // Check if the input is already present
                        if (!cell.find('input').length) {
                            const currentAmount = cell.text().trim();
                            const input = $('<input>', {
                                type: 'tel',
                                class: 'form-control',
                                value: currentAmount
                            });

                            cell.html(input);
                            input.focus(); // Focus the input field

                            // Restrict input to numeric values
                            input.on('input', function() {
                                this.value = this.value.replace(/[^0-9.]/g, '').replace(
                                    /(\..*)\./g, '$1');
                            });

                            // Handle when the input loses focus
                            input.on('blur', function() {
                                const newAmount = input.val().trim();
                                cell.html(newAmount); // Replace input with new value

                                // Send the updated value to the server
                                updateCell(cell, newAmount);
                            });
                        }
                    }
                });

                // Handle blur for non-date fields
                $('.editable').on('blur', function() {
                    const cell = $(this);
                    const field = cell.data('field');

                    if (field !== 'date') {
                        const value = cell.text().trim();
                        updateCell(cell, value);
                    }
                });
                $('.editable_2').on('click', function() {
                    const cell = $(this);
                    const field = cell.data('field');

                    if (field === 'date') {
                        // Check if the input is already present
                        if (!cell.find('input').length) {
                            const currentDate = cell.text().trim();
                            const input = $('<input>', {
                                type: 'date',
                                class: 'form-control',
                                value: currentDate
                            });

                            cell.html(input);
                            input.focus(); // Focus the input field

                            // Handle when date input loses focus
                            input.on('blur', function() {
                                const newDate = input.val().trim();
                                cell.html(newDate); // Replace input with new value

                                // Send the updated value to the server
                                updateCell(cell, newDate);
                            });
                        }
                    } else if (field === 'desc') {
                        // Check if the select is already present
                        if (!cell.find('select').length) {
                            const currentValue = cell.text().trim();

                            // Create a dropdown
                            const select = $('<select>', {
                                class: 'form-control expense_desc'
                            });

                            // Add options dynamically
                            select.append('<option value="" >Select Option</option>');
                            @foreach ($expense_description as $value)
                                select.append(
                                    '<option value="{{ $value->name }}">{{ $value->name }}</option>'
                                );
                            @endforeach

                            // Set the current value as selected
                            select.val(currentValue);

                            // Replace the cell's content with the select element
                            cell.html(select);
                            select.focus(); // Focus the select element

                            // Handle when the dropdown loses focus
                            select.on('blur', function() {
                                const newValue = select.val().trim();
                                cell.html(newValue); // Replace select with selected value

                                // Send the updated value to the server
                                updateCell(cell, newValue);
                            });

                            // Handle when a new option is selected
                            select.on('change', function() {
                                select.blur(); // Trigger blur to save the value
                            });
                        }
                    } else if (field === 'amount') {
                        // Check if the input is already present
                        if (!cell.find('input').length) {
                            const currentAmount = cell.text().trim();
                            const input = $('<input>', {
                                type: 'tel',
                                class: 'form-control',
                                value: currentAmount
                            });

                            cell.html(input);
                            input.focus(); // Focus the input field

                            // Restrict input to numeric values
                            input.on('input', function() {
                                this.value = this.value.replace(/[^0-9.]/g, '').replace(
                                    /(\..*)\./g, '$1');
                            });

                            // Handle when the input loses focus
                            input.on('blur', function() {
                                const newAmount = input.val().trim();
                                cell.html(newAmount); // Replace input with new value

                                // Send the updated value to the server
                                updateCell(cell, newAmount);
                            });
                        }
                    }
                });

                // Handle blur for non-date fields
                $('.editable_2').on('blur', function() {
                    const cell = $(this);
                    const field = cell.data('field');

                    if (field !== 'date') {
                        const value = cell.text().trim();
                        updateCell(cell, value);
                    }
                });

                function updateCell(cell, value) {
                    const id = cell.closest('tr').data('id');
                    const field = cell.data('field');

                    $.ajax({
                        url: '/admin/editIncomeData', // Your route for updating income
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // Include CSRF token
                            id: id,
                            field: field,
                            value: value
                        },
                        success: function(response) {
                            console.log('Record updated successfully!');
                        },
                        error: function() {
                            alert('An error occurred while updating.');
                        }
                    });
                }
            });

    </script>
    
    <script>
        function storeExpenseData() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            event.preventDefault();

            var date = $('#expense_date').val();
            var amount = $('#expense_amount').val();
            var desc = $('#expense_desc').val();
            console.log(date, amount)
            var progress_type = $('#expense_progress_type').val();



            // AJAX Call
            $.ajax({
                url: "{{ url('/admin/saveExpense') }}",
                method: "POST",
                data: {
                    date: date,
                    amount: amount,
                    desc: desc,
                    progress_type: progress_type
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    console.log(response);
                    location.reload();
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }

        function storeExpenseData1() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            event.preventDefault();

            var date = $('#income_date').val();
            var amount = $('#income_amount').val();
            var desc = $('#income_desc').val();
            console.log(date, amount)
            var progress_type = $('#income_progress_type').val();



            // AJAX Call
            $.ajax({
                url: "{{ url('/admin/saveExpense') }}",
                method: "POST",
                data: {
                    date: date,
                    amount: amount,
                    desc: desc,
                    progress_type: progress_type
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    console.log(response);
                    location.reload();
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }



        // Handle Enter Key
        $('#expense_date, #expense_amount, #expense_desc, #expense_progress_type').on('keypress', function(event) {
            console.log('gsdfsfui');
            if (event.which === 13) { // 13 is the keycode for enter
                storeExpenseData();
                event.preventDefault(); // Prevent default form submission if inside a form
            }
        });

        $('#income_date, #income_amount, #income_desc, #income_progress_type').on('keypress', function(event) {
            console.log('gsdfsfui');
            if (event.which === 13) { // 13 is the keycode for enter
                storeExpenseData1();
                event.preventDefault(); // Prevent default form submission if inside a form
            }
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
                }, {
                    extend: 'pdfHtml5',
                    text: '<span>PDF</span>', // Custom text and color
                    className: 'btn-pdf', // Add a custom class for additional styling
                }, ]
            });
            var table = $('#example2').DataTable({
                "processing": true,
                "serverside": true,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<span>Excel</span>', // Custom text and color
                    className: 'btn-excel', // Add a custom class for additional styling
                }, {
                    extend: 'pdfHtml5',
                    text: '<span>PDF</span>', // Custom text and color
                    className: 'btn-pdf', // Add a custom class for additional styling
                }, ]
            });
        });
    </script>
    <script>
        document.getElementById('income_desc').addEventListener('change', function() {
            var selectedValue = this.value;

            if (selectedValue === 'add_new_tag') {
                // Hide the select box and show the input box
                this.style.display = 'none';
                document.getElementById('start_typing').style.display = 'block';
                document.getElementById('start_typing').focus();
            }
        });
    </script>
    <script>
        document.getElementById('expense_desc').addEventListener('change', function() {
            var selectedValue = this.value;

            if (selectedValue === 'add_new_tag_2') {
                // Hide the select box and show the input box
                this.style.display = 'none';
                document.getElementById('start_typing_2').style.display = 'block';
                document.getElementById('start_typing_2').focus();
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#start_typing').on('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Prevent form submission on Enter key

                    var newDescription = $(this).val().trim();
                    var type = $('#income_type').val();
                    if (newDescription) {
                        // AJAX request to save the new description
                        $.ajax({
                            url: "{{ url('/admin/saveDescription') }}", // Laravel route URL
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    'content') // CSRF token for security
                            },
                            data: {
                                name: newDescription,
                                type : type
                            },
                            success: function(data) {
                                if (data.success) {
                                    // Add the new option to the dropdown
                                    location.reload();
                                    var dropdown = $('#income_desc');
                                    var newOption = new Option(newDescription, data.id, true,
                                        true); // Set as selected
                                    dropdown.append(newOption);

                                    // Reset the input box and show the dropdown
                                    $('#start_typing').hide();
                                    dropdown.show();
                                    dropdown.val(data.id); // Set the new option as selected
                                } else {
                                    alert("Failed to save description. Try again.");
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Error:", xhr.responseText);
                            }
                        });
                    } else {
                        alert("Please enter a description.");
                    }
                }
            });
            $('#start_typing_2').on('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Prevent form submission on Enter key

                    var newDescription = $(this).val().trim();
                    var type = $('#expense_type').val();
                    if (newDescription) {
                        // AJAX request to save the new description
                        $.ajax({
                            url: "{{ url('/admin/saveDescription') }}", // Laravel route URL
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    'content') // CSRF token for security
                            },
                            data: {
                                name: newDescription,
                                type : type
                            },
                            success: function(data) {
                                if (data.success) {
                                    // Add the new option to the dropdown
                                    location.reload();
                                    var dropdown = $('#expense_desc');
                                    var newOption = new Option(newDescription, data.id, true,
                                        true); // Set as selected
                                    dropdown.append(newOption);

                                    // Reset the input box and show the dropdown
                                    $('#start_typing_2').hide();
                                    dropdown.show();
                                    dropdown.val(data.id); // Set the new option as selected
                                } else {
                                    alert("Failed to save description. Try again.");
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Error:", xhr.responseText);
                            }
                        });
                    } else {
                        alert("Please enter a description.");
                    }
                }
            });

            $(document).on('click', '.delete', function(e) {
                e.preventDefault(); // Prevent default anchor behavior
                var $deleteButton = $(this);
                var rowId = $deleteButton.data('id'); // Get the ID from data-id attribute
                var csrfToken = $('meta[name="csrf-token"]').attr('content'); // CSRF token for security

                if (confirm("Are you sure you want to delete this record?")) {
                    $.ajax({
                        url: "{{ url('/admin/deleteIncomeData') }}", // Update to match your route
                        method: "POST",
                        data: {
                            id: rowId,
                            _token: csrfToken
                        },
                        success: function(response) {
                            if (response.success) {
                                // Remove the row from the table
                                $deleteButton.closest('tr').remove();

                            } else {
                                alert("Failed to delete the record. Please try again.");
                            }
                        },
                        error: function() {
                            alert("An error occurred. Please try again.");
                        }
                    });
                }
            });
        });
        $('.refresh-btn').on('click', function(e) {
            e.preventDefault(); // Prevent the form submission (if any)
            window.location.href = "{{ route('hr.company_progress') }}"; // Redirect to the route
        });
    </script>
@endsection
