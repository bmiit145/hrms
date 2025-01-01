<!DOCTYPE html>
<html>
<head>
    <title>Leave Request Status</title>
</head>
<body>
    <p>Dear <b>{{ $data['userName'] }}</b>,</p>

    @if($data['status'] == 'Approved')
        <p>Congratulations! Your leave request from <b>{{ $data['fromDate'] }}</b> to <b>{{ $data['toDate'] }}</b> has been <b>approved</b>.</p>
        <p>Approved by Team Head: <b>{{ auth()->user()->name }}</b></p>
    @elseif($data['status'] == 'Rejected')
        <p>We regret to inform you that your leave request from <b>{{ $data['fromDate'] }}</b> to <b>{{ $data['toDate'] }}</b> has been <b>rejected</b>.</p>
        <p>Reason for rejection: <b>{{ $data['rejectedReason'] }}</b></p>
    @endif

    <p>Thank you,<br>Team Management</p>
</body>
</html>
