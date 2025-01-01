@extends('team_head.team_head_layout.sidebar')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        #birthday {
            background-image: url(../assets/img/backgrounds/happy-birthday.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            text-align: center;
            margin-top: 30px;
        }

        div#birthday img {
            width: 300px !important;
            height: 320px;
            object-fit: cover;
            margin: 50px;
        }

        #upcoming-birthday {
            background-image: url(../assets/img/backgrounds/happy-birthday.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            text-align: center;
            margin-top: 30px;
        }

        div#upcoming-birthday img {
            width: 320px !important;
            height: 390px;
            object-fit: cover;
            margin: auto;
        }

        body {
            /* font-family: Arial, sans-serif; */
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px 0;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-top-3 {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }


        .card h3 {
            margin-bottom: 0;
            line-height: 1;
            width: 40%
        }

        .chart-container {
            position: relative;
            height: 200px;
            width: 100%;
        }

        .card_head {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            gap: 0;
            justify-content: space-between;
        }

        .filters label {
            font-size: 14px;
            line-height: 1;
            color: #000;
        }

        .filters select {
            border: none;
            padding: 2%;
            font-size: 12px;
            cursor: pointer;
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
            color: white;
            border-radius: 100px;
            width: auto;
        }

        option {
            color: black;
        }


        /* Responsive Styles */
        @media (max-width: 1200px) {
            .dashboard {
                grid-template-columns: repeat(2, 1fr);
                /* 2 columns for medium screens */
            }
        }

        @media (max-width: 768px) {
            .dashboard {
                grid-template-columns: 1fr;
                /* Stack in 1 column for smaller screens */
            }

            .filters {
                display: flex;
                flex-direction: column;
                /* Stack filters vertically */
                gap: 10px;
            }

            .card {
                padding: 15px;
                /* Reduce padding on smaller screens */
            }

            .chart-container {
                height: 150px;
                /* Adjust chart container size for smaller screens */
            }
        }

        body.dark-mode .card {
            background-color: #312D4B !important;
        }

        body.dark-mode h3 {
            color: #aca8c3 !important;
        }

        body.dark-mode .card-top-3 {
            background-color: #312D4B !important;
        }

        body.dark-mode .dark {
            color: #ffff !important;
        }

        body.dark-mode label {
            color: #aca8c3 !important;
        }

        .emoji_icon {
            bottom: -20px;
            height: 160px;
            object-fit: cover;
        }

        .filters {
            width: 60%;
            display: flex;
            align-items: center;
            justify-content: end;
            gap: 5px;
        }

        .style-13::-webkit-scrollbar-track {
              border-radius: 10px;
              background-color: #f1f1f1;
          }

          .style-13::-webkit-scrollbar {
              width: 5px;
              height: 5px;
              background-color: #F5F5F5;
          }

          .style-13::-webkit-scrollbar-thumb {
              border-radius: 10px;
              background-color: #c1c1c1;
          }

          .style-13::-webkit-scrollbar-thumb:hover {
              background-color: #a1a1a1;
          }

          .style-13::-webkit-scrollbar-thumb:active {
              background-color: #8e8e8e;
          }

        body.dark-mode .style-13::-webkit-scrollbar-track {
            background-color: #28243d;
        }

        body.dark-mode .style-13::-webkit-scrollbar {
            background-color: #28243d;
        }

        @media screen and (max-width: 767px) {
            div#upcoming-birthday img {
                height: auto !important;
                object-fit: cover;
                margin: auto;
            }

            div#birthday img {
                margin: auto !important;
            }

            .card {
                height: auto !important;
            }

            div#upcoming-birthday img {
                margin: 0 !important;
            }

            .card-body img {
                width: 100% !important;
            }
        }

        
        .birthday_image{
            width: auto;
            margin-left: 0;
            margin-top: 0px;
            margin: 50px
        }
    </style>

    <div class="container-xxl flex-grow-1">
        {{-- Present Birthdays --}}
        <div class="row">
            <!-- Display today's birthdays -->
            @if ($data->isNotEmpty())
                <!-- Display Today's Birthdays -->
                <h3 style="font-family: cursive; font-size: 35px; color: #333; text-align: left; margin-bottom: 30px;">
                    Today's Birthdays 🎉
                </h3>
                @foreach ($data as $item)
                    <!-- Display Card for Today's Birthday -->
                    <div class="col-12 col-lg-8 mb-4">
                        <div class="card" style="height: 622px;">
                            <div class="row row-bordered g-0">
                                <div class="col-md-8">
                                    <h5 class="card-header m-0 me-2 pb-3" style="font-family: cursive;">
                                        Happy Birthday {{ $item->emo_name }} 🎉
                                    </h5>
                                    <div id="birthday" class="px-2">
                                       @php
                                            $filePath = public_path('profile_image/' . $item->profile_image); // Get full server path
                                        @endphp
                                        @if (!empty($festival->festival_image) && file_exists($filePath))
                                            <img src="{{ asset('profile_image/' . ($item->profile_image ?? 'assets/img/avatars/2.png')) }}"
                                                alt="Profile Image" class="birthday_image">
                                        @else
                                            <img src="{{ asset('assets/img/avatars/2.png') }}" alt="" class="birthday_image">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-body" style="padding:11%">
                                        <div class="text-center">
                                            <h4 style="font-family: cursive;">
                                                Wishing you a happy birthday, a wonderful year and success in all you
                                                do.<br><br>
                                                <div style="color: burlywood;">PlaceCode Family</div>
                                            </h4>
                                            <img src="{{ asset('assets/img/favicon/birthday.gif') }}" alt="chart success"
                                                style="width:115%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- If no today's birthdays, show upcoming birthday -->
                @if ($upcomingBirthdayFirst)
                    <h3 style="font-family: cursive; font-size: 35px; color: #333; text-align: left;">
                        Upcoming Birthday: 🎉
                    </h3>
                    <div class="col-12 col-lg-8 mb-4">
                        <div class="card" style="height: 622px;">
                            <div class="row row-bordered g-0">
                                <div class="col-md-8">
                                    <h5 class="card-header m-0 me-2 pb-3" style="font-family: cursive;">
                                        Upcoming Birthday: {{ $upcomingBirthdayFirst->emo_name }} 🎂
                                    </h5>
                                    <div id="birthday" class="px-2">
                                        @php
                                            $filePath = public_path(
                                                'profile_image/' . $upcomingBirthdayFirst->profile_image,
                                            ); // Get full server path
                                        @endphp
                                        @if (!empty($upcomingBirthdayFirst->profile_image) && file_exists($filePath))
                                            <img src="{{ asset('profile_image/' . ($upcomingBirthdayFirst->profile_image ?? 'assets/img/avatars/2.png')) }}"
                                                alt="Profile Image" class="birthday_image"
                                                style=";">
                                        @else
                                            <img src="{{ asset('assets/img/avatars/2.png') }}" alt="" class="birthday_image">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-body" style="padding:11%">
                                        <div class="text-center">
                                            <h4 style="font-family: cursive;">
                                                Mark your calendars for
                                                {{ Carbon\Carbon::parse($upcomingBirthdayFirst->emp_birthday_date)->format('F d') }}!<br><br>
                                                <div style="color: burlywood;">PlaceCode Family</div>
                                            </h4>
                                            <img src="{{ asset('assets/img/favicon/birthday.gif') }}" alt="chart success"
                                                style="width:115%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p>No upcoming birthdays in the next 12 months.</p>
                @endif
            @endif

            <!-- 4-Column Value Card -->
            <div class="col-12 col-lg-4 mb-4">
                <div class="card scrollbar style-13" style="height: 622px; overflow-y: auto;">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2"><strong>Employee Leave List</strong></h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                        </div>
                        <hr>
                        <!-- Add the table structure -->
                        <table class="table" style="overflow-y: auto;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Reason</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absentEmployees as $employee)
                                    <tr>
                                        <!-- Profile Image -->
                                        {{-- <td>
                                            @php
                                                $filePath = public_path('profile_image/' . $employee->profile_image); // Get full server path
                                                $defaultImage = asset('assets_old/img/avatars/logo2.png'); // Default image path
                                            @endphp
                                        
                                            @if (!empty($employee->profile_image) && file_exists($filePath))
                                                <img src="{{ asset('profile_image/' . $employee->profile_image) }}" 
                                                     alt="profile_image" 
                                                     height="30px" 
                                                     width="30px" 
                                                     style="cursor: pointer;" 
                                                     class="festival-image" 
                                                     data-bs-toggle="modal" 
                                                     data-bs-target="#festivalModal" 
                                                     data-image="{{ asset('profile_image/' . $employee->profile_image) }}">
                                            @else
                                                <img src="{{ $defaultImage }}" 
                                                     alt="default_image" 
                                                     height="30px" 
                                                     width="30px" 
                                                     style="cursor: pointer;" 
                                                     class="festival-image">
                                            @endif
                                        </td>                                         --}}
                                        <!-- Employee Name -->
                                       <td style="overflow-x: auto;white-space: nowrap;">
                                            <h6 class="mb-0" style="font-size: 14px;">{{ $employee->emo_name ?? '' }}
                                            </h6>
                                        </td>
                                        <td style="overflow-x: auto; word-break:break-all;">
                                            <h6 class="mb-0" style="font-size: 14px;">{{ $employee->leave_reason ?? '' }}
                                            </h6>
                                        </td>
                                        <td style="overflow-x: auto;white-space: nowrap;">
                                            <h6 class="mb-0" style="font-size: 14px;">
                                                @if (!empty($employee->from_date))
                                                    {{ \Carbon\Carbon::parse($employee->from_date)->format('d-m-Y') }} <b>TO</b> <br> {{ \Carbon\Carbon::parse($employee->to_date)->format('d-m-Y') }}
                                                @else
                                                    {{ '' }}
                                                @endif
                                            </h6>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Holiday Data-->
            <div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-4">
                <div class="card scrollbar style-13" style="height: 300px; overflow-y: auto;">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2"><strong>Holiday List</strong></h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                        </div>
                        <hr>
                        <ul class="p-0 m-0">
                            @foreach ($getHolidays as $holoday)
                                <li class="d-flex mb-4 pb-1">
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">{{ $holoday->holiday_name ?? '' }}</h6>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-medium">
                                                @isset($holoday->holiday_date)
                                                    {{ \Carbon\Carbon::parse($holoday->holiday_date)->format('d M y') }}
                                                @endisset

                                                @isset($holoday->end_date)
                                                    &nbsp;&nbsp;<b>To</b>&nbsp;&nbsp;
                                                    {{ \Carbon\Carbon::parse($holoday->end_date)->format('d M y') }}
                                                @endisset
                                            </small>
                                        </div>
                                    </div>
                                </li>
                                <hr>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Festival Data -->
            <div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-4">
                <div class="card scrollbar style-13" style="height: 300px; overflow-y: auto;">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2"><strong>Festival List</strong></h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                        </div>
                        <hr>
                        <ul class="p-0 m-0">
                            @foreach ($getFestival as $festival)
                                <li class="d-flex mb-4 pb-1">
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">{{ $festival->fetival_name ?? '' }}</h6>
                                        </div>
                                        <div class="me-2">
                                            @php
                                                $filePath = public_path('festival_image/' . $festival->festival_image); // Get full server path
                                            @endphp
                                            @if (!empty($festival->festival_image) && file_exists($filePath))
                                                <img src="{{ asset('festival_image/' . $festival->festival_image) }}"
                                                    alt="festival_image" height="50" width="50"
                                                    style="cursor: pointer;" class="festival-image" data-bs-toggle="modal"
                                                    data-bs-target="#festivalModal"
                                                    data-image="{{ asset('festival_image/' . $festival->festival_image) }}">
                                            @endif
                                        </div>
                                        <div class="user-progress">
                                            <small
                                                class="fw-medium">{{ \Carbon\Carbon::parse($festival->festival_date)->format('d M y') ?? '' }}</small>
                                        </div>
                                    </div>
                                </li>
                                <hr>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>


        <!-- Modal Structure -->
        <div class="modal fade" id="festivalModal" tabindex="-1" aria-labelledby="festivalModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="festivalModalLabel">Festival Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" alt="Festival Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script>
            $('.add-holidays').click(function(event) {
                // Prevent the default form submission behavior
                event.preventDefault();

                // Construct the new URL with month and year
                var url = "{{ route('admin.holiday') }}";

                // Reload the page with the constructed URL (this ensures the selected month and year stay)
                window.location.href = url;
            });

            $('.add-festival').click(function(event) {
                // Prevent the default form submission behavior
                event.preventDefault();

                // Construct the new URL with month and year
                var url = "{{ route('admin.festival') }}";

                // Reload the page with the constructed URL (this ensures the selected month and year stay)
                window.location.href = url;
            });

            // When an image is clicked, update the modal image source
            document.querySelectorAll('.festival-image').forEach(image => {
                image.addEventListener('click', function() {
                    var fullImageUrl = this.getAttribute('data-image');
                    document.getElementById('modalImage').src = fullImageUrl;
                });
            });
        </script>
    </div>
@endsection
