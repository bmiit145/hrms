
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
    body {
    
        margin: 0;
        padding: 0;
    }

    .watermark {
        position: absolute;
        top: 42%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 10.5;
        z-index: 100;
        pointer-events: none;
        bottom: 50%;
    }

    .invoice-container {
        width: 210mm; /* A4 width */
        min-height: 297mm; /* A4 height */
        margin: auto;
        padding: 20mm; /* Ensure some margin inside the page */
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        background: #fff;
        position: relative;
    }
    .table-container {
        width: 100%;
        border-collapse: collapse;
        margin-top: 6px;
        font-family: 'Kollektif', sans-serif;
        text-align: center;
    }

    .table-container th, .table-container td {
        border: 1px solid #000;
        padding: 10px;
        font-size: 14px;
        line-height: 2;
    }

    .table-container th {
        background-color: #f4f4f48f; /* Light background for header */
        text-align: center;
        line-height: 2; /* Center-align header text */
    }

    .table-container tbody tr td {
        vertical-align: middle;
    }

    .table-container tbody tr:last-child td {
        border-top: 2px solid #000; /* Emphasize footer row */
    }

    .table-container tbody tr td:nth-child(5),
    .table-container tbody tr td:nth-child(6),
    .table-container tbody tr:last-child td:nth-child(6) {
        text-align: center; /* Right-align numeric columns */
    }

    /* Custom column widths */
    .table-container td:nth-child(1),
    .table-container th:nth-child(1) {
        width: 15%;
    }

    .table-container td:nth-child(2),
    .table-container th:nth-child(2) {
        width: 40%;
    }

    .table-container td:nth-child(3),
    .table-container th:nth-child(3) {
        width: 10%;
    }

    .table-container td:nth-child(4),
    .table-container th:nth-child(4) {
        width: 10%;
    }

    .table-container td:nth-child(5),
    .table-container th:nth-child(5) {
        width: 10%;
    }

    .table-container td:nth-child(6),
    .table-container th:nth-child(6) {
        width: 15%;
    }

    .table-header {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: 'Kollektif', sans-serif;
        text-align: center;
        

    }

    .table-header th {
        border: 1px solid #000;
        padding: 10px;
        font-size: 15px;
        background-color: #f4f4f4; /* Light background for header */
        text-align: center; /* Center-align header text */
            font-weight: 700;
    }

    /* Custom column widths */
    .table-header th:nth-child(1) {
        width: 15%;
    }

    .table-header th:nth-child(2) {
        width: 40%;
    }

    .table-header th:nth-child(3) {
        width: 10%;
    }

    .table-header th:nth-child(4) {
        width: 10%;
    }

    .table-header th:nth-child(5) {
        width: 10%;
    }

    .table-header th:nth-child(6) {
        width: 15%;
    }

    .total-amount {
        width: 38%;
        margin-top: 20px;
        background-color: hsl(0deg 0% 95.69%);
        padding: 10px;
        border: 1px solid #000;
        text-align: center;
        margin-right: -72%;
    }


    .invoice-footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-top: 30px;
    }


    .invoice-title {
        font-size: 200%;
        font-weight: 950; /* Makes the title extra bold */
    }
    .Kollektif{
          font-family: 'Kollektif', sans-serif;
    }
    .back_to_page{
   background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
        color: #f0f8ff;
        width: 6%;
        text-decoration: none;
        height: 29px;
        border-radius: 5px;
        border: none;
        cursor: pointer;

    }
    .datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-top {
            z-index: 99999 !important;
        }
</style>
<style>
    /* Printing specific styles */
    @media print {
        @page {
            size: A4; /* Explicitly set the size to A4 */
            margin: 0; /* Remove default browser margins */
        }
        body {
            margin: 0;
            padding: 0;
        }
        .invoice-container {
            margin: 0;
            box-shadow: none; /* Remove shadow for printing */
            padding: 10mm; /* Adjust padding for print */
        }
       .back_to_page {
            display: none; /* Hide any non-print elements */
        }
    }
