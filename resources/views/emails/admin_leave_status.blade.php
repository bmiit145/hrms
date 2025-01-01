<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Status Update</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f3f5;
            color: #333;
        }

        .email-container {
            width: 100%;
            background-color: #f2f3f5;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .email-content {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            max-width: 150px;
        }

        .greeting {
            font-size: 18px;
            color: #444;
            margin-bottom: 20px;
        }

        .status {
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            color: white;
        }

        .status.approved {
            background-color: #4caf50;
        }

        .status.rejected {
            background-color: #f44336;
        }

        .message {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        .rejection-reason {
            font-size: 16px;
            color: #f44336;
            background-color: #fff3f3;
            padding: 10px;
            border-left: 5px solid #f44336;
            margin-top: 20px;
        }

        .cta-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }

        .cta-button:hover {
            background-color: #0056b3;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 30px;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-content">

            <!-- Header -->
            <div class="header">
                <img src="{{asset('assets/img/avatars/logo.png')}}" alt="Your Company Logo" style="width:175px;">
                <h2 style="color: #333;">Leave Status Update</h2>
            </div>

            <!-- Greeting -->
            <div class="greeting">
                <p>Hello {{ $leaveData->admin->emo_name }},</p>
                <p>We wanted to notify you about the status of your recent leave request.</p>
            </div>

            <!-- Status Notification -->
            <div class="status">
                @if($leaveData->status == 0)
                    <p class="rejected"><strong>Rejected</strong></p>
                @elseif($leaveData->status == 1)
                    <p class="approved"><strong>Approved</strong></p>
                @endif
                <!-- <p>{{ $leaveData->status }}</p> -->
            </div>

            <!-- Message based on status -->
            <div class="message">
                @if($leaveData->status == 0 && $leaveData->rejected_reason)
                    <p>Unfortunately, your leave request was rejected. Below is the reason for rejection:</p>
                    <div class="rejection-reason">
                        <p><strong>{{ $leaveData->rejected_reason }}</strong></p>
                    </div>
                @elseif($leaveData->status == 1)
                    <p>Good news! Your leave request has been approved. Enjoy your time off!</p>
                @endif
            </div>

            <!-- CTA Button -->
            <a href="{{route('user.leave_request_create')}}" class="cta-button">View Your Leave Request</a>

            <!-- Footer -->
            <div class="footer">
                <p>If you have any questions, please feel free to <a href="mailto:support@example.com">contact us</a>.</p>
                <p>Thank you for your attention.</p>
                <p>Best regards,<br>Place Code</p>
            </div>

        </div>
    </div>
</body>

</html>
