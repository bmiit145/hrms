@extends('team_head.team_head_layout.sidebar')
@section('content')
    <style>
        /* Reset margins for html and body */
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            /* Prevent scrolling */
        }

        .attendance-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #f4f5fa;
            padding: 0;
            /* Ensure no extra padding */
            text-align: center;
            box-sizing: border-box;
            /* Include padding in size calculations */
            margin-top: auto;
            margin-bottom: auto;
        }

        .user-name {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0 0 10px 0;
            /* Ensure no extra top margin */
        }

        .user-image {
            width: 250px;
            height: 250px;
            border-radius: 20%;
            border: 3px solid #36a50b;
            object-fit: cover;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .attendance-status {
            font-size: 1.3rem;
            font-weight: bold;
            margin: 0 0 15px 0;
            /* Ensure no extra top margin */
        }

        .attendance-status.present {
            color: green;
        }

        .attendance-status.absent {
            color: red;
        }

        .motivational-message {
            font-size: 0.9rem;
            margin: 0 0 15px 0;
            /* Ensure no extra top margin */
            color: #6c757d;
        }

        .attendance-link {
            font-size: 1rem;
            color: #007bff;
            text-decoration: none;
        }

        .attendance-link:hover {
            text-decoration: underline;
        }

        body.dark-mode .attendance-container {
            background-color: #28243d !important;
        }

        .user-image.present {
            border: 3px solid #36a50b;
        }
        .user-image.absent {
            border: 3px solid red;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>


    <div class="attendance-container">
        <!-- User's Name -->
        <div class="user-name">
            Hello, {{ auth()->user()->emo_name ?? 'User' }}
        </div>

        @php
            $today = \Carbon\Carbon::now()->toDateString();
            $attendance = $data->where('is_delete',0)->firstWhere('today_date', $today);
        @endphp
        <!-- User's Image -->
        <img src="{{ auth()->user()->profile_image && file_exists(public_path('profile_image/' . auth()->user()->profile_image))
            ? asset('profile_image/' . auth()->user()->profile_image)
            : asset('assets/img/avatars/3.png') }}"
            alt="User Image" class="user-image {{ $attendance && $attendance->status == 1 ? 'present' : 'absent' }}">

        <!-- Attendance Status -->
        
        <div class="attendance-status {{ $attendance && $attendance->status == 1 ? 'present' : 'absent' }}">
            @if ($attendance && $attendance->status == 1)
                Today Are You Present {{ auth()->user()->emo_name ?? 'User' }} Team Head
            @else
                Today Are You Absent {{ auth()->user()->emo_name ?? 'User' }} Team Head
            @endif
        </div>

        <!-- Motivational Message -->
        <div class="motivational-message">
            @if ($attendance && $attendance->status == 1)
                Great to see you at work today! Have a productive day!
            @else
                Hope to see you soon! Stay positive and keep shining!
            @endif
        </div>

        <!-- Navigation Link -->
        <a href="{{ route('teamHead.teamHead_attendance_sheet') }}" class="attendance-link">
            View Full Attendance Sheet
        </a>
    </div>
@endsection