</style>
<style>
    @font-face {
        font-family: 'Kollektif';
        src: url('fonts/kollektif/Kollektif-Regular.woff2') format('woff2'),
             url('fonts/kollektif/Kollektif-Regular.woff') format('woff'),
             url('fonts/kollektif/Kollektif-Regular.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
</style>

<style>
    @font-face {
        font-family: 'Garet';
        src: url('fonts/garet/Garet-Regular.woff2') format('woff2'),
             url('fonts/garet/Garet-Regular.woff') format('woff'),
             url('fonts/garet/Garet-Regular.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
    @font-face {
    font-family: 'Kollektif';
    src: url('fonts/Kollektif-Regular.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}
</style>
<div style="    text-align: center;
    margin-top: 1%;
    margin-bottom: 1%;">
    <button class="btn btn-secondary back_to_page">Back To Page</button>
</div>
<body>

    <div class="watermark">
        <img src="{{ asset('assets/img/favicon/logo2.png') }}" alt="Watermark" style="width: 500px; opacity: 0.1;">
    </div>

    <div class="invoice-container">

        <!-- Header -->
        <div class="invoice-header" style="display: flex; justify-content: space-around; align-items: start; gap: 0; margin: 0 -20px;">
            <!-- Left side - Invoice -->
            <div class="left-header" style="width: 50%; padding: 0 20px;">
                <h1 class="invoice-title" style="font-family: 'Garet', sans-serif; font-size: 310%; font-weight: 950;">
                    INVOICE
                </h1>
                <p  class="Kollektif">
                    Date: {{ $invoice->date_issued ? \Carbon\Carbon::parse($invoice->date_issued)->format('d-m-y') : '' }} <br>
                    <b>_________________________</b>
                </p>
                <p class="Kollektif">
                    No. Invoice: {{ $invoice->invoice_number }} <br>
                    <b>_________________________</b>
                </p>
                <p style="font-size: 14px; font-family: 'Open Sans', sans-serif; ">
                    <b>Bill to: {{ $invoice->client->name }}</b><br>
                </p>

                <p style="font-size: 14px; font-family: 'Open Sans', sans-serif;  ">
                    <b>{{ $invoice->client->address }}</b><br>
                </p> 

                <p style="font-size: 14px; font-family: 'Open Sans', sans-serif; ">
                    <b>Mobile No: +{{ $invoice->client->phone }}</b><br> 
                </p>
                <p style="font-size: 14px; font-family: 'Open Sans', sans-serif; ">
                    <b>Email: {{ $invoice->client->email }}</b><br>
                </p>
            </div>

            <!-- Right side - Company logo and info -->
            <div class="company-info" style="width: 50%; padding: 0 20px;">
                
                <img src="{{ asset('assets/img/favicon/logo.png') }}" alt="Company Logo" style="width: 300px;" >

                <h2 class="company-name" style="font-size: 26px; margin-top: 2%; font-family: 'Open Sans', sans-serif;">
                    <b>Place Code Solution Pvt.Ltd.</b>
                </h2>
                    
                <p class="address" style="white-space: normal; line-height: 2; font-size: 14px; margin-top: 5%; font-family: 'Open Sans', sans-serif;">
                    <b>323 - Silver  Trade  Center,  near  Oxygen Park,</b><br>
                    <b>Opp. GEB Power House, Uttran, Surat,</b><br>
                    <b>Gujrat, India 394105</b>
                </p>

                <p class="bank-detils" style="white-space: normal; line-height: 2.2; font-size: 14px; margin-top: 2.5%; font-family: 'Open Sans', sans-serif;">
                    <b>Bank Name: IDFC FIRST</b><br>
                    <b>Name : PLACECODE SOLUTION PRIVATE LIMITED</b><br>
                    <b>IFSC Code : IDFB0042261</b><br>
                    <b>Account No : 10155250289</b><br>
                    <b>SWIFT Code : IDFBINBBMUM</b><br>
                    <b>PAN Number : AAOCP1302K</b>
                </p>
            </div>
        </div>

        @php
            // Ensure that these values are treated as numbers (float or int) and remove currency symbols
            $subtotal = preg_replace('/[^\d.]/', '', $invoice->subtotal); // Remove anything that's not a number or dot
            $discountValue = preg_replace('/[^\d.]/', '', $invoice->discount); // Same for discount
            $sgstValue = preg_replace('/[^\d.]/', '', $invoice->sgst); // Same for SGST
            $cgstValue = preg_replace('/[^\d.]/', '', $invoice->cgst); // Same for CGST
        
            // Convert the sanitized strings to float values for proper calculations
            $subtotal = (float) $subtotal;
            $discountValue = (float) $discountValue;
            $sgstValue = (float) $sgstValue;
            $cgstValue = (float) $cgstValue;
        
            // Prevent division by zero by checking if $subtotal is not zero
            $discountPercentage = $subtotal > 0 ? ($discountValue / $subtotal) * 100 : 0;
            $sgstPercentage = $subtotal > 0 ? ($sgstValue / $subtotal) * 100 : 0;
            $cgstPercentage = $subtotal > 0 ? ($cgstValue / $subtotal) * 100 : 0;
        @endphp
        
        <table class="table-header">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Item Description</th>
                    <th>Price</th>

                    @php
                    $showQty = false;
                    $showHours = false;
                
                    // Check if any item has a value for qty or hours
                    foreach ($invoice->items as $item) {
                        if ($item->iteam_qty) {
                            $showQty = true;
                        }
                        if ($item->iteam_hours) {
                            $showHours = true;
                        }
                    }
                @endphp
                
                <!-- Conditionally display "Qty" or "Hours" columns -->
                @if($showQty && !$showHours)
                    <!-- Show only Qty -->
                    <th>Qty</th>
                    <th style="display: none;"></th>
                @elseif($showHours && !$showQty)
                    <!-- Show only Hours -->
                    <th style="display: none;"></th>
                    <th>Hours</th>
                @elseif($showQty && $showHours)
                    <!-- Show both columns -->
                    <th>Qty</th>
                    <th>Hours</th>
                @endif

                    <th>Total</th>
                </tr>
            </thead>
        </table>


        <!-- Table for Body/Entries -->
        <table class="table-container">
            <tbody>
                @php
                    $totalUnitRate = 0; // Total of unit rates
                    $totalQty = 0; // Total of quantities
                    $totalHours = 0; // Total of hours
                @endphp
        
                @foreach ($invoice->items as $item)
                <tr>
                    <td style="font-size: medium;font-weight: bold">{{ $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('d-m-y') : '' }}</td> 
                   <td style="font-size: medium; text-transform: capitalize">{{ $item->item }}</td>
                    <td style="font-size: medium;">{{ $item->unit_rate }}</td>
        
                    @php
                        $totalUnitRate += $item->unit_rate;
                        $totalQty += $item->iteam_qty;
                        $totalHours += $item->iteam_hours;
                    @endphp
        
                    <!-- Conditionally show qty or hours columns -->
                    {{-- @if($showQty && $showHours)
                        <td><b>{{ $item->iteam_qty }}</b></td>
                        <td><b>{{ $item->iteam_hours }}</b></td>
                    @elseif($showQty)
                        <td><b>{{ $item->iteam_qty }}</b></td>
                    @elseif($showHours)
                        <td><b>{{ $item->iteam_hours }}</b></td>
                    @endif --}}

                    <td style="font-weight: bold;font-size: medium">
                      @if($showQty && $showHours)
                       {{ $item->iteam_qty }}
                        {{ $item->iteam_hours }}
                        @elseif($showQty)
                            {{ $item->iteam_qty }}
                        @elseif($showHours)
                            {{ $item->iteam_hours }}
                        @endif
            
                    </td>
        
                    <td style="font-weight: bold;font-size: medium">{{ $item->price }}</td>
                </tr>
                @endforeach
        
                <!-- Empty rows for spacing -->
                <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        
                <!-- Discount Row -->
                @if(floatval(preg_replace('/[^\d.]/', '', $invoice->discount)) != 0)
                <tr>
                    <td></td>
                    <td style="font-weight: bold;">Discount ({{ round($discountPercentage, 2) }}%)</td>
                    <td></td>
                    <td></td>
                    <td style="font-weight: bold;">{{ $invoice->discount }}</td>
                </tr>
                @endif
        
                <!-- SGST Row -->
                @if(floatval(preg_replace('/[^\d.]/', '', $invoice->sgst)) != 0)
                <tr>
                    <td></td>
                    <td style="font-weight: bold;">SGST ({{ round($sgstPercentage, 2) }}%)</td>
                    <td></td>
                    <td></td>
                    <td style="font-weight: bold;">{{ $invoice->sgst }}</td>
                </tr>
                @endif
        
                <!-- CGST Row -->
                @if(floatval(preg_replace('/[^\d.]/', '', $invoice->cgst)) != 0)
                <tr>
                    <td></td>
                    <td style="font-weight: bold;">CGST ({{ round($cgstPercentage, 2) }}%)</td>
                    <td></td>
                    <td></td>
                    <td style="font-weight: bold;">{{ $invoice->cgst }}</td>
                </tr>
                @endif
        
                <!-- Footer Row -->
                <tr>
                    <td></td>
                    <td><strong>Payable Amount</strong></td>
                    <td style="font-size: medium">{{ $totalUnitRate }}</td>
                    @if($showQty && !$showHours)
                    <!-- Qty column visible, Hours column hidden -->
                    <td style="font-weight: bold;font-size: medium">{{ $totalQty }}</td>
                    <td style="display: none;"></td>
                @elseif($showHours && !$showQty)
                    <!-- Hours column visible, Qty column hidden -->
                    <td style="display: none;"></td>
                    <td style="font-weight: bold;font-size: medium">{{ $totalHours }}</td>
                @else
                    <!-- Both columns visible -->
                    <td style="font-weight: bold;font-size: medium">{{ $totalQty }}</td>
                    <td style="font-weight: bold;font-size: medium">{{ $totalHours }}</td>
                @endif
                    <td style="font-weight: bold;font-size: medium">{{ $invoice->total }}</td>
                </tr>
            </tbody>
        </table>
        

        <!-- Footer Section -->
        <div class="invoice-footer">
            <div class="footer">
                <!-- HTML with Garet Font -->
                <h2 class="invoice-title" style="font-family: 'Garet', sans-serif;">
                    THANK YOU!
                </h2>
                <p class="Kollektif"> +91 89801 84903 </p>   
                <p class="Kollektif">placecode3015@gmail.com</p>    
                <p class="Kollektif">www.placecodesolutions.com
                  </p>                  
            </div>            
            <table class="total-amount">
                <thead>
                    <tr>
                        <td class="Kollektif" style="font-weight: bold;">Total:
                            @php
                                // Remove any non-numeric characters except decimal point
                                $totalAmount = preg_replace('/[^0-9.]/', '', $invoice->total);
                            @endphp
                        
                            @if($invoice->currency)
                                {{ $invoice->currency->symbol }}{{ number_format((float)$totalAmount, 2) }}/- {{ $invoice->currency->code }}
                            @else
                                {{ number_format((float)$totalAmount, 2) }}
                            @endif
                        </td>                        
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <p style="margin-top: auto">______________________________________ </p>
            
        </div>

    </div>

</body>
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>
 

     $('.back_to_page').click(function(event) {

        // Construct the new URL with month and year
        var url = "{{ route('hr.invoice.index') }}";
        window.location.href = url;
    });

    
</script>

    <!-- Ensure jQuery is loaded first -->

