<!DOCTYPE html>
<html>
<head>
    <title>Leave Request</title>
    <style>
        /* .light {
            color: #000000; 
            font-weight: bold;
        } */
    </style>
</head>
<body>
    <p>Dear <span class="highlight"><b>Sir/Maam</b></span></p>

    <p>I hope you are doing well. I would like to request a leave from <span class="light"><b>{{ $data['fromDate'] }}</b></span> to <span class="highlight"><b>{{ $data['toDate'] }}</b></span> due to "<span class="highlight"><b>{{ $data['leaveReason'] }}</b></span>".</p>

    <p>I kindly request you to grant me leave for the mentioned period. I will ensure that my tasks are managed and completed before my leave or will make proper arrangements for any pending work.</p>

    <p>Thank you for considering my application.</p>

    <p>Sincerely,</p>
    <p><span class="light"><b>{{ $data['userName'] }}</b></span></p>
    <p><span class="light"><b>{{ $data['departmentName'] }}</b></span></p>
    <p><span class="light"><b>{{ $data['contactNumber'] }}</b></span></p>
</body>
</html>
