{{-- @section('content') --}}

<link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
<style>
    body {
        font-family: Arial, sans-serif;
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
        width: 210mm;
        min-height: 297mm;
        margin: auto;
        padding: 20mm;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        background: #fff;
        position: relative;
        padding: 20px;
    }

    .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
        gap: 100px;
    }

    .invoice-header .logo img {
        width: 100px;
    }

        .invoice-header .company-info {
        width: 50%;
        white-space: normal; 
        line-height: 1.6; 
        padding-left: 20px;
    }

    .invoice-header > div:first-child {
        width: 45%; 
    }

    .invoice-header .company-info h2 {
        font-size: 20px;
        margin-bottom: 5px;
    }

    .table-container {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: Arial, sans-serif;
        text-align: center;
    }

    .table-container th, .table-container td {
        border: 1px solid #000;
        padding: 10px;
        font-size: 14px;
    }

    .table-container th {
        background-color: #f4f4f48f; /* Light background for header */
        text-align: center; /* Center-align header text */
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
        width: 16%;
    }

    .table-container td:nth-child(2),
    .table-container th:nth-child(2) {
        width: 30%;
    }

    .table-container td:nth-child(3),
    .table-container th:nth-child(3) {
        width: 13%;
    }

    .table-container td:nth-child(4),
    .table-container th:nth-child(4) {
        width: 13%;
    }

    .table-container td:nth-child(5),
    .table-container th:nth-child(5) {
        width: 13%;
    }

    .table-container td:nth-child(6),
    .table-container th:nth-child(6) {
        width: 15%;
    }

    .table-header {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: Arial, sans-serif;
        text-align: center;
    }

    .table-header th {
        border: 1px solid #000;
        padding: 10px;
        font-size: 15px;
        background-color: #f4f4f4; /* Light background for header */
        text-align: center; /* Center-align header text */
    }

    /* Custom column widths */
    .table-header th:nth-child(1) {
        width: 16%;
    }

    .table-header th:nth-child(2) {
        width: 30%;
    }

    .table-header th:nth-child(3) {
        width: 13%;
    }

    .table-header th:nth-child(4) {
        width: 13%;
    }

    .table-header th:nth-child(5) {
        width: 13%;
    }

    .table-header th:nth-child(6) {
        width: 15%;
    }

    .total-amount {
        width: 40%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: hsla(0, 5%, 73%, 0.411);
        padding: 10px;
        border: 3px solid #aca8a893;
        text-align: center;
    }

    .total-amount th {
        font-size: 15px;
        padding: 10px;
        background-color: #ffffff4f;
        border: 1px solid #ccc;
        font-weight: bold;
        border-radius: 5px; /* Rounded corners */
    }


    .invoice-footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-top: 30px;
        font-family: Arial, sans-serif;
    }


    .invoice-title {
        font-size: 350%;
        font-weight: 950; /* Makes the title extra bold */
    }

    .footer p strong {
        display: block; /* Makes each <strong> element a block-level element */
        margin-bottom: 10px; /* Adds space between lines */
    }
    
    .footer-signature{
        text-align: right;
    }

</style>


