@extends('admin_layout.sidebar')
@section('content')
<style>
  #birthday {
    background-image: url('../assets/img/backgrounds/happy-birthday.jpg');
    background-size: cover;
    /* or 'contain' depending on your preference */
    background-position: center;
    background-repeat: no-repeat;
    height: 457px;
  }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-8 mb-4 order-0">
      <div class="card">
        <div class="d-flex align-items-end row" style="align-items: center !important;">
          <div class="col-sm-7">
            <div class="card-body">
              <img src="../assets/img/avatars/logo.png" style="width:35%">
              <br>
              <br>
              <p class="mb-4 " style="font-family: cursive;font-size:medium;color:#cda89b"> “The only place where
                success comes before work is in the dictionary.” “The way to get started is to quit talking and begin
                doing.” “Let no feeling of discouragement prey upon you, and in the end you are sure to succeed.” “You
                can't build a reputation on what you are going to do.” </p>
            </div>
          </div>
          <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
              <img src="../assets/img/backgrounds/3d.webp" style="width: 100%;height: 100%;">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 order-1">
      <div class="row">
        <div class="col-lg-6 col-md-12 col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded">
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                  </div>
                </div>
              </div>
              <span class="fw-medium d-block mb-1">Profit</span>
              <h3 class="card-title mb-2">$12,628</h3>
              <small class="text-success fw-medium"><i class='bx bx-up-arrow-alt'></i> +72.80%</small>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="../assets/img/icons/unicons/wallet-info.png" alt="Credit Card" class="rounded">
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                  </div>
                </div>
              </div>
              <span>Sales</span>
              <h3 class="card-title text-nowrap mb-1">$4,679</h3>
              <small class="text-success fw-medium"><i class='bx bx-up-arrow-alt'></i> +28.42%</small>
            </div>
          </div>
        </div>
      </div>
    </div>
    @if($data->isNotEmpty())
    @foreach ($data as $item)
    <!-- Total Revenue -->
    <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
      <div class="card">
      <div class="row row-bordered g-0">
      <div class="col-md-8">
      <h5 class="card-header m-0 me-2 pb-3" style="font-family: cursive;">Happy Birthday {{$item->emo_name}} 🎉
      </h5>
      <div id="birthday" class="px-2">
        <img src="{{asset('profile_image/' . $item->profile_image)}}" alt=""
        style="width:45%;margin-left:27%;margin-top:93px;">
      </div>
      </div>
      <div class="col-md-4">
      <div class="card-body" style="padding:21%">
        <div class="text-center">
        <div class="dropdown">
        <h4 style="font-family: cursive;">Wishing you a happy birthday, a wonderful year and success in all
        you do.<br><br>
        <div style="color: burlywood;">PlaceCode Family</div>
        </h4>
        </div>
        <img src='../assets/img/backgrounds/birthday.gif' alt="chart success" style="width:115%">
        </div>
      </div>
      </div>
      </div>
      </div>
    </div>
  @endforeach
  @endif
    <!--/ Total Revenue -->
    {{-- <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
      <div class="row">
        <div class="col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="../assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded">
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                  </div>
                </div>
              </div>
              <span class="d-block mb-1">Payments</span>
              <h3 class="card-title text-nowrap mb-2">$2,456</h3>
              <small class="text-danger fw-medium"><i class='bx bx-down-arrow-alt'></i> -14.82%</small>
            </div>
          </div>
        </div>
        <div class="col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="../assets/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded">
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="cardOpt1">
                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                  </div>
                </div>
              </div>
              <span class="fw-medium d-block mb-1">Transactions</span>
              <h3 class="card-title mb-2">$14,857</h3>
              <small class="text-success fw-medium"><i class='bx bx-up-arrow-alt'></i> +28.14%</small>
            </div>
          </div>
        </div>
        <!-- </div>
        <div class="row"> -->
        <div class="col-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                  <div class="card-title">
                    <h5 class="text-nowrap mb-2">Profile Report</h5>
                    <span class="badge bg-label-warning rounded-pill">Year 2021</span>
                  </div>
                  <div class="mt-sm-auto">
                    <small class="text-success text-nowrap fw-medium"><i class='bx bx-chevron-up'></i> 68.2%</small>
                    <h3 class="mb-0">$84,686k</h3>
                  </div>
                </div>
                <div id="profileReportChart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}
  </div>
  <div class="row">
    <!-- Order Statistics -->
    <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between pb-0">
          <div class="card-title mb-0">
            <h5 class="m-0 me-2"><strong>Holiday List</strong></h5>
          </div>
          <!-- <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button> -->
          <button class="add-holidays" style="border-radius: 13px 5px;background: #696cff;color: white;border: none;height: 30px;width: 10%;position: relative;"><i class="fa fa-plus" aria-hidden="true"></i></button>
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
                    <h6 class="mb-0">{{$holoday->holiday_name ?? ''}}</h6>
                  </div>
                  <div class="user-progress">
                  <small class="fw-medium">
                    @isset($holoday->holiday_date)
                        {{ \Carbon\Carbon::parse($holoday->holiday_date)->format('d M y') }}
                    @endisset
                    
                    @isset($holoday->end_date)
                        &nbsp;&nbsp;<b>To</b>&nbsp;&nbsp; {{ \Carbon\Carbon::parse($holoday->end_date)->format('d M y') }}
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
    <!--/ Order Statistics -->

    <!-- Expense Overview -->
    <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between pb-0">
          <div class="card-title mb-0">
            <h5 class="m-0 me-2"><strong>Festival List</strong></h5>
          </div>
          <!-- <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button> -->
          <button class="add-festival" style="border-radius: 13px 5px;background: #696cff;color: white;border: none;height: 30px;width: 10%;position: relative;"><i class="fa fa-plus" aria-hidden="true"></i></button>
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
                    <h6 class="mb-0">{{$festival->fetival_name ?? ''}}</h6>
                  </div>
                  <div class="me-2">
                    @php
                        $filePath = public_path('festival_image/' . $festival->festival_image); // Get full server path
                    @endphp
                    @if(!empty($festival->festival_image) && file_exists($filePath)) 
                      <img src="{{asset('festival_image/'.$festival->festival_image)}}" alt="festival_image" height="50" width="50">
                    @endif
                  </div>
                  <div class="user-progress">
                  <small class="fw-medium">{{ \Carbon\Carbon::parse($festival->festival_date)->format('d M y') ?? '' }}</small>
                  </div>
                </div>
              </li>
              <hr>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
    <!--/ Expense Overview -->

    <!-- Transactions -->
    <div class="col-md-6 col-lg-4 order-2 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2">Transactions</h5>
          <div class="dropdown">
            <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false">
              <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
              <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
              <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
              <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <ul class="p-0 m-0">
            <li class="d-flex mb-4 pb-1">
              <div class="avatar flex-shrink-0 me-3">
                <img src="../assets/img/icons/unicons/paypal.png" alt="User" class="rounded">
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="text-muted d-block mb-1">Paypal</small>
                  <h6 class="mb-0">Send money</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-1">
                  <h6 class="mb-0">+82.6</h6> <span class="text-muted">USD</span>
                </div>
              </div>
            </li>
            <li class="d-flex mb-4 pb-1">
              <div class="avatar flex-shrink-0 me-3">
                <img src="../assets/img/icons/unicons/wallet.png" alt="User" class="rounded">
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">1
                <div class="me-2">
                  <small class="text-muted d-block mb-1">Wallet</small>
                  <h6 class="mb-0">Mac'D</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-1">
                  <h6 class="mb-0">+270.69</h6> <span class="text-muted">USD</span>
                </div>
              </div>
            </li>
            <li class="d-flex mb-4 pb-1">
              <div class="avatar flex-shrink-0 me-3">
                <img src="../assets/img/icons/unicons/chart.png" alt="User" class="rounded">
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="text-muted d-block mb-1">Transfer</small>
                  <h6 class="mb-0">Refund</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-1">
                  <h6 class="mb-0">+637.91</h6> <span class="text-muted">USD</span>
                </div>
              </div>
            </li>
            <li class="d-flex mb-4 pb-1">
              <div class="avatar flex-shrink-0 me-3">
                <img src="../assets/img/icons/unicons/cc-success.png" alt="User" class="rounded">
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="text-muted d-block mb-1">Credit Card</small>
                  <h6 class="mb-0">Ordered Food</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-1">
                  <h6 class="mb-0">-838.71</h6> <span class="text-muted">USD</span>
                </div>
              </div>
            </li>
            <li class="d-flex mb-4 pb-1">
              <div class="avatar flex-shrink-0 me-3">
                <img src="../assets/img/icons/unicons/wallet.png" alt="User" class="rounded">
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="text-muted d-block mb-1">Wallet</small>
                  <h6 class="mb-0">Starbucks</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-1">
                  <h6 class="mb-0">+203.33</h6> <span class="text-muted">USD</span>
                </div>
              </div>
            </li>
            <li class="d-flex">
              <div class="avatar flex-shrink-0 me-3">
                <img src="../assets/img/icons/unicons/cc-warning.png" alt="User" class="rounded">
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="text-muted d-block mb-1">Mastercard</small>
                  <h6 class="mb-0">Ordered Food</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-1">
                  <h6 class="mb-0">-92.45</h6> <span class="text-muted">USD</span>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!--/ Transactions -->
  </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

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
</script>

@endsection