<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Holiday;
use App\Models\Client;
use App\Models\Role;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\festival;
use App\Models\Country;
use App\Models\Company_Progress;
use App\Models\description;
use App\Models\Attendance;
use App\Models\CardColse;
use App\Models\Payment;
use App\Models\Currency;
use Carbon\Carbon;
use PhpParser\Lexer\TokenEmulator\ReadonlyFunctionTokenEmulator;
use Psy\CodeCleaner\ReturnTypePass;
use Symfony\Component\HttpFoundation\RequestStack;

class AdminController extends Controller
{
  public function index()
  {
    return view('admin_layout.sidebar');
  }

  public function dashboard(Request $request)
  {
    $currentDate = now(); // Current date (e.g., 2024-12-17)
    $todayDate = $currentDate->toDateString(); // Today's date in 'YYYY-MM-DD' format
    $todayMonthDay = $currentDate->format('m-d'); // Today's month and day (e.g., '12-17')
    $currentMonth = now()->month; // Current month
    $currentYear = now()->year; // Current year


    // Step 1: Get all users' birthdays from the database
    $usersBirthdays = DB::table('admins')
      ->where('is_deleted', 0)
      ->select('emo_name', 'emp_birthday_date', 'profile_image')
      ->get();

    // Step 2: Check if today's birthday exists
    $todayBirthdays = $usersBirthdays->filter(function ($item) use ($todayMonthDay) {
      // Check if emp_birthday_date is not null and then format the date
      if (!is_null($item->emp_birthday_date) && strtotime($item->emp_birthday_date) !== false) {
        return Carbon::parse($item->emp_birthday_date)->format('m-d') == $todayMonthDay;
      }
      return false; // Skip if date is null
    });

    // Step 3: If there are today's birthdays, show them
    if ($todayBirthdays->count() > 0) {
      $data = $todayBirthdays; // Today's birthdays
      $upcomingBirthdays = collect(); // No need for upcoming birthdays if today has birthdays
      $upcomingBirthdayFirst = null; // Ensure the variable is initialized
    } else {
      // Step 4: If no birthday today, get upcoming birthdays within the next 12 months

      // First, filter out the birthdays that are in the future (within the next 12 months)
      $upcomingBirthdays = $usersBirthdays->filter(function ($item) use ($currentDate) {
        // Skip null dates
        if (!is_null($item->emp_birthday_date) && strtotime($item->emp_birthday_date) !== false) {
          $birthdayDate = Carbon::parse($item->emp_birthday_date);
          $birthdayThisYear = $birthdayDate->setYear($currentDate->year); // Set the birthday year to the current year

          // If the birthday has passed this year, consider it for the next year
          if ($birthdayThisYear->isBefore($currentDate)) {
            $birthdayThisYear->addYear(); // Add 1 year to show next year's birthday
          }

          // Return if birthday is within the next 12 months
          return $birthdayThisYear->isAfter($currentDate) && $birthdayThisYear->diffInDays($currentDate) <= 365;
        }
        return false; // Skip if date is null
      });

      // Step 5: If there are no birthdays within the next 12 months, loop over the next months
      if ($upcomingBirthdays->count() == 0) {
        $upcomingBirthdays = collect();
        $nextMonth = Carbon::parse($currentDate)->addMonth();
        for ($i = 0; $i < 12; $i++) {
          $nextMonthStart = $nextMonth->copy()->startOfMonth(); // Get the start of the next month
          $nextMonthEnd = $nextMonth->copy()->endOfMonth(); // Get the end of the next month

          // Get birthdays for the next month
          $monthlyBirthdays = $usersBirthdays->filter(function ($item) use ($nextMonthStart, $nextMonthEnd) {
            // Skip null dates
            if (!is_null($item->emp_birthday_date) && strtotime($item->emp_birthday_date) !== false) {
              $birthdayDate = Carbon::parse($item->emp_birthday_date);
              return $birthdayDate->between($nextMonthStart, $nextMonthEnd);
            }
            return false; // Skip if date is null
          });

          if ($monthlyBirthdays->isNotEmpty()) {
            // Add monthly birthdays to upcoming birthdays
            $upcomingBirthdays = $upcomingBirthdays->merge($monthlyBirthdays);
          }

          // Move to the next month
          $nextMonth->addMonth();
        }
      }

      // Step 6: Only show the first upcoming birthday (if any)
      $upcomingBirthdayFirst = $upcomingBirthdays->sortBy(function ($item) use ($currentDate) {
        $birthdayDate = Carbon::parse($item->emp_birthday_date);
        $birthdayThisYear = $birthdayDate->setYear($currentDate->year); // Set to current year

        // If the birthday has passed this year, consider it for next year
        if ($birthdayThisYear->isBefore($currentDate)) {
          $birthdayThisYear->addYear(); // Add 1 year to show next year's birthday
        }

        return $birthdayThisYear; // Sort by birthday date
      })->first(); // Only get the first upcoming birthday

      $data = collect(); // No birthdays today, so empty
    }

    $fromDate = now()->toDateString();  // Current date
    $leave_data = DB::table('leave_managements')
      ->join('admins', 'admins.id', 'leave_managements.user_id')
      ->select('leave_managements.*', 'admins.emo_name')
      ->where('from_date', '<=', $todayDate)
      ->where('to_date', '>=', $todayDate)
      ->where('status', 1)
      ->get();

    $startOfWeek = \Carbon\Carbon::now()->startOfWeek()->toDateString();
    $endOfWeek = \Carbon\Carbon::now()->endOfWeek()->toDateString();

    $absentEmployees = DB::table('leave_managements')
      ->join('admins', 'leave_managements.user_id', '=', 'admins.id')
      ->select(
        'admins.id',
        'admins.emo_name',
        'leave_managements.leave_reason',
        'admins.profile_image',
        'leave_managements.from_date', // Include from_date
        'leave_managements.to_date'    // Include to_date
      )
      ->whereIn('admins.role', [1, 2, 3])
      ->whereBetween('leave_managements.from_date', [$startOfWeek, $endOfWeek])
      ->where('admins.is_deleted', 0)
      ->where('status', 1)
      ->orderBy('id', 'DESC')
      ->get();

    // Fetch filtered data grouped by custom date ranges
    $salesChart = DB::table('projects')
      ->select(
        DB::raw('
                  CASE 
                      WHEN DAY(start_date) BETWEEN 1 AND 5 THEN "1-5"
                      WHEN DAY(start_date) BETWEEN 6 AND 12 THEN "6-12"
                      WHEN DAY(start_date) BETWEEN 13 AND 19 THEN "13-19"
                      WHEN DAY(start_date) BETWEEN 20 AND 26 THEN "20-26"
                      WHEN DAY(start_date) BETWEEN 27 AND 31 THEN "27-31"
                  END as date_range
              '),
        DB::raw('SUM(total_earning) as total_earning')
      )
      ->whereYear('start_date', $currentYear)
      ->whereMonth('start_date', $currentMonth)
      ->groupBy('date_range')
      ->orderByRaw('MIN(DAY(start_date))') // Order by the first day in the range
      ->get();

    $profitChart = DB::table('projects')
      ->select(
        DB::raw('MONTH(start_date) as month'),  // Extract the month from start_date
        DB::raw('SUM(total_earning) as total_profit')  // Calculate total profit for the month
      )
      ->whereYear('start_date', $currentYear)     // Filter by the current year
      ->groupBy(DB::raw('MONTH(start_date)'))     // Group by month
      ->orderBy(DB::raw('MONTH(start_date)'), 'ASC') // Order by month
      ->get();

    $totalEmployee = Admin::whereIn('role', [1, 2, 3])->where('is_deleted', 0)->count();
    $totalClient = Client::where('is_delete', 0)->count();
    $totalProject = Project::count();


    $getHolidays = Holiday::orderBy('id', 'DESC')->where('is_deleted', 0)->get();
    $getFestival = festival::orderBy('id', 'DESC')->where('is_delete', 0)->get();
    return view('admin_layout.dashboard', compact('data', 'getHolidays', 'getFestival', 'salesChart', 'profitChart', 'totalEmployee', 'totalClient', 'totalProject', 'upcomingBirthdayFirst', 'absentEmployees'));
  }

  public function getSalesChartData(Request $request)
  {
    $selectedMonth = $request->input('month', now()->month);
    $selectedYear = $request->input('year', now()->year);

    // Fetch filtered data grouped by custom date ranges
    $salesChart = DB::table('projects')
      ->select(
        DB::raw('
                CASE 
                    WHEN DAY(start_date) BETWEEN 1 AND 5 THEN "1-5"
                    WHEN DAY(start_date) BETWEEN 6 AND 12 THEN "6-12"
                    WHEN DAY(start_date) BETWEEN 13 AND 19 THEN "13-19"
                    WHEN DAY(start_date) BETWEEN 20 AND 26 THEN "20-26"
                    WHEN DAY(start_date) BETWEEN 27 AND 31 THEN "27-31"
                END as date_range
            '),
        DB::raw('SUM(total_earning) as total_earning')
      )
      ->whereYear('start_date', $selectedYear)
      ->whereMonth('start_date', $selectedMonth)
      ->groupBy('date_range')
      ->orderByRaw('MIN(DAY(start_date))') // Order by the first day in the range
      ->get();

    return response()->json($salesChart);
  }

  public function getProfitChartData(Request $request)
  {
    // Get the selected year or default to the current year
    $year = $request->input('year', now()->year);

    // Fetch profit data for the selected year
    $profitChart = DB::table('projects')
      ->select(
        DB::raw('MONTH(start_date) as month'),  // Extract the month
        DB::raw('SUM(total_earning) as total_profit')  // Calculate total profit
      )
      ->whereYear('start_date', $year)  // Filter by selected year
      ->groupBy(DB::raw('MONTH(start_date)'))  // Group by month
      ->orderBy(DB::raw('MONTH(start_date)'), 'ASC')  // Order by month
      ->get();

    return response()->json($profitChart);
  }

  public function getReceivablePayableData(Request $request)
  {
    $month = $request->input('month');
    $year = $request->input('year');

    $receivablePayable = Payment::selectRaw('DATE_FORMAT(payment_date, "%Y-%m-%d") as payment_date')
      ->selectRaw('SUM(total_payment) as total_amount')
      ->addSelect('projects.project_name')  // Explicitly select project_name
      ->join('projects', 'projects.id', '=', 'payments.project_id')  // Join with projects table to fetch project_name
      ->whereYear('payment_date', $year)
      ->whereMonth('payment_date', $month)
      ->groupByRaw('DATE_FORMAT(payment_date, "%Y-%m-%d"), projects.project_name')  // Group by date and project_name
      ->orderBy('payment_date', 'ASC')
      ->get();

    // Return data as JSON
    return response()->json($receivablePayable);
  }

  public function getPendingPayableData(Request $request)
  {
    $month = $request->input('month');
    $year = $request->input('year');

    // Fetch active projects for the given month and year
    $projects = Project::whereYear('start_date', $year)
      ->whereMonth('start_date', $month)
      ->with('getpayment') // Ensure relationships are loaded
      ->get();

    // Prepare data for each project and calculate the pending payable
    $PendingPayable = $projects->map(function ($project) {
      // Calculate total earnings (sum of 'total_earning' for the project)
      $totalEarnings = $project->total_earning;

      // Calculate total payments (sum of 'total_payment' for the project)
      $totalPayments = $project->getpayment->sum('total_payment');

      // Calculate the pending payable (earnings - payments)
      $pendingPayable = $totalEarnings - $totalPayments;

      // Count the number of payments related to the project
      $paymentCount = $project->getpayment->count();

      return [
        'project_name' => $project->project_name,
        'total_earnings' => $totalEarnings,
        'total_payments' => $totalPayments,
        'pending_payable' => $pendingPayable,
        'payment_count' => $paymentCount,
        'start_date' => $project->start_date,
      ];
    });

    // Calculate the total pending payable for all projects
    $totalPendingPayable = $PendingPayable->sum('pending_payable'); // Sum of all pending payable amounts

    // Optionally, count the total number of projects
    $totalProjects = $projects->count(); // Total number of projects for the given month and year

    // Return the data as JSON
    return response()->json([
      'pending_payable_data' => $PendingPayable,
      'total_projects' => $totalProjects,
      'total_pending_payable' => $totalPendingPayable, // Total pending payable for the selected period
    ]);
  }

  public function getIncomeChartData(Request $request)
  {
    $month = $request->input('month');
    $year = $request->input('year');

    $incomeChartData = Company_Progress::select('date', 'desc', DB::raw('SUM(amount) as total_amount'))
      ->where('progress_type', 1)
      ->whereYear('date', $year)
      ->whereMonth('date', $month)
      ->groupBy('date', 'desc')
      ->get();

    return response()->json($incomeChartData);
  }

  public function getExpensesChartData(Request $request)
  {
    $month = $request->input('month');
    $year = $request->input('year');

    $expensesChartData = Company_Progress::select('date', 'desc', DB::raw('SUM(amount) as total_amount'))
      ->where('progress_type', 2)  // Assuming progress_type 2 is for expenses
      ->whereYear('date', $year)
      ->whereMonth('date', $month)
      ->groupBy('date', 'desc')
      ->get();

    return response()->json($expensesChartData);
  }

  public function getProfitAndLossChartData(Request $request)
  {
    $year = $request->input('year');    // Get the selected year

    // Query for income and expenses, grouped by month and year
    $chartData = Company_Progress::select(
      DB::raw('YEAR(date) as year'),  // Extract the year from the date
      DB::raw('MONTH(date) as month'),  // Extract the month from the date
      DB::raw('SUM(CASE WHEN progress_type = 1 THEN amount ELSE 0 END) as income'),  // For income (progress_type 1)
      DB::raw('SUM(CASE WHEN progress_type = 2 THEN amount ELSE 0 END) as expenses')  // For expenses (progress_type 2)
    )
      ->whereYear('date', $year)  // Filter by the selected year
      ->groupBy(DB::raw('YEAR(date), MONTH(date)'))  // Group by year and month
      ->orderBy('month')  // Ensure results are sorted by month
      ->get();

    // Generate all months in the selected year (1 to 12)
    $allMonths = collect(range(1, 12));

    // Fill missing months with zero values
    $chartData = $allMonths->map(function ($month) use ($chartData) {
      $data = $chartData->firstWhere('month', $month);
      return [
        'month' => $month,
        'income' => $data ? $data->income : 0,  // Set income to 0 if no data for the month
        'expenses' => $data ? $data->expenses : 0,  // Set expenses to 0 if no data for the month
      ];
    });

    return response()->json($chartData);
  }

  public function upcoming_festival()
  {
    $festival = DB::table('festivals')->where('is_delete', 0)->get();
    return view('admin_add.upcoming_festival', compact('festival'));
  }

  public function festival_store(Request $request)
  {
    $data = new festival;
    $data->fetival_name = $request->fetival_name;
    $data->festival_date = Carbon::parse($request->festival_date)->format('Y-m-d');
    $data->notes = $request->notes;
    if ($request->hasFile('festival_image')) {
      $festival_image = 'lv_' . rand() . '.' . $request->festival_image->extension();
      $request->festival_image->move(public_path('festival_image/'), $festival_image);
      $requestData['festival_image'] = $festival_image;
      $data->festival_image = $festival_image;
    }

    $data->save();
    return redirect()->back();
  }

  public function festival_edit(Request $request)
  {
    $data = festival::find($request->id);
    $data->fetival_name = $request->fetival_name;
    $data->festival_date = Carbon::parse($request->festival_date)->format('Y-m-d');
    $data->notes = $request->notes;

    if ($request->hasFile('festival_image')) {
      if ($data->festival_image && file_exists(public_path('festival_image/' . $data->festival_image))) {
        unlink(public_path('festival_image/' . $data->festival_image));
      }
      $festival_image = 'lv_' . rand() . '.' . $request->festival_image->extension();
      $request->festival_image->move(public_path('festival_image/'), $festival_image);
      $data->festival_image = $festival_image;
    }
    $data->update();
    return redirect()->back();
  }


  public function deleteFestival(Request $request)
  {
      try {
          $ids = explode(',', $request->ids); // Convert comma-separated IDs into an array
  
          foreach ($ids as $id) {
              $festival = Festival::find($id);
  
              if ($festival) {
                  // Delete associated file
                  if ($festival->festival_image && file_exists(public_path('festival_image/' . $festival->festival_image))) {
                      unlink(public_path('festival_image/' . $festival->festival_image));
                  }
  
                  // Delete the record
                  $festival->delete();
              }
          }
  
          return response()->json(['success' => true, 'message' => 'Festival(s) deleted successfully.']);
      } catch (\Exception $e) {
          return response()->json(['success' => false, 'message' => 'Error deleting festival(s).']);
      }
  }
  
  
  
  

  public function profileEdit()
  {
    $data = Auth::user();
    $getEmployee = Admin::with('page_role')->orderBy('id', 'DESC')->where('is_deleted', 0)->whereIn('role', [1, 2, 3])->get();
    return view('admin_add.profile.edit', compact('data', 'getEmployee'));
  }

  public function profileUpdate(Request $request)
  {
      $data = Admin::find($request->user_id);
      $data->emo_name = $request->emp_name;
      $data->email = $request->emp_email;
      $data->emp_mobile_no = $request->emp_mobile_no['main'];
  
      // Convert MM/DD/YYYY to YYYY-MM-DD before saving to DB
      if ($request->emp_birthday_date) {
        $data->emp_birthday_date = \Carbon\Carbon::parse($request->emp_birthday_date)->format('Y-m-d');
    }
  
      $data->emp_address = $request->address;
  
      // Handle profile image upload
      $profileimgName = $data->profile_image; // Retain current profile image by default
  
      if ($request->hasFile('profile_image')) {
          if ($data->profile_image && file_exists(public_path('profile_image/' . $data->profile_image))) {
              unlink(public_path('profile_image/' . $data->profile_image));
          }
  
          $profileimgName = 'lv_' . rand() . '.' . $request->profile_image->extension();
          $request->profile_image->move(public_path('profile_image/'), $profileimgName);
      }
  
      $data->profile_image = $profileimgName;
      $data->save();
  
      return redirect()->back();
  }
  

  public function Client_view()
  {
    $countrys = Country::all();
    $currencies = Currency::all();
    $data = Client::orderBy('id', 'DESC')->where('is_delete', 0)->get();
    return view('admin_add.client', compact('data', 'countrys', 'currencies'));
  }

  public function employeePageAccess(Request $request)
  {
    // Debugging the request data (you can remove this after you're sure the data looks correct)
    // dd($request->all());

    // Loop through each employee's page access
    foreach ($request->employee_ids as $employeeId) {
      // Get the checkbox data for the current employee, default to null if not checked
      $clientData = $request->input("client_data.$employeeId", null);
      $projectData = $request->input("project_data.$employeeId", null);
      $invoice = $request->input("invoice.$employeeId", null);
      $companyProgress = $request->input("company_progress.$employeeId", null);
      $clientIncome = $request->input("client_income.$employeeId", null);

      // Check if any of the fields have been selected (i.e., not null)
      $fieldsToUpdate = [];
      if ($clientData !== null) {
        $fieldsToUpdate['client_data'] = $clientData;
      }
      if ($projectData !== null) {
        $fieldsToUpdate['project_data'] = $projectData;
      }
      if ($invoice !== null) {
        $fieldsToUpdate['invoice'] = $invoice;
      }
      if ($companyProgress !== null) {
        $fieldsToUpdate['company_progress'] = $companyProgress;
      }
      if ($clientIncome !== null) {
        $fieldsToUpdate['client_income'] = $clientIncome;
      }

      // If any fields are selected, update or create the entry for the employee
      if (!empty($fieldsToUpdate)) {
        Role::updateOrCreate(
          ['employee_id' => $employeeId],  // Condition to find the record by employee ID
          $fieldsToUpdate  // Fields to update or insert
        );
      }
    }

    // Redirect back with success message
    return redirect()->back()->with('success', 'Page access updated successfully!');
  }
  public function Client_store(Request $request)
  {
    $data = new Client();
    $data->name = $request->name;
    $data->currency = $request->currency;
    $fullPhone = $request->country_code . ' ' . $request->phone;
    $data->phone = $fullPhone;
    $data->address = $request->address;
    $data->email  = $request->email;
    $data->company_name = $request->company_name;
    $data->project_name   = $request->project_name;
    $data->client_payment_details = $request->client_payment_details;
    $data->total_earning = $request->total_earning;
    $data->earning_date = $request->earning_date;
    $data->save();
    return back();
  }


  public function Client_update(Request $request)
  {
    $id = $request->id;
    $data = Client::find($id);
    $data->name = $request->edit_name;
    $data->currency = $request->edit_currency;
    $fullPhone = $request->edit_country_code . ' ' . $request->edit_phone;
    $data->phone = $fullPhone;
    $data->address = $request->edit_address;
    $data->email = $request->edit_email;
    $data->company_name = $request->edit_company_name;
    $data->project_name = $request->edit_project_name;
    $data->client_payment_details = $request->edit_client_payment_details;
    $data->total_earning = $request->edit_total_earning;
    $data->earning_date = $request->edit_earning_date;
    $data->update();
    return back();
  }

  public function Client_delete(Request $request)
  {
    $id = $request->id;
    $data = Client::find($id);
    $data->is_delete = 1;
    $data->update();
    return back();
  }


  public function Clinetincome(Request $request)
  {
      $month = $request->input('month', Carbon::now()->month); // Default to current month
      $year = $request->input('year', Carbon::now()->year); // Default to current year
  
      // Fetch projects with clients and payments for the selected month and year
      $data = Project::with(['getClientName', 'getpayment' => function ($query) use ($month, $year) {
          $query->whereMonth('payment_date', $month)
                ->whereYear('payment_date', $year);
      }])
      ->whereHas('getpayment', function ($query) use ($month, $year) {
          $query->whereMonth('payment_date', $month)
                ->whereYear('payment_date', $year);
      })
      ->get();
  
      return view('admin_add.clinetincome', compact('data'));
  }


  public function company_progress(Request $request)
  {
    $month = $request->input('month', Carbon::now()->month); // Default to current month
    $year = $request->input('year', Carbon::now()->year); // Default to current year
    // Fetch the attendance data with the client relationship
    $income_data = Company_Progress::whereMonth('date', $month)
      ->whereYear('date', $year)
      ->where('progress_type', 1)
      ->get();
    $expense_data = Company_Progress::whereMonth('date', $month)  // Filter by the selected month
      ->whereYear('date', $year)
      ->where('progress_type', 2)
      ->get();
    $total_income =  Company_Progress::whereMonth('date', $month)
      ->whereYear('date', $year)
      ->where('progress_type', 1)
      ->sum('amount');
    $total_expense =  Company_Progress::whereMonth('date', $month)
      ->whereYear('date', $year)
      ->where('progress_type', 2)
      ->sum('amount');
      $income_description  = description::where('type',1)->get();
      $expense_description  = description::where('type',2)->get();
    return view('admin_add.companyprogress', compact('income_data', 'expense_data', 'total_income', 'total_expense', 'income_description','expense_description'));
  }
  public function saveExpense(Request $request)
  {

    $data = new Company_Progress;
    $data->date = Carbon::parse($request->date)->format('Y-m-d');
    $data->amount = $request->amount;
    $data->desc = $request->desc;
    $data->progress_type = $request->progress_type;
    $data->save();

    return response()->json(['message' => 'Expense saved successfully!'], 200);
  }
  public function editIncomeData(Request $request)
  {
    $data = Company_Progress::find($request->id);

    if ($data) {
      $data->{$request->field} = $request->value;
      $data->save();

      return response()->json(['message' => 'Data updated successfully!']);
    }

    return response()->json(['message' => 'Data not found!'], 404);
  }

  public function saveDescription(Request $request)
  {


    // Save the new description
    $description = new description();
    $description->name = $request->name;
    $description->type = $request->type;
    $description->save();

    return response()->json([
      'success' => true,
      'id' => $description->id, // Return the ID of the newly created record
    ]);
  }


  public function deleteIncomeData(Request $request)
  {
    $id = $request->input('id'); // Get the ID
    $income = Company_Progress::find($id); // Replace `IncomeModel` with your model name

    if ($income) {
      $income->delete(); // Delete the record
      return response()->json(['success' => true, 'message' => 'Record deleted successfully.']);
    }

    return response()->json(['success' => false, 'message' => 'Record not found.']);
  }

  // close Card Function

  public function closeCard()
  {
    $user_id = Auth::user()->id;
    $closeCard = CardColse::first();

    if (!$closeCard) {
      $closeCard = new CardColse();
    }

    $closeCard->user_id = $user_id;
    $closeCard->close_date = date('Y-m-d'); // Current date

    // Save the record
    $closeCard->save();
    return redirect()->back();
  }

  public function restoreCard()
  {
    $user_id = Auth::user()->id;
    $closeCard = CardColse::first();

    $closeCard->user_id = $user_id;
    $closeCard->close_date = date('Y-m-d'); // Current date

    // Save the record
    $closeCard->delete();
    return redirect()->back();
  }

  public function adminList()
  {
    $emp_details = DB::table('admins')->orderBy('id', 'DESC')->where('is_deleted', 0)->where('role',0) ->where('id', '!=', auth()->id())->get();
    $department_name = DB::table('department_names')->get();
    $team_head_name = Admin::orderBy('id', 'DESC')->where('role', 1)->get();
    $department_name = DB::table('department_names')->where('is_deleted', 0)->get();
    return view('admin_add.admin-list', compact('emp_details', 'department_name', 'team_head_name'));
  }
}
