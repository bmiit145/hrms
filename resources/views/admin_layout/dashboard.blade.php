  @extends('admin_layout.sidebar')
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
              /* display: grid; */
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
              height: 350px;
              width: 400px;
          }

          .card_head {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            justify-content: space-between;
            font-size: 15px; /* Increase font size */
            padding: 15px; /* Add padding for larger size */
        }

          .filters label {
              font-size: 14px;
              line-height: 1;
              color: #000;
          }

          .filters select {
              padding: 10px 10px;
              cursor: pointer;
              background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
              color: white;
              border-radius: 100px;
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
                display: flex;
                align-items: center;
                justify-content: space-around;
                flex-wrap: nowrap;
                align-content: center;
                flex-direction: row;

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

          .close_btn {
              display: flex;
              justify-content: end;
          }

          body.dark-mode option {
              background: #312d4b !important;
              color: #d5d1ea !important;
          }
          .birthday_image{
                width: auto;
                margin-left: 0;
                margin-top: 0px;
                margin: 50px
          }
          @media screen and (max-width: 767px) {
            div#upcoming-birthday img {
                width: auto !important;
                height: auto !important;
                object-fit: cover;
                margin: auto;
            }
            div#birthday img {
                   margin: auto;
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
      </style>

      <div class="container-xxl flex-grow-1">
          @php
              $getCloseCardDate = App\Models\CardColse::first();

              $today = \Carbon\Carbon::today()->format('Y-m-d');

              $isCloseDateToday = $getCloseCardDate && $getCloseCardDate->close_date == $today;
          @endphp
          @if ($isCloseDateToday != null)
              <!-- Show the restore button if the close date is today -->
              <div class="close_btn">
                  <a href="{{ route('admin.restore.card') }}"
                      style="width: 40px; background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;"
                      type="button" class="btn btn-danger">
                      <i class="ri-reset-left-line"></i>
                  </a>
              </div>
          @else
              <!-- Show the close button if the close date is not today -->
              <div class="close_btn">
                  <a href="{{ route('admin.close.card') }}"
                      style="width: 40px; background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;"
                      type="button" class="btn btn-danger">
                      <i class="ri-close-line text-white text-center"></i>
                  </a>
              </div>
          @endif

          <!-- Today Birthday And Upcoming Birthday -->
          @if (!$isCloseDateToday)
              <div class="row mt-2">
                  <!-- Display today's birthdays -->
                  @if ($data->isNotEmpty())
                      <!-- Display Today's Birthdays -->
                      <div class="card_head">
                          <h3
                              style="font-family: cursive; font-size: 35px; color: #333; text-align: left; margin-bottom: 0px;">
                              Today's Birthdays 🎉
                          </h3>
                          {{-- <a href="{{ route('admin.close.card') }}"
                              style="width: 40px;background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;"
                              type="button" class="btn btn-danger"><i class="ri-close-line text-white text-center"></i></a> --}}
                      </div>
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
                                                  <img src="{{ asset('assets/img/favicon/birthday.gif') }}"
                                                      alt="chart success" style="width:115%">
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
                                                  <img src="{{ asset('assets/img/favicon/birthday.gif') }}"
                                                      alt="chart success" style="width:115%">
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      @else
                          <div class="col-12 col-lg-8 mb-4">
                              <div class="card" style="height: 622px;">
                                  <div class="row row-bordered g-0">
                                      <img src="{{ asset('assets/img/no_upcoming_birthday.png') }}"
                                          style="width: 500px;margin: auto;" height="500" alt="">
                                  </div>
                              </div>
                          </div>
                      @endif
                  @endif

                  <!-- 4-Column Value Card -->
                  <div class="col-12 col-lg-4 mb-4">
                      <div class="card scrollbar style-13" style="height: 300px; overflow-y: auto;">
                          <div class="card-header d-flex align-items-center justify-content-between pb-0">
                              <div class="card-title mb-0">
                                  <h5 class="m-0 me-2"><strong>Holiday List</strong></h5>
                              </div>
                              <button class="add-holidays"
                                  style="    background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: white;border-radius: 10%;width: 12%;height: 36px;border: none;">
                                  <i class="ri-add-line"></i>
                              </button>
                          </div>
                          <div class="card-body">
                              <div class="d-flex justify-content-between align-items-center mb-3">
                              </div>
                              <hr>
                              <ul class="p-0 m-0">
                                  @foreach ($getHolidays as $holoday)
                                      <li class="d-flex mb-4 pb-1">
                                          <div
                                              class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
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

                      <div class="card mt-5 scrollbar style-13" style="height: 300px; overflow-y: auto;">
                          <div class="card-header d-flex align-items-center justify-content-between pb-0">
                              <div class="card-title mb-0">
                                  <h5 class="m-0 me-2"><strong>Festival List</strong></h5>
                              </div>
                              <button class="add-festival"
                                  style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: white;border-radius: 10%;width: 12%;height: 36px;border: none;">
                                  <i class="ri-add-line"></i>
                              </button>
                          </div>
                          <div class="card-body">
                              <div class="d-flex justify-content-between align-items-center mb-3">
                              </div>
                              <hr>
                              <ul class="p-0 m-0">
                                  @foreach ($getFestival as $festival)
                                      <li class="d-flex mb-4 pb-1">
                                          <div
                                              class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                              <div class="fetival_name_info me-2" style="width: 33.33%;">
                                                  <h6 class="mb-0">{{ $festival->fetival_name ?? '' }}</h6>
                                              </div>
                                              <div class="festival_image_info me-2" style="width: 33.33%;">
                                                  @php
                                                      $filePath = public_path(
                                                          'festival_image/' . $festival->festival_image,
                                                      ); // Get full server path
                                                  @endphp
                                                  @if (!empty($festival->festival_image) && file_exists($filePath))
                                                      <img src="{{ asset('festival_image/' . $festival->festival_image) }}"
                                                          alt="festival_image" height="50" width="50"
                                                          style="cursor: pointer;" class="festival-image"
                                                          data-bs-toggle="modal" data-bs-target="#festivalModal"
                                                          data-image="{{ asset('festival_image/' . $festival->festival_image) }}">
                                                  @else
                                                      <img src="{{ asset('assets/img/default_festival_image.jpg') }}"
                                                          alt="festival_image" height="50" width="50"
                                                          style="cursor: pointer;" class="festival-image"
                                                          data-bs-toggle="modal" data-bs-target="#festivalModal"
                                                          data-image="{{ asset('assets/img/default_festival_image.jpg') }}">
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
          @endif

          <div class="row g-6 mt-3">
              <div class="col-xxl-4 col-sm-6">
                  <div class="card-top-3">
                      <a href="{{ route('admin.employee') }}">
                          <div class="row">
                              <div class="col-6">
                                  <div class="card-body">
                                      <div class="card-info">
                                          <h6 class="mb-4 pb-1 text-nowrap">Total Employee</h6>
                                          <div class="d-flex align-items-center mb-3">
                                              <h4 class="mb-0 me-2">{{ $totalEmployee ?? '0' }}</h4>
                                              {{-- <p class="text-success mb-0">+15.6%</p> --}}
                                          </div>
                                          {{-- <div class="badge bg-label-primary rounded-pill mb-xl-1">Year of 2021</div> --}}
                                      </div>
                                  </div>
                              </div>
                              <div class="col-6">
                                  <div class="h-100 position-relative">
                                      <img src="{{ asset('assets/img/illustrations/test.png') }}" alt="Ratings"
                                          class="emoji_icon  position-absolute card-img-position scaleX-n1-rtl  w-auto end-0 ">
                                  </div>
                              </div>
                          </div>
                      </a>
                  </div>
              </div>
              <div class="col-xxl-4 col-sm-6">
                  <div class="card-top-3">
                      <a href="{{ route('admin.Client_view') }}">
                          <div class="row">
                              <div class="col-6">
                                  <div class="card-body">
                                      <div class="card-info">
                                          <h6 class="mb-4 pb-1 text-nowrap">Total Client</h6>
                                          <div class="d-flex align-items-center mb-3">
                                              <h4 class="mb-0 me-2">{{ $totalClient ?? '0' }}</h4>
                                              {{-- <p class="text-success mb-0">+15.6%</p> --}}
                                          </div>
                                          {{-- <div class="badge bg-label-primary rounded-pill mb-xl-1">Year of 2021</div> --}}
                                      </div>
                                  </div>
                              </div>
                              <div class="col-6">
                                  <div class="h-100 position-relative">
                                      <img src="{{ asset('assets/img/illustrations/test.png') }}" alt="Ratings"
                                          class="emoji_icon  position-absolute card-img-position scaleX-n1-rtl  w-auto end-0 ">
                                  </div>
                              </div>
                          </div>
                      </a>
                  </div>
              </div>
              <div class="col-xxl-4 col-sm-6">
                  <div class="card-top-3">
                      <a href="{{ route('admin.project') }}">
                          <div class="row">
                              <div class="col-6">
                                  <div class="card-body">
                                      <div class="card-info">
                                          <h6 class="mb-4 pb-1 text-nowrap">Total Project</h6>
                                          <div class="d-flex align-items-center mb-3">
                                              <h4 class="mb-0 me-2">{{ $totalProject ?? '' }}</h4>
                                              {{-- <p class="text-success mb-0">+15.6%</p> --}}
                                          </div>
                                          {{-- <div class="badge bg-label-primary rounded-pill mb-xl-1">Year of 2021</div> --}}
                                      </div>
                                  </div>
                              </div>
                              <div class="col-6">
                                  <div class="h-100 position-relative">
                                      <img src="{{ asset('assets/img/illustrations/test.png') }}" alt="Ratings"
                                          class="emoji_icon  position-absolute card-img-position scaleX-n1-rtl  w-auto end-0 ">
                                  </div>
                              </div>
                          </div>
                      </a>
                  </div>
              </div>
          </div>

          <div class="dashboard">
              <div class="main-card row g-6 mt-3">
                  <!-- Sales Chart -->
                  <div class="col-xxl-4 col-sm-6">
                      <div class="card">
                          <div class="card_head">
                              Sales
                              <div class="filters">
                                  <select id="month" class="dark">
                                      @foreach (range(1, 12) as $month)
                                          <option value="{{ $month }}"
                                              {{ $month == now()->month ? 'selected' : '' }}>
                                              {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                          </option>
                                      @endforeach
                                  </select>
                                  <select id="year" class="dark">
                                      @foreach (range(2024, now()->year) as $year)
                                          <option value="{{ $year }}"
                                              {{ $year == now()->year ? 'selected' : '' }}>
                                              {{ $year }}
                                          </option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <!-- Total Earnings Display -->
                          <div id="totalEarnings" style="font-size: 16px; font-weight: bold;">₹ <span
                                  id="totalEarningsValue">0</span>
                          </div>
                          <div class="chart-container">
                              <canvas id="salesChart" style="display: block;box-sizing: border-box;width: 100%;margin-top: 19%;margin-left: -2%;"></canvas>
                          </div>
                      </div>
                  </div>

                  <!-- Sales Profit Chart -->
                  <div class="col-xxl-4 col-sm-6">
                      <div class="card">
                          <div class="card_head">
                              Sales Profit
                              <div class="filters">
                                  <select id="profitYear" class="dark">
                                      @foreach (range(2024, now()->year) as $year)
                                          <option value="{{ $year }}"
                                              {{ $year == now()->year ? 'selected' : '' }}>
                                              {{ $year }}
                                          </option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <!-- Total Earnings Display -->
                          <div id="totalProfit" style="font-size: 16px; font-weight: bold;">₹ <span
                                  id="totalProfitValue">0</span>
                          </div>
                          <div class="chart-container">
                              <canvas id="profitChart" style="display: block;box-sizing: border-box;width: 100%;margin-top: 19%;margin-left: -2%;height: 250px;"></canvas>
                          </div>
                      </div>
                  </div>

                  <!-- Income Chart -->
                  <div class="col-xxl-4 col-sm-6">
                      <div class="card">
                          <div class="card_head">
                              Income
                              <div class="filters">
                                  <select id="incomeMonth" class="dark">
                                      @foreach (range(1, 12) as $month)
                                          <option value="{{ $month }}"
                                              {{ $month == now()->month ? 'selected' : '' }}>
                                              {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                          </option>
                                      @endforeach
                                  </select>
                                  <select id="incomeYear" class="dark">
                                      @foreach (range(2024, now()->year) as $year)
                                          <option value="{{ $year }}"
                                              {{ $year == now()->year ? 'selected' : '' }}>
                                              {{ $year }}
                                          </option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <!-- Total Earnings Display -->
                          <div id="totalIncome" style="font-size: 16px; font-weight: bold;">₹ <span
                                  id="totalIncomeValue">0</span>
                          </div>
                          <div class="chart-container">
                              <canvas id="incomeChart"></canvas>
                          </div>
                      </div>
                  </div>

                  <!-- Expense Chart -->
                  <div class="col-xxl-4 col-sm-6">
                      <div class="card">
                          <div class="card_head">
                              Expenses
                              <div class="filters">
                                  <select id="expensesMonth" class="dark">
                                      @foreach (range(1, 12) as $month)
                                          <option value="{{ $month }}"
                                              {{ $month == now()->month ? 'selected' : '' }}>
                                              {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                          </option>
                                      @endforeach
                                  </select>
                                  <select id="expensesYear" class="dark">
                                      @foreach (range(2024, now()->year) as $year)
                                          <option value="{{ $year }}"
                                              {{ $year == now()->year ? 'selected' : '' }}>
                                              {{ $year }}
                                          </option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <!-- Total Earnings Display -->
                          <div id="totalExpenses" style="font-size: 16px; font-weight: bold;">₹ <span
                                  id="totalExpensesValue">0</span>
                          </div>
                          <div class="chart-container">
                              <canvas id="expenseChart"></canvas>
                          </div>
                      </div>
                  </div>

                  <!-- Receivable Payable Chart -->
                  <div class="col-xxl-4 col-sm-6">
                      <div class="card">
                          <div class="card_head">
                              Receivable 
                              <div class="filters">
                                  <select id="ReceivableMonth" class="dark">
                                      @foreach (range(1, 12) as $month)
                                          <option value="{{ $month }}"
                                              {{ $month == now()->month ? 'selected' : '' }}>
                                              {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                          </option>
                                      @endforeach
                                  </select>
                                  <select id="ReceivableYear" class="dark">
                                      @foreach (range(2024, now()->year) as $year)
                                          <option value="{{ $year }}"
                                              {{ $year == now()->year ? 'selected' : '' }}>
                                              {{ $year }}
                                          </option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>

                          <!-- Total Earnings Display -->
                          <div id="totalReceivablePayable" style="font-size: 16px; font-weight: bold;">₹ <span
                                  id="totalReceivablePayableValue">0</span></div>

                          <div class="chart-container">
                              <canvas id="receivablePayableChart" style="display: block;box-sizing: border-box;width: 100%;margin-top: 19%;margin-left: -2%; height: 250px;"></canvas>
                          </div>
                      </div>
                  </div>

                  <!-- Pending Payable Chart -->
                  <div class="col-xxl-4 col-sm-6">
                      <div class="card">
                          <div class="card_head">
                              Pending 
                              <div class="filters">
                                  <select id="PendingPayableMonth" class="dark">
                                      @foreach (range(1, 12) as $month)
                                          <option value="{{ $month }}"
                                              {{ $month == now()->month ? 'selected' : '' }}>
                                              {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                          </option>
                                      @endforeach
                                  </select>
                                  <select id="PendingPayableYear" class="dark">
                                      @foreach (range(2024, now()->year) as $year)
                                          <option value="{{ $year }}"
                                              {{ $year == now()->year ? 'selected' : '' }}>
                                              {{ $year }}
                                          </option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>

                          <!-- Total Earnings Display -->
                          <div id="totalPendingPayableYear" style="font-size: 16px; font-weight: bold;">₹ <span
                                  id="totalPendingPayableYearValue">0</span></div>

                          <div class="chart-container">
                              <canvas id="PendingPayableYearChart" style="display: block;box-sizing: border-box;width: 100%;margin-top: 12%;margin-left: -2%; height: 250px;"></canvas>
                          </div>
                      </div>
                  </div>

                  <!-- Profit & Loss Chart -->
                  <div class="col-xxl-4 col-sm-6">
                      <div class="card">
                          <div class="card_head">
                              Profit & Loss
                              <div class="filters">
                                  <select id="profitLossYear" class="dark">
                                      @foreach (range(2024, now()->year) as $year)
                                          <option value="{{ $year }}"
                                              {{ $year == now()->year ? 'selected' : '' }}>
                                              {{ $year }}
                                          </option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>

                          <!-- Total Earnings Display -->
                          <div id="totalProfitChartYear" style="font-size: 16px; font-weight: bold;">Profit : ₹ <span
                                  id="totalProfitChartValue">0</span></div>

                          <div class="chart-container">
                              <canvas id="profitLossChart" style="display: block;box-sizing: border-box;width: 100%;margin-top: 19%;margin-left: -2%;"></canvas>
                          </div>
                      </div>
                  </div>

                  <!-- Employee Leave List -->
                  <div class="col-xxl-8 col-sm-6" >
                      <div class="card h-100 scrollbar style-13" style="max-height: 335px; overflow-y: auto;">
                          <div class="card-header d-flex align-items-center justify-content-between pb-0">
                              <div class="card-title mb-0">
                                  <h5 class="m-0 me-2"><strong>Employee Leave List</strong></h5>
                              </div>
                          </div>
                          <div class="card-body">
                              <div class="d-flex justify-content-between align-items-center mb-3"></div>
                              <hr>
                              <!-- Table Structure -->
                              <table class="table" style="width: 100%; white-space: nowrap;">
                                  <thead>
                                      <tr>
                                          <th>Image</th>
                                          <th>Name</th>
                                          <th>Reason</th>
                                          <th>From Date</th>
                                          <th>To Date</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($absentEmployees as $employee)
                                          <tr>
                                              <td class="text-center">
                                                  @php $filePath = public_path('profile_image/' . $employee->profile_image); @endphp
                                                  <img src="{{ !empty($employee->profile_image) && file_exists($filePath) ? asset('profile_image/' . $employee->profile_image) : asset('assets/img/avatars/2.png') }}"
                                                      alt="profile_image" class="img-fluid rounded-circle" height="50"
                                                      width="50">
                                              </td>
                                              <td class="text-center"><span
                                                      class="font-size-14">{{ $employee->emo_name ?? 'N/A' }}</span></td>
                                              <td class="text-center"><span
                                                      class="font-size-14">{{ $employee->leave_reason ?? '-' }}</span>
                                              </td>
                                              <td class="text-center"><span
                                                      class="font-size-14">{{ \Carbon\Carbon::parse($employee->from_date)->format('m-d-Y') ?? '-' }}</span>
                                              </td>
                                              <td class="text-center"><span
                                                      class="font-size-14">{{ \Carbon\Carbon::parse($employee->to_date)->format('m-d-Y') ?? '-' }}</span>
                                              </td>
                                          </tr>
                                      @endforeach

                                      @if ($absentEmployees->isEmpty())
                                          <tr>
                                              <td colspan="5" class="text-center">No Employees on Leave</td>
                                          </tr>
                                      @endif
                                  </tbody>
                              </table>
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
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                  aria-label="Close"></button>
                          </div>
                          <div class="modal-body text-center">
                              <img id="modalImage" src="" alt="Festival Image" class="img-fluid">
                          </div>
                      </div>
                  </div>
              </div>

              <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

              <script>
                  // Sales chart
                  const initialData = @json($salesChart);



                  function renderChart(labels, data, isDarkMode) {
                    const ctx = document.getElementById('salesChart').getContext('2d');

                    if (window.salesChartInstance) {
                        window.salesChartInstance.destroy(); // Destroy the previous instance
                    }

                    // Calculate minimum and maximum values for Y-axis
                    const minDataValue = Math.min(...data);
                    const maxDataValue = Math.max(...data);
                    const range = maxDataValue - minDataValue;
                    const stepSize = Math.ceil(range / 15); // Divide range into 15 steps

                    // Ensure max and min values align with the step size
                    const adjustedMinValue = Math.floor(minDataValue / stepSize) * stepSize;
                    const adjustedMaxValue = Math.ceil(maxDataValue / stepSize) * stepSize;

                    window.salesChartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Earnings',
                                data: data,
                                backgroundColor: isDarkMode ? 'rgba(75, 192, 192, 0.6)' : 'rgba(75, 192, 192, 0.1)', // Light color
                                borderColor: isDarkMode ? 'rgba(75, 192, 192, 1)' : 'rgba(75, 192, 192, 1)', // Border color
                                borderWidth: 2,
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: false, // Allow values below 0 if minDataValue < 0
                                    min: adjustedMinValue, // Dynamically set min value
                                    max: adjustedMaxValue, // Dynamically set max value
                                    ticks: {
                                        stepSize: stepSize, // Ensure 15 steps
                                        color: isDarkMode ? '#aca8c3' : 'black', // Adjust ticks color
                                    },
                                    title: {
                                        display: true,
                                        text: 'Earnings (₹)',
                                        color: isDarkMode ? '#aca8c3' : 'black', // Adjust text color
                                    },
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Time Period',
                                        color: isDarkMode ? '#aca8c3' : 'black', // Adjust text color
                                    },
                                    ticks: {
                                        color: isDarkMode ? '#aca8c3' : 'black', // Adjust ticks color
                                    },
                                }
                            },
                            plugins: {
                                legend: {
                                    labels: {
                                        color: isDarkMode ? '#aca8c3' : 'black', // Change legend label color
                                    }
                                }
                            }
                        }
                    });

                    // Update total earnings display
                    const totalEarnings = data.reduce((sum, value) => sum + value, 0); // Sum up earnings
                    document.getElementById('totalEarningsValue').innerText = totalEarnings.toLocaleString();
                }

                  // Extract initial data
                  const initialLabels = initialData.map(item => item.date_range);
                  const initialValues = initialData.map(item => item.total_earning);

                  document.addEventListener('DOMContentLoaded', function() {
                      // Now, we know the DOM is fully loaded and ready
                      const isDarkMode = document.body.classList.contains('dark-mode');
                      renderChart(initialLabels, initialValues, isDarkMode);
                  });


                  // Handle filter change
                  $('#month, #year').on('change', function() {
                      const selectedMonth = $('#month').val();
                      const selectedYear = $('#year').val();

                      // AJAX request to fetch filtered data
                      $.ajax({
                          url: '{{ route('getSalesChartData') }}',
                          method: 'GET',
                          data: {
                              month: selectedMonth,
                              year: selectedYear
                          },
                          success: function(data) {
                              const labels = data.map(item => item.date_range);
                              const values = data.map(item => item.total_earning);

                              // Update the chart with new data
                              renderChart(labels, values);
                          }
                      });
                  });

                  // Sales Profit chart

                  const profitCtx = document.getElementById('profitChart').getContext('2d');
                  let profitChartInstance;

                  // Function to render the chart
                  function renderProfitChart(labels, data, isDarkMode) {
                    if (profitChartInstance) {
                        profitChartInstance.destroy(); // Destroy previous instance
                    }

                    // Calculate minimum and maximum values for Y-axis
                    const minDataValue = Math.min(...data);
                    const maxDataValue = Math.max(...data);
                    const range = maxDataValue - minDataValue;
                    const stepSize = Math.ceil(range / 15); // Divide range into 15 steps

                    // Ensure max and min values align with the step size
                    const adjustedMinValue = Math.floor(minDataValue / stepSize) * stepSize;
                    const adjustedMaxValue = Math.ceil(maxDataValue / stepSize) * stepSize;

                    profitChartInstance = new Chart(profitCtx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Profit',
                                data: data,
                                backgroundColor: isDarkMode ? 'rgba(102, 187, 106, 0.2)' : 'rgba(102, 187, 106, 0.1)', // Light color for dark mode
                                borderColor: isDarkMode ? '#66bb6a' : '#4caf50', // Adjust border color
                                borderWidth: 2,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: false, // Allow values below 0 if minDataValue < 0
                                    min: adjustedMinValue, // Dynamically set min value
                                    max: adjustedMaxValue, // Dynamically set max value
                                    ticks: {
                                        stepSize: stepSize, // Ensure 15 steps
                                        color: isDarkMode ? '#aca8c3' : 'black' // Adjust Y-axis ticks color
                                    },
                                    title: {
                                        display: true,
                                        text: 'Profit (₹)',
                                        color: isDarkMode ? '#aca8c3' : 'black' // Adjust Y-axis title color
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Time Period',
                                        color: isDarkMode ? '#aca8c3' : 'black' // Adjust X-axis title color
                                    },
                                    ticks: {
                                        color: isDarkMode ? '#aca8c3' : 'black' // Adjust X-axis ticks color
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return `₹${context.raw.toLocaleString()}`;
                                        }
                                    }
                                },
                                legend: {
                                    labels: {
                                        color: isDarkMode ? '#aca8c3' : 'black' // Change the color of the label (Profit)
                                    }
                                }
                            }
                        }
                    });
                }



                  // Function to calculate and display total profit
                  function updateTotalProfit(data) {
                      const totalProfit = data.reduce((sum, item) => sum + item, 0); // Sum up the profit values
                      document.getElementById('totalProfitValue').textContent = totalProfit
                          .toLocaleString(); // Update the total profit display
                  }

                  // Convert initial PHP data to JavaScript
                  const initialProfitData = @json($profitChart);

                  // Extract labels (months) and values (profits) for the default year
                  const defaultLabels = initialProfitData.map(item => new Date(0, item.month - 1).toLocaleString('default', {
                      month: 'long'
                  }));
                  const defaultValues = initialProfitData.map(item => item.total_profit);

                  // Render the chart and update total profit with default data
                  document.addEventListener('DOMContentLoaded', function() {
                      // Now, we know the DOM is fully loaded and ready
                      const isDarkMode = document.body.classList.contains('dark-mode'); // Check dark mode on DOM load
                      renderProfitChart(defaultLabels, defaultValues, isDarkMode);
                      updateTotalProfit(defaultValues);
                  });

                  // Handle year filter change
                  $('#profitYear').on('change', function() {
                      const selectedYear = $(this).val();

                      // AJAX request to fetch filtered data
                      $.ajax({
                          url: '{{ route('getProfitChartData') }}',
                          method: 'GET',
                          data: {
                              year: selectedYear
                          },
                          success: function(data) {
                              const labels = data.map(item => new Date(0, item.month - 1).toLocaleString(
                                  'default', {
                                      month: 'long'
                                  }));
                              const values = data.map(item => item.total_profit);

                              // Check dark mode and render chart
                              const isDarkMode = document.body.classList.contains(
                                  'dark-mode'); // Check dark mode after the AJAX request

                              // Update the chart and total profit with new data
                              renderProfitChart(labels, values, isDarkMode);
                              updateTotalProfit(values);
                          }
                      });
                  });


                  let incomeChart = null;

                  // Function to fetch and update income chart data using AJAX
                  function fetchIncomeChartData(month, year) {
                      $.ajax({
                          url: '{{ route('getincomeChartData') }}', // Adjust this route to match your backend
                          type: 'GET',
                          data: {
                              month: month,
                              year: year
                          },
                          success: function(data) {
                              // Process the response data
                              let labels = data.map(item => item.desc); // Descriptions as labels
                              let amounts = data.map(item => item.total_amount); // Total amounts
                              let totalIncome = amounts.reduce((acc, amount) => acc + amount, 0); // Sum total income

                              // Update the total income displayed
                              $('#totalIncomeValue').text(totalIncome.toLocaleString());

                              // Check if dark mode is enabled
                              const isDarkMode = document.body.classList.contains('dark-mode');

                              // If the chart already exists, destroy it to redraw
                              if (incomeChart) {
                                  incomeChart.destroy();
                              }

                              // Render the pie chart with the fetched data
                              var ctx = document.getElementById('incomeChart').getContext('2d');
                              incomeChart = new Chart(ctx, {
                                  type: 'pie',
                                  data: {
                                      labels: labels,
                                      datasets: [{
                                          label: 'Total Amount',
                                          data: amounts,
                                          backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                                              '#FF9F40'
                                          ], // Customize colors as needed
                                      }]
                                  },
                                  options: {
                                      responsive: true,
                                      plugins: {
                                          legend: {
                                              position: 'right',
                                              labels: {
                                                  color: isDarkMode ? '#aca8c3' :
                                                  'black', // Change legend text color based on dark mode
                                              }
                                          },
                                          tooltip: {
                                              callbacks: {
                                                  label: function(tooltipItem) {
                                                      let amount = tooltipItem.raw;
                                                      let label = tooltipItem.label;
                                                      return label + ': ₹ ' + amount
                                                          .toLocaleString(); // Show description and amount
                                                  }
                                              },
                                              bodyColor: isDarkMode ? '#aca8c3' :
                                              'white', // Change tooltip body text color
                                              titleColor: isDarkMode ? '#aca8c3' :
                                              'white', // Change tooltip title color
                                          }
                                      }
                                  }
                              });
                          },
                          error: function(xhr, status, error) {
                              console.error('Error fetching income chart data:', error);
                          }
                      });
                  }

                  // Event listeners for month and year dropdown changes (Income chart)
                  $('#incomeMonth, #incomeYear').change(function() {
                      const selectedMonth = $('#incomeMonth').val();
                      const selectedYear = $('#incomeYear').val();
                      fetchIncomeChartData(selectedMonth, selectedYear);
                  });

                  // Initial income chart load
                  $(document).ready(function() {
                      const selectedMonth = $('#incomeMonth').val();
                      const selectedYear = $('#incomeYear').val();
                      fetchIncomeChartData(selectedMonth, selectedYear);
                  });


                  // Expense Chart
                  let expenseChart = null;

                  // Function to fetch and update expense chart data using AJAX
                  function fetchExpenseChartData(month, year) {
                      $.ajax({
                          url: '{{ route('getExpensesChartData') }}', // Adjust this route to match your backend
                          type: 'GET',
                          data: {
                              month: month,
                              year: year
                          },
                          success: function(data) {
                              // Process the response data
                              let labels = data.map(item => item.desc); // Descriptions as labels
                              let amounts = data.map(item => item.total_amount); // Total amounts
                              let totalExpenses = amounts.reduce((acc, amount) => acc + amount, 0); // Sum total expenses

                              // Update the total expenses displayed
                              $('#totalExpensesValue').text(totalExpenses.toLocaleString());

                              // Check if dark mode is enabled
                              const isDarkMode = document.body.classList.contains('dark-mode');

                              // If the chart already exists, destroy it to redraw
                              if (expenseChart) {
                                  expenseChart.destroy();
                              }

                              // Render the pie chart with the fetched data
                              var ctx = document.getElementById('expenseChart').getContext('2d');
                              expenseChart = new Chart(ctx, {
                                  type: 'pie',
                                  data: {
                                      labels: labels,
                                      datasets: [{
                                          label: 'Total Amount',
                                          data: amounts,
                                          backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                                              '#FF9F40'
                                          ], // Customize colors as needed
                                      }]
                                  },
                                  options: {
                                      responsive: true,
                                      plugins: {
                                          legend: {
                                              position: 'right',
                                              labels: {
                                                  color: isDarkMode ? '#aca8c3' :
                                                  'black', // Change legend text color based on dark mode
                                              }
                                          },
                                          tooltip: {
                                              callbacks: {
                                                  label: function(tooltipItem) {
                                                      let amount = tooltipItem.raw;
                                                      let label = tooltipItem.label;
                                                      return label + ': ₹ ' + amount
                                                          .toLocaleString(); // Show description and amount
                                                  }
                                              },
                                              bodyColor: isDarkMode ? '#aca8c3' :
                                              'white', // Change tooltip body text color
                                              titleColor: isDarkMode ? '#aca8c3' :
                                              'white', // Change tooltip title color
                                          }
                                      }
                                  }
                              });
                          },
                          error: function(xhr, status, error) {
                              console.error('Error fetching expense chart data:', error);
                          }
                      });
                  }

                  // Event listeners for month and year dropdown changes (Expense chart)
                  $('#expensesMonth, #expensesYear').change(function() {
                      const selectedMonth = $('#expensesMonth').val();
                      const selectedYear = $('#expensesYear').val();
                      fetchExpenseChartData(selectedMonth, selectedYear);
                  });

                  // Initial expense chart load
                  $(document).ready(function() {
                      const selectedMonth = $('#expensesMonth').val();
                      const selectedYear = $('#expensesYear').val();
                      fetchExpenseChartData(selectedMonth, selectedYear);
                  });

                  // Receivable Payable

                  $(document).ready(function() {
                      // Initial data load for the current month and year
                      const currentMonth = '{{ now()->month }}';
                      const currentYear = '{{ now()->year }}';
                      fetchReceivablePayableData(currentMonth, currentYear);

                      // Add event listeners for the filters (month and year)
                      $('#ReceivableMonth, #ReceivableYear').change(function() {
                          const selectedMonth = $('#ReceivableMonth').val();
                          const selectedYear = $('#ReceivableYear').val();
                          fetchReceivablePayableData(selectedMonth, selectedYear);
                      });

                      // Fetch Receivable Payable Data and Render Chart
                      function fetchReceivablePayableData(month, year) {
                          $.ajax({
                              url: '{{ route('getReceivablePayableData') }}',
                              type: 'GET',
                              data: {
                                  month: month,
                                  year: year
                              },
                              success: function(data) {
                                  if (data && data.length > 0) {
                                      const labels = data.map(item => item.payment_date);
                                      const amounts = data.map(item => item.total_amount);

                                      // Update the total amount on the page
                                      const totalAmount = amounts.reduce((a, b) => a + b, 0);
                                      $('#totalReceivablePayableValue').text(totalAmount);

                                      // Render the chart
                                      renderReceivablePayableChart(labels, amounts);
                                  } else {
                                      $('#totalReceivablePayableValue').text(0);
                                      renderReceivablePayableChart([], []);
                                  }
                              },
                              error: function(xhr, status, error) {
                                  console.error('Error fetching Receivable Payable data:', error);
                              }
                          });
                      }

                    function renderReceivablePayableChart(labels, data) {
                        const ctx = document.getElementById('receivablePayableChart').getContext('2d');

                        // Check if dark mode is enabled
                        const isDarkMode = document.body.classList.contains('dark-mode');

                        // Destroy any previous chart instance
                        if (window.receivablePayableChartInstance) {
                            window.receivablePayableChartInstance.destroy();
                        }

                        // Calculate minimum and maximum values for Y-axis
                        const minDataValue = Math.min(...data);
                        const maxDataValue = Math.max(...data);
                        const range = maxDataValue - minDataValue;
                        const stepSize = Math.ceil(range / 15); // Divide range into 15 steps

                        // Ensure max and min values align with the step size
                        const adjustedMinValue = Math.floor(minDataValue / stepSize) * stepSize;
                        const adjustedMaxValue = Math.ceil(maxDataValue / stepSize) * stepSize;

                        window.receivablePayableChartInstance = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Receivable Payable Amount',
                                    data: data,
                                    backgroundColor: '#66bb6a',
                                    borderColor: '#66bb6a',
                                    borderWidth: 2,
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        labels: {
                                            color: isDarkMode ? 'white' : 'black' // Change label color based on dark mode
                                        }
                                    },
                                    tooltip: {
                                        enabled: true,
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                const index = tooltipItem.dataIndex;
                                                const paymentDate = labels[index];
                                                const amount = tooltipItem.raw;
                                                return paymentDate + ' - ₹' + amount.toLocaleString();
                                            }
                                        },
                                        bodyColor: isDarkMode ? 'white' : 'white', // Adjust tooltip body text color
                                        titleColor: isDarkMode ? 'white' : 'white', // Adjust tooltip title color
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: false, // Allow values below 0 if minDataValue < 0
                                        min: adjustedMinValue, // Dynamically set min value
                                        max: adjustedMaxValue, // Dynamically set max value
                                        ticks: {
                                            stepSize: stepSize, // Ensure 15 steps
                                            color: isDarkMode ? '#aca8c3' : 'black', // Adjust tick color for dark mode
                                            callback: function(value) {
                                                return value.toLocaleString(); // Format numbers with commas
                                            }
                                        },
                                        title: {
                                            display: true,
                                            text: 'Amount (₹)',
                                            color: isDarkMode ? '#aca8c3' : 'black', // Adjust color based on dark mode
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: '',
                                            color: isDarkMode ? '#aca8c3' : 'black',
                                        },
                                        ticks: {
                                            color: isDarkMode ? '#aca8c3' : 'black',
                                        }
                                    }
                                },
                                animation: {
                                    duration: data.length === 0 ? 0 : 1000 // Disable animation if no data
                                }
                            }
                        });
                    }



                      // Pending Payable chart 
                      fetchPendingPayableData(currentMonth, currentYear);
                      $('#PendingPayableMonth, #PendingPayableYear').change(function() {
                          const selectedMonth = $('#PendingPayableMonth').val();
                          const selectedYear = $('#PendingPayableYear').val();
                          fetchPendingPayableData(selectedMonth, selectedYear);
                      });

                      // Fetch Pending Payable Data and Render Chart
                      function fetchPendingPayableData(month, year) {
                          $.ajax({
                              url: '{{ route('getPendingPayableData') }}',
                              type: 'GET',
                              data: {
                                  month: month,
                                  year: year
                              },
                              success: function(data) {
                                  if (data && data.pending_payable_data.length > 0) {
                                      $('#totalPendingPayableYearValue').text(data.total_pending_payable);

                                      const labels = data.pending_payable_data.map(item => item.project_name);
                                      const amounts = data.pending_payable_data.map(item => item.pending_payable);

                                      renderPendingPayableChart(labels, amounts);
                                  } else {
                                      $('#totalPendingPayableYearValue').text(0);
                                      renderPendingPayableChart([], []);
                                  }
                              },
                              error: function(xhr, status, error) {
                                  console.error('Error fetching Pending Payable data:', error);
                              }
                          });
                      }

                    // Render the Pending Payable Chart
                    function renderPendingPayableChart(labels, data) {
                        const ctx = document.getElementById('PendingPayableYearChart').getContext('2d');

                        // Check if dark mode is enabled
                        const isDarkMode = document.body.classList.contains('dark-mode');

                        // Destroy any previous chart instance
                        if (window.pendingPayableChartInstance) {
                            window.pendingPayableChartInstance.destroy();
                        }

                        // Calculate minimum and maximum values for Y-axis
                        const minDataValue = Math.min(...data);
                        const maxDataValue = Math.max(...data);
                        const range = maxDataValue - minDataValue;
                        const stepSize = Math.ceil(range / 15); // Divide range into 15 steps

                        // Ensure max and min values align with the step size
                        const adjustedMinValue = Math.floor(minDataValue / stepSize) * stepSize;
                        const adjustedMaxValue = Math.ceil(maxDataValue / stepSize) * stepSize;

                        window.pendingPayableChartInstance = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Pending Payable Amount',
                                    data: data,
                                    backgroundColor: '#ff7043',
                                    borderColor: '#ff7043',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        labels: {
                                            color: isDarkMode ? 'white' : 'black' // Change legend label color based on dark mode
                                        }
                                    },
                                    tooltip: {
                                        enabled: true,
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                const index = tooltipItem.dataIndex;
                                                const projectName = labels[index];
                                                const amount = tooltipItem.raw;
                                                return projectName + ' - ₹' + amount.toLocaleString();
                                            }
                                        },
                                        bodyColor: isDarkMode ? 'white' : 'white', // Adjust tooltip body text color
                                        titleColor: isDarkMode ? 'white' : 'white', // Adjust tooltip title color
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: false, // Allow values below 0 if minDataValue < 0
                                        min: adjustedMinValue, // Dynamically set min value
                                        max: adjustedMaxValue, // Dynamically set max value
                                        ticks: {
                                            stepSize: stepSize, // Ensure 15 steps
                                            color: isDarkMode ? '#aca8c3' : 'black', // Adjust y-axis tick color for dark mode
                                            callback: function(value) {
                                                return value.toLocaleString(); // Format numbers with commas
                                            }
                                        },
                                        title: {
                                            display: true,
                                            text: 'Amount (₹)', // Add y-axis title
                                            color: isDarkMode ? '#aca8c3' : 'black', // Adjust y-axis title color based on dark mode
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Projects', // Add x-axis title
                                            color: isDarkMode ? '#aca8c3' : 'black', // Adjust x-axis label color
                                        },
                                        ticks: {
                                            color: isDarkMode ? '#aca8c3' : 'black', // Adjust x-axis tick color
                                        }
                                    }
                                },
                                animation: {
                                    duration: data.length === 0 ? 0 : 1000 // Disable animation if no data
                                }
                            }
                        });
                    }


                  });



                  // Profit & Loss Chart
                  $(document).ready(function() {
                      const currentYear = '{{ now()->year }}'; // Get the current year (from server)

                      // Set the dropdown value to the current year
                      $('#yearSelect').val(currentYear);

                      // Trigger the updateChart function immediately after setting the value
                      updateChart(currentYear);

                      // Event listener for the year selection
                      $('#yearSelect').on('change', function() {
                          const selectedYear = $('#yearSelect').val();
                          updateChart(selectedYear);
                      });

                      function updateChart(year) {
                          // Make AJAX request to fetch the data
                          $.ajax({
                              url: '{{ route('getProfitAndLossChartData') }}', // The URL for your backend
                              method: 'GET', // HTTP method (GET in this case)
                              data: {
                                  year: year
                              },
                              success: function(data) {
                                  // Prepare data for the chart
                                  const months = data.map(item => getMonthName(item
                                      .month)); // Get short month names
                                  const incomes = data.map(item => item.income); // Total income for each month
                                  const expenses = data.map(item => item
                                      .expenses); // Total expenses for each month

                                  // Calculate total income and total expenses
                                  const totalIncome = incomes.reduce((acc, income) => acc + income, 0);
                                  const totalExpenses = expenses.reduce((acc, expense) => acc + expense, 0);

                                  // Calculate total profit (Income - Expenses)
                                  const totalProfit = totalIncome - totalExpenses;

                                  // Update the total profit display
                                  $('#totalProfitChartValue').text(totalProfit.toFixed(
                                      2)); // Display the total profit with 2 decimal places

                                  // Determine whether the values are profit or loss
                                  const profitData = incomes.map(income => income); // Profit data (green)
                                  const lossData = expenses.map(expense => expense); // Loss data (red)

                                  // Check if dark mode is enabled
                                  const isDarkMode = document.body.classList.contains('dark-mode');

                                  // Update the chart with new data
                                  chart.data.labels = months;
                                  chart.data.datasets[0].data = profitData; // Profit data (green)
                                  chart.data.datasets[1].data = lossData; // Loss data (red)

                                  // Adjust chart label and axis colors based on dark mode
                                  chart.options.plugins.legend.labels.color = isDarkMode ? '#aca8c3' :
                                      'black'; // Legend label color
                                  chart.options.scales.y.ticks.color = isDarkMode ? '#aca8c3' :
                                      'black'; // Y-axis ticks color
                                  chart.options.scales.x.ticks.color = isDarkMode ? '#aca8c3' :
                                      'black'; // X-axis ticks color
                                  chart.options.tooltips.bodyColor = isDarkMode ? '#aca8c3' :
                                      'black'; // Tooltip body text color
                                  chart.options.tooltips.titleColor = isDarkMode ? '#aca8c3' :
                                      'black'; // Tooltip title color

                                  chart.update();
                              },
                              error: function(xhr, status, error) {
                                  console.error("Error fetching data: ", status, error);
                              }
                          });
                      }

                      // Function to convert month number to short month name
                      function getMonthName(monthNumber) {
                          const months = [
                              'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                          ];
                          return months[monthNumber - 1]; // Convert month number (1-12) to short month name
                      }

                      // Initial chart setup
                      let chart;
                      const profitLossCtx = document.getElementById('profitLossChart').getContext('2d');
                      const chartConfig = {
                          type: 'bar',
                          data: {
                              labels: [], // Initially empty, will be populated dynamically
                              datasets: [{
                                  label: 'Profit',
                                  data: [],
                                  backgroundColor: '#66BB6A', // Green for profit
                              }, {
                                  label: 'Loss',
                                  data: [],
                                  backgroundColor: '#EF5350', // Red for loss
                              }]
                          },
                          options: {
                              responsive: true,
                              plugins: {
                                  legend: {
                                      labels: {
                                          color: 'black' // Default color, will be updated based on dark mode
                                      }
                                  }
                              },
                              scales: {
                                  y: {
                                      beginAtZero: true,
                                      ticks: {
                                          color: 'black' // Default color for ticks, will be updated based on dark mode
                                      }
                                  },
                                  x: {
                                      ticks: {
                                          color: 'black' // Default color for ticks, will be updated based on dark mode
                                      }
                                  }
                              },
                              tooltips: {
                                  enabled: true,
                                  callbacks: {
                                      label: function(tooltipItem, chart) {
                                          const index = tooltipItem.index;
                                          const projectName = chart.data.labels[index];
                                          const amount = tooltipItem.raw;
                                          return projectName + ' - ₹' + amount; // Show project name and amount
                                      }
                                  }
                              }
                          }
                      };
                      chart = new Chart(profitLossCtx, chartConfig);
                  });
              </script>

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
