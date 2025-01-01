<div class="container">
    <style>
        .watermark {
            position: absolute;
            top: 36%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 10.5;
            z-index: 100;
            pointer-events: none;
            bottom: 50%;
        }
    
        body {
            margin: 0;
            padding: 0;
        }
    
        .container {
            width: 210mm;
        min-height: 293mm;
        margin: auto;
        padding: 20mm;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        background: #fff;
        position: relative;
    
        }
    
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
    
        .header img {
            max-width: 250px;
        }
    
        .company-info {
            text-align: right;
        }
    
        .company-info h4 {
            margin: 0;
            font-size: 18px;
        }
    
        .company-info p {
            margin: 5px 0;
            font-size: 14px;
        }
    
        .salary-slip {
            width: 100%;
            height: 59%;
            border-collapse: collapse;
            background-color: white;
            font-family: "Inter", sans-serif;
        }
    
        .salary-slip th,
        .salary-slip td {
            border: 1px solid #b3acac96;
            padding: 10px;
            text-align: center;
            /* Center all text */
            font-size: 16px;
            width: 5%;
            height: 8%;
        }
    
        .salary-slip td {
            height: 10%;
        }
        
        .salary-slip th {
            background-color: #ECEAEA;
            font-weight: bold;
        }
    
        .section-header {
            background-color: #ECEAEA;
            font-weight: bold;
            height: 8%;
        }
    
        .footer {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            font-family: "Inter", sans-serif;
                font-weight: 700;
        }
    
        .footer div {
            font-size: 14px;
        }
    
        .hade {
            font-family: "Poppins", serif;
            font-weight: 500;
        }
    
        .address {
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
        }
    
    </style>
    <style>
        @media print {
            @page {
                size: A4; /* Explicitly set the size to A4 */
                margin: 0; /* Remove default browser margins */
            }
            .dt-action-buttons {
                display: none; /* Hide the button during print */
            }
        
        }
    
    </style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    
    </style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    
    </style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    
    </style>
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('assets/img/favicon/Group.png') }}" alt="Company Logo">
            <div class="company-info">
                <h4><strong class="hade">Place Code Solution Pvt. Ltd.</strong></h4>
                <p class="address">323 - Silver Trade Center, near </p>
                <p class="address">Oxygen Park, Opp. GEB Power House,</p>
                <p class="address">Uttran, Surat, Gujarat, India 394105</p><br>
                <p class><strong class="address">P: +91 89801 84903</strong></p>
            </div>
        </div>
        <br><br><br>
        <table class="salary-slip">
            <tr>
                <th colspan="2">Employee Name</th>
                <th>Month & Year</th>
                <th>Department</th>
            </tr>
            <tr>
                <td colspan="2" class="text-center">{{$employee->emo_name}}</td>
                <td class="text-center">{{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}</td>
                <td class="text-center">{{$employee->department->department_name}}</td>
            </tr>
            <tr>
                <th>Designation</th>
                <th>Payable Days</th>
                <th>Leaves Days</th>
                <th>Paid Leave</th>
            </tr>
            <tr>
                <td class="text-center">
                    @if($employee->role == 1)
                    Team Head
                    @elseif($employee->role == 2)
                    Employee
                    @elseif($employee->role == 3)
                    HR
                    @endif
                </td>
                <td class="text-center">{{$totalAttendance}}</td>
                <td class="text-center">{{$leave_days}}</td>
                <td class="text-center">{{$paid_leav}}</td>
            </tr>
            <tr>
                <th>Benefits</th>
                <th>Over Time</th>
                <th>Paid Leave</th>
                <th>Total Earnings</th>
            </tr>
            <tr>
                <td class="text-center">{{$Benefits}}</td>
                <td class="text-center">{{$overtime + $plus}}</td>
                <td class="text-center">{{$paid_leav}}</td>
                <td class="text-center">{{$employee->monthly_selery +  $overtime + $Benefits + $plus}}</td>
            </tr>
            <tr>
                <th>Deduction</th>
                <th>Tax</th>
                <th>Late Mark</th>
                <th>Total Deduction</th>
            </tr>
            <tr>
                <td class="text-center">{{ number_format($deduction, 0) }}</td>
                <td class="text-center">0</td>
                <td class="text-center">{{$adjustment->amont ?? '0'}}</td>
                <td class="text-center">{{ number_format(($deduction ?? 0) + ($adjustment->amont ?? 0), 0) }}</td>
    
            </tr>
            <tr>
                <th>Bank A/C No</th>
                <th>Bank Name</th>
                <th>Total Salary</th>
                <th>Net Payable</th>
            </tr>
            <tr>
                <td class="text-center">{{$employee->bank_no}}</td>
                <td class="text-center">{{$employee->bank_name}}</td>
                <td class="text-center">{{$employee->monthly_selery}}</td>
                <?php
              // Calculate total earnings
              $total_earnings = $employee->monthly_selery + $overtime + $Benefits + $plus;
    
              // Safely access $adjustment->amont
              $adjustmentAmount = isset($adjustment) ? $adjustment->amont : 0;
    
              // Calculate total deduction
              $total_deduction = $deduction + $adjustmentAmount;
          ?>
                <td class="text-center">{{ number_format(($total_earnings) - ($total_deduction), 0) }}</td>
            </tr>
        </table>
        <br><br><br><br>
        <!-- Footer -->
        <div class="footer">
            <div>
                <strong>Authorised Signature :</strong> _________________________
            </div>
            <div>
                <strong>Employee Signature :</strong> _________________________
            </div>
        </div>
    </div>