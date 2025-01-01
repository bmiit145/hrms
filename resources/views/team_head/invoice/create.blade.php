@extends('team_head.team_head_layout.sidebar')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}


    <style>
        button.btn.btn-outline-primary.btn-apply-changes.waves-effect {
            color: #8c57ff;
            background: rgba(0, 0, 0, 0);
            border-color: #8c57ff;
        }

        .custom-dropdown {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
        }

        .flag-icon {
            margin-right: 10px;
        }

        span.select2-selection.select2-selection--single {
            height: 40px;
            padding: 5px;
        }

        b {
            margin-top: 5px !important;
        }

        #clientAddress {
            display: inline-block;
            max-width: 30ch;
            overflow-wrap: break-word;
            word-wrap: break-word;
            word-break: break-word;
            white-space: normal;
        }

        element.style {
            width: 70%;
        }

        @media (min-width: 768px) {
            .justify-content-md-end {
                justify-content: flex-end !important;
            }
        }

        .card-body.px-0 .row .col-md-6.mb-md-0.mb-3 {
            width: 20%;
        }

        .datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-top {
            z-index: 99999 !important;
        }

        body.dark-mode span.select2-selection.select2-selection--single {
            background: #312d4b;
        }

        body.dark-mode span#select2-currency-dropdown-container {
            color: #cbc8e0;
        }

        body.dark-mode span.select2-dropdown.select2-dropdown--below {
            background: #312d4b;
            color: #cbc8e0;
        }

        body.dark-mode input.select2-search__field {
            background: #312d4b;
            color: #c3c1d9;
        }

        body.dark-mode span#select2-clientSelect-container {
            color: #c2bfd7;
        }

        .select2-search--dropdown {
            display: block;
            padding: 0px;
        }
    </style>

    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-lg-9 col-12 mb-lg-0 mb-6">
                <div class="card invoice-preview-card p-sm-12 p-6"><grammarly-extension data-grammarly-shadow-root="true"
                        style="position: absolute; top: 0px; left: 0px; pointer-events: none;"
                        class="dnXmp"></grammarly-extension><grammarly-extension data-grammarly-shadow-root="true"
                        style="position: absolute; top: 0px; left: 0px; pointer-events: none;"
                        class="dnXmp"></grammarly-extension>
                    <div class="card-body invoice-preview-header rounded p-6 px-3 text-heading">
                        <div class="row mx-0 px-3">
                            <input type="hidden" id="invoice_number" name="invoice_number"
                                value="{{ old('invoice_number', $invoiceNumber) }}">
                            <div class="col-md-7 mb-md-0 mb-6 ps-0">
                                <div class="d-flex svg-illustration align-items-center gap-3 mb-6">
                                    <span class="app-brand-logo demo">
                                        <img src="{{ asset('assets/img/favicon/logo.png') }}" alt="logo"
                                            style="width: auto;height: 50px;">
                                    </span>
                                    </span>
                                </div>
                                <p class="mb-1">325 - Silver Trade Center, near Oxygen</p>
                                <p class="mb-1">Park, Opp. GEB Power House, Uttran, Surat,</p>
                                <p class="mb-1">Gujrat, India 394105,</p>
                                <p class="mb-0">+91 89801 84903</p>
                            </div>
                            <div class="col-md-5 col-8 pe-0 ps-0 ps-md-2">
                                <dl class="row mb-0 gx-4">
                                    <dt class="col-sm-5 mb-2 d-md-flex align-items-center justify-content-start">
                                        <span class="h5 text-capitalize mb-0 text-nowrap">Invoice</span>
                                    </dt>
                                    <dd class="col-sm-7">
                                        <div class="input-group input-group-sm input-group-merge disabled">
                                            <span class="input-group-text">#</span>
                                            <input type="text" class="form-control invoiceId" disabled
                                                placeholder="Invoice Number"
                                                value="{{ old('invoice_number', $invoiceNumber) }}" id="invoiceId">
                                        </div>
                                    </dd>
                                    <dt class="col-sm-5 mb-2 d-md-flex align-items-center justify-content-start">
                                        <span class="fw-normal text-nowrap">Date Issued:</span>
                                    </dt>
                                    <dd class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm invoice-date dob-picker"
                                            placeholder="YYYY-MM-DD" readonly="readonly">
                                    </dd>
                                    <dt class="col-sm-5 d-md-flex align-items-center justify-content-start">
                                        <span class="fw-normal">Due Date:</span>
                                    </dt>
                                    <dd class="col-sm-7 mb-0">
                                        <input type="text" class="form-control form-control-sm due-date dob-picker"
                                            placeholder="YYYY-MM-DD" readonly="readonly">
                                    </dd>
                                    <dt class="col-sm-5 d-md-flex align-items-center justify-content-start">
                                        <span class="fw-normal">Currency</span>
                                    </dt>
                                    <dd class="col-sm-7 mb-0 mt-2">
                                        <select id="currency-dropdown" class="form-select select2">
                                            <option disabled>Select a currency</option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}"
                                                    {{ $currency->code == 'USD' ? 'selected' : '' }}>
                                                    {{ $currency->code }} ({{ $currency->name }} - {{ $currency->symbol }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="card-body px-0">
                        <div class="row my-1">
                            <div class="col-md-6 col-sm-5 col-12 mb-sm-0 mb-6">
                                <h6>Invoice To:</h6>
                                <div class="row">
                                    <div class="col-lg-6 col-md-8 col-12">
                                        <select class="form-select mb-4 select2" name="invoice_to" id="clientSelect">
                                            <option value="">Select Client</option> <!-- Default placeholder -->
                                            @foreach ($get_client as $client)
                                                <option value="{{ $client->id }}" data-address="{{ $client->address }}"
                                                    data-phone="{{ $client->phone }}" data-email="{{ $client->email }}"
                                                    data-client_payment_details="{{ $client->client_payment_details }}">
                                                    {{ $client->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <p class="mb-1 mt-2" id="clientAddress">[Client Address]</p>
                                <p class="mb-1" id="clientPhone">[Client Phone]</p>
                                <p class="mb-0" id="clientEmail">[Client Email]</p>
                            </div>
                            <div class="col-md-6 col-sm-7">
                                <h6>Bill To:</h6>

                                <p id="client_payment_details" class="">[Client Payment Details]</p>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-6 mt-1">
                    <div class="card-body pt-0 px-0">
                        <form class="source-item">
                            <div class="mb-4" id="new_item" data-repeater-list="group-a">
                                <div class="repeater-wrapper pt-0 pt-md-9" data-repeater-item="">
                                    <div class="d-flex border rounded position-relative pe-0">
                                        <div class="row w-100 p-5 gx-5">
                                            <div class="col-md-5 col-12 mb-md-0 mb-3">
                                                <h6 class="mb-2 repeater-title fw-medium">Item</h6>
                                                <textarea class="form-control text_area" rows="2" placeholder="Enter item description"></textarea>
                                                <br>
                                                <div class="col-sm-7 mb-0">
                                                    <h6 class="mb-2 repeater-title fw-medium">DATE</h6>
                                                    <input type="text"
                                                        class="form-control form-control-sm due-date dob-picker"
                                                        placeholder="YYYY-MM-DD" readonly="readonly" id="start_date">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-12 mb-md-0 mb-5">
                                                <h6 id="unit-cost-label" class="h6 repeater-title">Unit Cost</h6>
                                                <h6 id="hourly-unit-cost-label" class="h6 repeater-title"
                                                    style="display: none;">Hourly Unit Cost</h6>
                                                <input type="text"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                                    id="unit-cost" class="form-control invoice-item-price mb-5"
                                                    placeholder="Cost" min="12">
                                            </div>
                                            <div class="col-md-2 col-12 mb-md-0 mb-4">
                                                <h6 class="h6 repeater-title">Project Type</h6>
                                                <select id="project-type" class="form-control project-type">
                                                    <option value="" disabled selected>Select Project Type</option>
                                                    <option value="fix">Fix</option>
                                                    <option value="hourly">Hourly</option>
                                                </select>
                                            </div>
                                            <div id="hourly-fields" class="col-md-2 col-12 mb-md-0 mb-4"
                                                style="display: none;">
                                                <h6 class="h6 repeater-title">Hours</h6>
                                                <input type="text"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                                    id="hours" class="form-control hours" placeholder="Enter hours"
                                                    min="1">
                                            </div>
                                            <div id="fixqty-fields" class="col-md-2 col-12 mb-md-0 mb-4"
                                                style="display: none;">
                                                <h6 class="h6 repeater-title">QTY</h6>
                                                <input type="text"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                                    id="fixqty" class="form-control fixqty" placeholder="Enter Qty"
                                                    min="1">
                                            </div>
                                            <div class="col-md-1 col-12 pe-0">
                                                <h6 class="h6 repeater-title">Price</h6>
                                                <span id="currency-symbol" class="ms-1"
                                                    style="font-weight: bold;"></span>
                                                <p id="total-price" class="mb-0 mt-2 text-heading total-price"
                                                    style="display: inline;">0.00</p>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                                            <i class="ri-close-line cursor-pointer" data-repeater-delete=""
                                                style="display:none"></i>
                                            <div class="dropdown">
                                                <div class="dropdown-menu dropdown-menu-end w-px-300 p-4"
                                                    id="taxDiscountDropdown">
                                                    <i class="ri-close-line cursor-pointer close-dropdown"
                                                        style="float: right; cursor: pointer;"></i>
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label for="discountInput" class="form-label">Discount</label>
                                                            <input type="number" class="form-control" id="discountInput"
                                                                min="0" max="100" value="0">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="taxInput1"
                                                                class="form-label"><strong>SGST</strong></label>
                                                            <input type="number" class="form-control" id="taxInput1"
                                                                min="0" max="100" value="0">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="taxInput2"
                                                                class="form-label"><strong>CGST</strong></label>
                                                            <input type="number" class="form-control" id="taxInput2"
                                                                min="0" max="100" value="0">
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-divider my-4"></div>
                                                    <button type="button"
                                                        style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;"
                                                        class="btn btn-apply-changes waves-effect">Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <!-- Button 1: Add Item -->
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm waves-effect waves-light"
                                style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;"
                                data-repeater-create="">
                                <i class="ri-add-line ri-14px me-1"></i> Add Item
                            </button>
                        </div>

                        <!-- Button 2: Apply -->
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm waves-effect waves-light" id="applytotal"
                                style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;"
                                data-repeater-apply="">
                                <i class="ri-14px me-1"></i> Apply
                            </button>
                        </div>

                        <!-- Tax & Discount Button -->
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm waves-effect waves-light" id="tax_discount_apply"
                                style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;">
                                <i class="ri-14px me-1"></i> <strong>%</strong> Tax & Discount
                            </button>
                        </div>
                    </div>

                    <hr class="my-1">
                    <div class="card-body px-0">
                        <div class="row">
                            <!-- Left Side -->
                            <div class="col-md-6 mb-md-0 mb-3">
                                <div class="invoice-details">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="w-px-100">Discount(%):</span>
                                        <h6 class="mb-0"><span class="discount-percentage dis_tax_values"
                                                id="dis_per"></span></h6>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="w-px-100">SGST(%):</span>
                                        <h6 class="mb-0"><span class="sgst-percentage sgst_tax_values"
                                                id="sgst_tax"></span></h6>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="w-px-100">CGST(%):</span>
                                        <h6 class="mb-0"><span class="cgst-percentage cgst_tax_values"
                                                id="cgst_tax"></span></h6>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side -->
                            <div class="col-md-6 d-flex justify-content-md-end mt-2">
                                <div class="invoice-calculations">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="w-px-100">Subtotal:</span>
                                        <h6 class="mb-0"><span class="subtotal"></span></h6>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="w-px-100">Discount:</span>
                                        <h6 class="mb-0"><span class="discount"></span></h6>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="w-px-100">SGST Tax:</span>
                                        <h6 class="mb-0"><span class="sgsttax"></span></h6>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="w-px-100">CGST Tax:</span>
                                        <h6 class="mb-0"><span class="cgsttax"></span></h6>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="w-px-100">Total:</span>
                                        <h6 class="mb-0"><span class="total"></span></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-1">
                    <div class="card-body px-0">
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <label for="note" class="h6 mb-1 fw-normal">Note:</label>
                                    <textarea class="form-control" rows="2" id="note" spellcheck="false">It was a pleasure working with you and your team. We hope you will keep us in mind for future freelance projects. Thank You!</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <grammarly-extension-vbars data-grammarly-shadow-root="true"
                        class="dnXmp"></grammarly-extension-vbars>
                    <div class="row justify-content-end">
                        <!-- Button 1: Add Item -->
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm waves-effect waves-light" id="create-invoice"
                                style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #fff;">
                                <i class="ri-add-line ri-14px me-1"></i> Invoice Create
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Ensure jQuery is loaded first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Repeater.js -->
    <script src="https://cdn.jsdelivr.net/npm/jquery.repeater@1.2.0/dist/jquery.repeater.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


    <script>
        $(document).ready(function() {
            // Add Item button functionality
            $('[data-repeater-create]').on('click', function() {
                // Find the hidden form template and clone it
                var newItem = $('#new_item .repeater-wrapper').first().clone();
                newItem.find('input, select, textarea').val('');
                newItem.find('.error').remove();
                // Show the close button for the newly added item
                newItem.find('.ri-close-line').show();

                // Append the new item to the repeater list
                $('#new_item').append(newItem);

                // Re-initialize the event listeners for the new fields
                initItemEvents(newItem);

                newItem.find('.dob-picker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    dateFormat: "d-m-Y"
                });

                updateItemPrice(newItem);
                updateTotalPrice();
            });


            // Apply changes button click event
            $(document).on('click', '.btn-apply-changes', function() {
                // Get values from the input fields in the current form
                var discount = $(this).closest('.dropdown-menu').find('#discountInput').val();
                var tax1 = $(this).closest('.dropdown-menu').find('#taxInput1').val();
                var tax2 = $(this).closest('.dropdown-menu').find('#taxInput2').val();

                // Hide the dropdown after applying changes
                $(this).closest('.dropdown-menu').dropdown('hide');

                // Apply tax and discount values to each item
                $('#new_item').parent().find('.repeater-wrapper').each(function() {
                    $(this).find('#dis_per').text(discount + '%');
                    $(this).find('#sgst_tax').text(tax1 + '%');
                    $(this).find('#cgst_tax').text(tax2 + '%');
                    updateItemPrice($(this));
                });
            });

            // Apply changes button click event
            $(document).on('click', '.btn-apply-changes', function() {
                // Get values from the input fields in the current form
                var discount = $(this).closest('.dropdown-menu').find('#discountInput').val();
                var tax1 = $(this).closest('.dropdown-menu').find('#taxInput1').val();
                var tax2 = $(this).closest('.dropdown-menu').find('#taxInput2').val();

                // Hide the dropdown after applying changes
                $(this).closest('.dropdown-menu').dropdown('hide');
            });

            // Delete button functionality
            $(document).on('click', '[data-repeater-delete]', function() {
                const currentItem = $(this).closest('.repeater-wrapper');
                const isDefaultItem = currentItem.attr('data-default-item') === 'true';

                if (isDefaultItem) {
                    // Prevent deletion of the default form
                    alert('The default form cannot be deleted.');
                    return; // Exit the function
                }

                currentItem.remove(); // Remove the repeater item
                updateTotalPrice(); // Recalculate the total price after deletion
            });

            // Initialize event listeners for all items (both initial and added)
            function initItemEvents(item) {
                // Handle project type change
                item.find('#project-type').on('change', function() {
                    const selectedProjectType = $(this).val();
                    if (selectedProjectType === 'hourly') {

                        $(this).closest('.row').find('#hourly-unit-cost-label').show();
                        $(this).closest('.row').find('#hourly-fields').show();
                        $(this).closest('.row').find('#fixqty-fields').hide();

                    } else if (selectedProjectType === 'fix') {

                        $(this).closest('.row').find('#fixqty-fields').show();
                        $(this).closest('.row').find('#hourly-fields, #hourly-unit-cost-label').hide();
                    } else {
                        $(this).closest('.row').find(
                            '#hourly-fields, #hourly-unit-cost-label, #fixqty-fields').hide();
                    }

                    updateItemPrice(item); // Update total price when project type changes
                });

                // Handle cost input change
                item.find('#unit-cost').on('input', function() {
                    updateItemPrice(item); // Update total price when cost changes
                });

                // Handle hours input change (for hourly projects)
                item.find('#hours').on('input', function() {
                    updateItemPrice(item); // Update total price when hours change
                });

                // Handle quantity input change (for fixed projects)
                item.find('#fixqty').on('input', function() {
                    updateItemPrice(item); // Update total price when quantity changes
                });

                // Handle tax input changes dynamically for each item
                item.find('.tax-select').on('change', function() {
                    updateItemPrice(item); // Recalculate total price when taxes are changed
                });
            }

            // Function to calculate price based on project type
            function calculateItemPrice(cost, projectType, hours, fixqty) {
                let price = cost || 0; // Default to 0 if cost is not provided
                switch (projectType) {
                    case 'fix':
                        price = cost * fixqty; // Fixed cost
                        break;
                    case 'hourly':
                        price = cost * hours; // Multiply unit cost by hours worked
                        break;
                    default:
                        price = 0;
                        break;
                }
                return price;
            }

            // Function to update the total price dynamically for a single item
            function updateItemPrice(item) {
                const projectType = item.find('#project-type').val(); // Get selected project type
                const cost = parseFloat(item.find('#unit-cost').val()) || 0; // Get cost
                const hours = parseFloat(item.find('#hours').val()) || 0; // Get entered hours
                const fixqty = parseFloat(item.find('#fixqty').val()) || 0; // Get commission percentage

                const price = calculateItemPrice(cost, projectType, hours, fixqty); // Calculate price

                // Get the selected currency value
                const selectedCurrency = $('#currency-dropdown').val();

                // Extract the currency symbol
                const currencySymbol = selectedCurrency ?
                    $('#currency-dropdown option:selected').text().match(/\(([^)]+) - ([^)]+)\)/)?.[2] :
                    '';

                // Update the total price display for the item
                item.find('#total-price').text(price.toFixed(2));

                // Show the currency symbol dynamically next to total-price
                if (currencySymbol) {
                    item.find('#currency-symbol').text(currencySymbol).show(); // Update and show the symbol
                } else {
                    item.find('#currency-symbol').hide(); // Hide the symbol if no currency is selected
                }
            }

            // Function to update the overall total price (if required)
            function updateTotalPrice() {
                let totalPrice = 0;
                $('#new_item').parent().find('.repeater-wrapper').each(function() {
                    const itemCost = parseFloat($(this).find('#total-price').text()) || 0;
                    totalPrice += itemCost;
                });

                // Update the overall total price
                $('#total-price').text(totalPrice.toFixed(2));
            }

            // Initialize Select2 after appending options
            $('#country-currency-dropdown').select2({
                templateResult: function(data) {
                    if (!data.id) {
                        return data.text; // Default if no flag is available
                    }
                    var flagClass = 'flag-icon-' + data.id.toLowerCase();
                    return $('<span class="dropdown-item"><span class="flag-icon ' + flagClass +
                        '"></span> ' + data.text + '</span>');
                },
                templateSelection: function(data) {
                    return $('<span class="dropdown-item"><span class="flag-icon flag-icon-' + data.id
                        .toLowerCase() + '"></span> ' + data.text + '</span>');
                },
                width: '100%'
            });

            // Initialize the first item
            initItemEvents($('#new_item')); // Apply the logic to the initial item as well

            // Project type change logic (for new items as well)
            $(document).on('change', '#project-type', function() {
                if ($(this).val() === 'hourly') {
                    $(this).closest('.row').find('#unit-cost-label').hide();
                    $(this).closest('.row').find('#hourly-unit-cost-label').show();
                } else {
                    $(this).closest('.row').find('#hourly-unit-cost-label').hide();
                    $(this).closest('.row').find('#unit-cost-label').show();
                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {

            // Function to update the currency symbol based on the dropdown
            function updateCurrencySymbol() {
                const selectedCurrency = $('#currency-dropdown').val();
                const currencySymbol = selectedCurrency ?
                    $('#currency-dropdown option:selected').text().match(/\(([^)]+) - ([^)]+)\)/)?.[2] :
                    '';

                return currencySymbol;
            }

            // Update the total price and currency symbol for each item
            function updateItemPrice(item) {
                const price = parseFloat(item.find('#total-price').text()) || 0;
                const currencySymbol = updateCurrencySymbol();

                // Update total price display
                item.find('#total-price').text(price.toFixed(2));

                // Show the currency symbol dynamically
                if (currencySymbol) {
                    item.find('#currency-symbol').text(currencySymbol).show(); // Show the symbol
                } else {
                    item.find('#currency-symbol').hide(); // Hide if no currency symbol
                }
            }

            // Update Calculations as Global Function
            window.updateCalculations = function() {
                let subtotal = 0;
                let totalDiscount = 0;
                let totalSGST = 0;
                let totalCGST = 0;

                // Loop through each item and perform calculations
                $('#new_item').parent().find('.repeater-wrapper').each(function() {
                    const item = $(this); // Reference the current item in the loop
                    const itemPrice = parseFloat(item.find('#total-price').text()) || 0;
                    let itemDiscount = parseFloat($('.dis_tax_values').text()) || 0;
                    let itemSGST = parseFloat($('.sgst_tax_values').text()) || 0;
                    let itemCGST = parseFloat($('.cgst_tax_values').text()) || 0;

                    // Add to the totals
                    subtotal += itemPrice;
                    totalDiscount += (itemPrice * itemDiscount) / 100;
                    totalSGST += (itemPrice * itemSGST) / 100;
                    totalCGST += (itemPrice * itemCGST) / 100;
                });

                // Final Calculation for total (Subtotal + SGST + CGST - Discount)
                const total = subtotal + totalSGST + totalCGST - totalDiscount;

                // Get the currency symbol
                const currencySymbol = updateCurrencySymbol();

                // Update the UI with the calculations
                $('.invoice-calculations .subtotal').text(`${currencySymbol}${subtotal.toFixed(2)}`);
                $('.invoice-calculations .discount').text(`${currencySymbol}${totalDiscount.toFixed(2)}`);
                $('.invoice-calculations .sgsttax').text(`${currencySymbol}${totalSGST.toFixed(2)}`);
                $('.invoice-calculations .cgsttax').text(`${currencySymbol}${totalCGST.toFixed(2)}`);
                $('.invoice-calculations .total').text(`${currencySymbol}${total.toFixed(2)}`);
            };

            // Bind Apply Total button to the calculation
            $(document).on('click', '#applytotal', function() {
                window.updateCalculations();
            });

            // Update the price and currency symbol when a new item is added or changed
            $('#currency-dropdown').on('change', function() {
                $('#new_item').parent().find('.repeater-wrapper').each(function() {
                    updateItemPrice($(this)); // Update each item's price and currency symbol
                });
                window.updateCalculations(); // Recalculate totals after currency change
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Button click to toggle dropdown
            $('#tax_discount_apply').on('click', function() {
                // Toggle dropdown visibility
                $('#taxDiscountDropdown').toggleClass('show');
            });

            // Apply changes button click event
            $('.btn-apply-changes').on('click', function() {
                let discount = $('#discountInput').val() || 0;
                let sgst = $('#taxInput1').val() || 0;
                let cgst = $('#taxInput2').val() || 0;

                // અપડેટ મૂલ્યો DOMમાં
                $('.discount-percentage').text(discount + '%');
                $('.sgst-percentage').text(sgst + '%');
                $('.cgst-percentage').text(cgst + '%');

                // Close the dropdown after applying changes
                $('#taxDiscountDropdown').removeClass('show');
            });

            // Close dropdown if clicked outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#tax_discount_apply, #taxDiscountDropdown').length) {
                    $('#taxDiscountDropdown').removeClass('show');
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Handle the change event for the dropdown
            $('#clientSelect').on('change', function() {
                // Get the selected option
                var selectedOption = $(this).find(':selected');

                // Retrieve data attributes from the selected option
                var address = selectedOption.data('address') || 'N/A';
                var phone = selectedOption.data('phone') || 'N/A';
                var email = selectedOption.data('email') || 'N/A';
                var clientPaymentDetails = selectedOption.data('client_payment_details') || 'N/A';

                // Clean up the client payment details if it's HTML (like a table)
                var cleanClientPaymentDetails = cleanPaymentDetails(clientPaymentDetails);

                // Update the placeholders with the retrieved data
                $('#clientAddress').text(address);
                $('#clientPhone').text(phone);
                $('#clientEmail').text(email);
                $('#client_payment_details').html(
                    cleanClientPaymentDetails); // Use `.html()` to render HTML safely
            });

            // Function to clean and format payment details (in case it's an HTML table)
            function cleanPaymentDetails(details) {
                // Check if the details include HTML table tags and clean them
                var tempDiv = document.createElement('div');
                tempDiv.innerHTML = details; // Insert the HTML into a temporary div

                // You can now process the table and convert it to something cleaner, e.g., just the text content
                if (tempDiv.querySelector('table')) {
                    var rows = tempDiv.querySelectorAll('table tr');
                    var formattedDetails = '';

                    rows.forEach(function(row) {
                        var cells = row.querySelectorAll('td');
                        if (cells.length > 0) {
                            var label = cells[0].textContent.trim();
                            var value = cells[1].textContent.trim();
                            formattedDetails += label + ': ' + value + '<br>';
                        }
                    });
                    return formattedDetails;
                }

                // If no table is found, just return the details as is
                return tempDiv.innerHTML;
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            // Close dropdown when the close button is clicked
            $(document).on('click', '.close-dropdown', function() {
                $('#taxDiscountDropdown').removeClass('show'); // Hide the dropdown
            });

            // Close dropdown if clicked outside of it
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#taxDiscountDropdown, #tax_discount_apply').length) {
                    $('#taxDiscountDropdown').removeClass('show');
                }
            });
        });
    </script>

    <script>
        $('#create-invoice').on('click', function() {
            let items = [];
            $('#new_item .repeater-wrapper').each(function() {
                items.push({
                    start_date: $(this).find('#start_date').val(),
                    item: $(this).find('.text_area').val(),
                    unit_rate: $(this).find('#unit-cost').val(),
                    project_type: $(this).find('#project-type').val(),
                    iteam_qty: $(this).find('#fixqty').val(),
                    iteam_hours: $(this).find('#hours').val(),
                    price: $(this).find('#total-price').text()
                });
            });

            $.ajax({
                url: "{{ route('admin.invoice.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    invoice_number: $('#invoice_number').val(),
                    date_issued: $('.invoice-date').val(),
                    due_date: $('.due-date').val(),
                    currency_id: $('#currency-dropdown').val(),
                    client_id: $('#clientSelect').val(),
                    discount_per: $('.dis_tax_values').text(),
                    sgst_per: $('.sgst_tax_values').text(),
                    cgst_per: $('.cgst_tax_values').text(),
                    subtotal: $('.subtotal').text(),
                    discount: $('.discount').text(),
                    sgst: $('.sgsttax').text(),
                    cgst: $('.cgsttax').text(),
                    total: $('.total').text(),
                    items: items
                },
                success: function(response) {
                    console.log(response, 'response')
                    window.location.href = "{{ url('team-head/invoice/preview') }}/" + response
                    .id; // Open in the same tab
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText); // Check the response in case of an error
                }
            });
        });
    </script>
@endsection