<body>
    <div class="watermark">
        <img src="{{ asset('assets/img/favicon/logo2.png') }}" alt="Watermark" style="width: 500px; opacity: 0.1;">
    </div>

    <div class="invoice-container">

        <!-- Header -->
        <div class="invoice-header">
            <!-- Left side - Invoice -->
            <div>
                <b><h1 class="invoice-title">INVOICE</h1></b>
                <p><strong>Date: {{ $invoice->date_issued }}</strong><br>
                    <strong>_________________________</strong><br><br> 
                    <strong>No. Invoice: {{ $invoice->invoice_number }}</strong><br>
                    <strong>_________________________</strong><br><br> 
                    <strong>Bill to: {{ $invoice->client->name }}</strong><br><br>
                    <strong>{{ $invoice->client->address }}</strong><br>
                    <strong>{!! nl2br(strip_tags($invoice->client->client_payment_details)) !!}</strong><br>
                    <strong>{{ $invoice->client->email }}</strong><br> 
                    <strong>{{ $invoice->client->phone }}</strong><br> 
                </p>
            </div>

            <!-- Right side - Company logo and info -->
            <div class="company-info">
                <img src="{{ asset('assets/img/favicon/logo.png') }}" alt="Company Logo" style="width: 95%" >

                <h2>
                    <strong>Place Code Solution Pvt.Ltd.</strong>
                </h2>
                <p>
                    <strong>325 - Silver  Trade  Center,  near  Oxygen</strong><br>
                    <strong>Park, Opp. GEB Power House, Uttran, Surat,</strong><br>
                    <strong>Gujrat, India 394105</strong>
                </p>

                <p>
                    <strong>Bank Name: IDFC FIRST</strong><br>
                    <strong>Name : PLACECODE SOLUTION PRIVATE LIMITED</strong><br>
                    <strong>IFSC Code : IDFB0042261</strong><br>
                    <strong>Account No : 10155250289</strong><br>
                    <strong>SWIFT Code : IDFBINBBMUM</strong><br>
                    <strong>PAN Number : AAOCP1302K</strong>
                </p>
            </div>
        </div>

        <!-- Table for Header -->
        <table class="table-header">
            <thead>
                <tr>
                    <th><strong>Date</strong></th>
                    <th>Item Description</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Hours</th>
                    <th>Total</th>
                </tr>
            </thead>
        </table>

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
    
    
    
        <!-- Table for Body/Entries -->
        <!-- Table for Header -->
        <table class="table-header">
            <thead>
                <tr>
                    <th><strong>Date</strong></th>
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
                    @if($showQty && $showHours)
                        <th>Qty</th>
                        <th>Hours</th>
                    @elseif($showQty)
                        <th>Qty</th>
                    @elseif($showHours)
                        <th>Hours</th>
                    @endif

                    <th>Total</th>
                </tr>
            </thead>
        </table>

        <!-- Table for Body/Entries -->
        <table class="table-container">
            <tbody>
                @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $item->start_date }}</td>
                    <td>{{ $item->item }}</td>
                    <td>{{ $item->unit_rate }}</td>

                    <!-- Conditionally show qty or hours columns -->
                    @if($showQty && $showHours)
                        <td>{{ $item->iteam_qty }}</td>
                        <td>{{ $item->iteam_hours }}</td>
                    @elseif($showQty)
                        <td>{{ $item->iteam_qty }}</td>
                    @elseif($showHours)
                        <td>{{ $item->iteam_hours }}</td>
                    @endif

                    <td>{{ $item->price }}</td>
                </tr>
                @endforeach

                <!-- Empty rows -->
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>

                <!-- Discount, SGST, CGST rows -->
                <tr>
                    <td></td>
                    <td style="font-weight: bold;">Discount ({{ round($discountPercentage, 2) }}%)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-weight: bold;">{{ $invoice->discount }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;">SGST ({{ round($sgstPercentage, 2) }}%)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-weight: bold;">{{ $invoice->sgst }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-weight: bold;">CGST ({{ round($cgstPercentage, 2) }}%)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-weight: bold;">{{ $invoice->cgst }}</td>
                </tr>

                <!-- Footer row -->
                <tr>
                    <td></td>
                    <td><strong>Payable Amount</strong></td>
                    <td style="font-weight: bold;">{{ $invoice->subtotal }}</td>
                    <td style="font-weight: bold;">{{ $invoice->subtotal }}</td>
                    <td style="font-weight: bold;">{{ $invoice->subtotal }}</td>
                    <td style="font-weight: bold;">{{ $invoice->subtotal }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Footer Section -->
        <div class="invoice-footer">
            <div class="footer">
                <h1>THANK YOU!</h1>
                <p>
                    <strong>+91 89801 84903</strong>
                    <strong>placecode3015@gmail.com</strong>
                    <strong>www.placecodesolution.com</strong>
                </p>
            </div>            
            <table class="total-amount">
                <thead>
                    <tr>
                        <td style="font-weight: bold;">Total:
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
            
        </div>

        <!-- Signature -->
        <div class="footer-signature">
            <p><strong></strong> ______________________________________ </p>
        </div>

    </div>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>



    <!-- Ensure jQuery is loaded first -->

