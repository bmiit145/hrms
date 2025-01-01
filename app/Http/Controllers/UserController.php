<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Admin;
use App\Models\leave_type;
use App\Models\Holiday;
use App\Models\festival;
use App\Models\leave_management;
use App\Models\description;
use App\Models\Company_Progress;
use App\Models\Client;
use App\Models\Project;
use App\Models\InvoiceItem;
use App\Models\Invoice;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveRequestMail;
use App\Models\Country;
use Carbon\Carbon;


class UserController extends Controller
{


    public function Userdashboard()
    {
        $currentDate = now(); // Current date (e.g., 2024-12-17)
        $todayDate = $currentDate->toDateString(); // Today's date in 'YYYY-MM-DD' format
        $todayMonthDay = $currentDate->format('m-d'); // Today's month and day (e.g., '12-17')

        // Step 1: Get all users' birthdays from the database
        $usersBirthdays = DB::table('admins')
            ->where('is_deleted', 0)
            ->select('emo_name', 'emp_birthday_date', 'profile_image')
            ->get();

        // Step 2: Check if today's birthday exists
        $todayBirthdays = $usersBirthdays->filter(function ($item) use ($todayMonthDay) {
            // Check if emp_birthday_date is not null and then format the date
            if (!is_null($item->emp_birthday_date)) {
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
                if (!is_null($item->emp_birthday_date)) {
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
                        if (!is_null($item->emp_birthday_date)) {
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

        // Step 7: Get leave data
        $leave_data = DB::table('leave_managements')
            ->join('admins', 'admins.id', 'leave_managements.user_id')
            ->select('leave_managements.*', 'admins.emo_name')
            ->where('from_date', '<=', $todayDate)
            ->where('to_date', '>=', $todayDate)
            ->where('status', 1)
            ->get();

        // Step 8: Get absent employees
        $startOfWeek = \Carbon\Carbon::now()->startOfWeek()->toDateString();
        $endOfWeek = \Carbon\Carbon::now()->endOfWeek()->toDateString();
        // Step 8: Get absent employees
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

        // Step 9: Get holidays and festivals
        $getHolidays = Holiday::orderBy('id', 'DESC')->where('is_deleted', 0)->get();
        $getFestival = festival::orderBy('id', 'DESC')->where('is_delete', 0)->get();

        // Pass the first upcoming birthday to the view
        return view('User.dashboard', compact('data', 'getHolidays', 'getFestival', 'upcomingBirthdayFirst', 'absentEmployees'));
    }

    public function user_attendance_list()
    {
        // Get the currently logged-in user's ID
        $loggedInUserId = auth()->user()->id;

        // Fetch attendance data for the logged-in user
        $data = Attendance::with('get_today_attedance')
            ->where('emp_id', $loggedInUserId) // Filter by logged-in user's employee ID
            ->whereMonth('today_date', Carbon::now()->month) // Filter by the current month
            ->whereYear('today_date', Carbon::now()->year) // Filter by the current year
            ->get(); // Remove grouping for easier access

        return view('User.employee_attendance', compact('data'));
    }
    
    public function user_attendance_sheet(Request $request)
    {
        // Get selected month and year or default to the current month and year
        $selectedMonth = $request->input('month', Carbon::now()->month);
        $selectedYear = $request->input('year', Carbon::now()->year);

        // Get the currently logged-in user's ID
        $loggedInUserId = auth()->user()->id;

        // Fetch the attendance data only for the logged-in user
        $data = Attendance::with('get_attedance_sheet')
            ->where('emp_id', $loggedInUserId)
            ->whereMonth('today_date', $selectedMonth)
            ->whereYear('today_date', $selectedYear) // Filter by the selected year
            ->get()
            ->groupBy('emp_id'); // Group the data by employee ID


        // Pass data, selected month, and year to the view
        return view('User.attendance_sheet', compact('data', 'selectedMonth', 'selectedYear'));
    }



    public function user_leave()
    {
        $user = Auth::user();
        $data = Leave_management::orderBy('id','DESC')->with('leaveType')
                                ->where('user_delete', 0)
                                ->where('user_id', $user->id)
                                ->get();

        $leave = leave_type::all(); // All leave types
        return view('user.leavemanagement', compact('data', 'leave'));
    }

    public function user_leave_request_store(Request $request)
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Create a new leave request record
        $data = new Leave_management;
        $data->leave_type = $request->leave_type;
        $data->from_date = Carbon::parse($request->from_date)->format('Y-m-d');
        $data->to_date = Carbon::parse($request->to_date)->format('Y-m-d');
        $data->leave_reason = $request->leave_reason;
        $data->user_id = $user->id;
        $data->save();

        // Get leave type for email subject
        $leaveType = leave_type::find($request->leave_type);

        // Get the head/admin email
        $admin = Admin::where('role', 0)->where('is_deleted', 0)->first(); // Fetch admin (head)
        $department_head = Admin::where('role', 1)
            ->where('is_deleted', 0)
            ->where('emp_department_name', $user->emp_department_name)
            ->first(); // Fetch department head

        // Get department name
        $departmentName = $user->department ? $user->department->department_name : 'N/A';

        // Prepare the email data
        $emailData = [
            'adminName' => $user->emo_name,
            'leaveType' => $leaveType->leave_type ?? 'N/A',
            'fromDate' => $request->from_date,
            'toDate' => $request->to_date ?? 'N/A',
            'leaveReason' => $request->leave_reason,
            'userName' => $user->emo_name,
            'departmentName' => $departmentName,
            'contactNumber' => $user->emp_mobile_no
        ];

        // Send the email to admin (head)
        if ($admin) {
            Mail::to($admin->email)->send(new LeaveRequestMail($emailData));
        }

        // Send the email to department head
        if ($department_head) {
            Mail::to($department_head->email)->send(new LeaveRequestMail($emailData));
        }

        return response()->json([
            'success' => true,
            'message' => 'Leave request created successfully, and emails sent to Admin and Department Head.',
        ], 200);
    }

    public function user_edit_leave_request(Request $request)
    {
        $id = $request->id;
        $data = leave_management::find($id);
        $data->leave_type = $request->leave_type;
        $data->from_date = Carbon::parse($request->from_date)->format('Y-m-d');
        $data->to_date = Carbon::parse($request->to_date)->format('Y-m-d');
        $data->leave_reason = $request->leave_reason;
        $data->update();

        return redirect()->back();
    }

    public function user_delete_leave_request(Request $request)
    {
        $ids = explode(',', $request->ids); // Get comma-separated IDs from the request
    
        // Check if records exist and update them as deleted
        $deletedRecords = leave_management::whereIn('id', $ids)->update(['user_delete' => 1]);
    
        if ($deletedRecords > 0) {
            return redirect()->back()->with('success', 'Attadance deleted successfully!');
        } else {
           return redirect()->back()->with('No records found to delete!');
        }
    }

    
    public function profileEdit()
    {
        $data = Auth::user();
        return view('User.profile.edit',compact('data'));
    }

    public function profileUpdate(Request $request, $id)
    {
        $data = Admin::find($request->user_id);
        $data->emo_name = $request->emp_name;
      $data->email = $request->emp_email;
      $data->emp_mobile_no = $request->emp_mobile_no['main'];
      $data->emp_birthday_date = $request->emp_birthday_date;
      $data->emp_birthday_date = $request->emp_birthday_date;
      // Handle profile image upload
      $profileimgName = $data->profile_image; // Retain current profile image by default

      // If there's a new profile image uploaded
      if ($request->hasFile('profile_image')) {
          // Check if there is an old profile image, and delete it
          if ($data->profile_image && file_exists(public_path('profile_image/' . $data->profile_image))) {
              unlink(public_path('profile_image/' . $data->profile_image));  // Delete the old image file
          }

          // Generate new profile image name
          $profileimgName = 'lv_' . rand() . '.' . $request->profile_image->extension();

          // Move the new profile image to the storage folder
          $request->profile_image->move(public_path('profile_image/'), $profileimgName);

          // Update the profile image name in the request data (for saving to the database)
          $requestData['profile_image'] = $profileimgName;
      }

      // Update the profile in the database with the new profile image (if any)
      $data->profile_image = $profileimgName;
      $data->save();
      return redirect()->back();
    }

    
   public function company_progress(Request $request)
   {
      $month = $request->input('month', Carbon::now()->month); // Default to current month
      $year = $request->input('year', Carbon::now()->year); // Default to current year

      // Fetch the attendance data with the client relationship
      $income_data = Company_Progress::whereMonth('date', $month)  
          ->whereYear('date', $year)
          ->where('progress_type',1)
          ->get();
          
      $expense_data = Company_Progress::whereMonth('date', $month)  // Filter by the selected month
          ->whereYear('date', $year)
          ->where('progress_type',2)
          ->get();

          $total_income =  Company_Progress::whereMonth('date', $month)  
          ->whereYear('date', $year)
          ->where('progress_type',1)
          ->sum('amount');
          $total_expense =  Company_Progress::whereMonth('date', $month)  
          ->whereYear('date', $year)
          ->where('progress_type',2)
          ->sum('amount');
          $income_description  = description::where('type',1)->get();
          $expense_description  = description::where('type',2)->get();
      return view('User.companyprogress', compact('income_data','expense_data','total_income','total_expense','income_description','expense_description'));
   }

   public function project_index()
   {
       $getEmployee = Admin::orderBy('id', 'DESC')->whereIn('role', [1, 2])->get();
       $data = Project::orderBy('id', 'DESC')->get();
       $getClient = Client::orderBy('id','DESC')->where('is_delete',0)->get();
       return view('User.project.index', compact('getEmployee', 'data','getClient'));
   }

   public function Client_view()
   {
    
    $countrys = Country::all();
    $currencies = Currency::all();
    $data = Client::orderBy('id', 'DESC')->where('is_delete', 0)->get();
     return view('User.client', compact('data','countrys','currencies'));
   }

   public function Clinetincome(Request $request)
   {
       $month = $request->input('month', Carbon::now()->month); // Default to current month
       $year = $request->input('year', Carbon::now()->year); // Default to current year
 
       // Fetch the attendance data with the client relationship and filter payments by date
       $data = Project::with(['getClientName', 'getpayment' => function ($query) use ($month, $year) {
           $query->whereMonth('payment_date', $month)
                 ->whereYear('payment_date', $year);
       }])
       ->whereHas('getpayment', function ($query) use ($month, $year) {
           $query->whereMonth('payment_date', $month)
                 ->whereYear('payment_date', $year);
       })
       ->get();
 
       return view('User.clinetincome', compact('data'));
   }

   public function index()
   {
       $invoices = Invoice::where('is_delete', 0)->with(['currency', 'client'])->get(); // Only show non-deleted invoices
       return view('User.invoice.index', compact('invoices'));
   }

   public function create(Request $request, $id = null)
   {
       // Validate for uniqu   e invoice number, ignoring the current invoice if it's being edited
       $request->validate([
           'invoice_number' => 'unique:invoices,invoice_number,' . $id, // Skip validation if editing
       ]);

       // Fetch all currencies and clients
       $currencies = Currency::all();
       $get_client = Client::orderBy('id', 'DESC')->where('is_delete', 0)->get();

       // Fetch the latest non-deleted invoice
       $latestInvoice = Invoice::orderBy('invoice_number', 'DESC')->first();

       // Calculate the new invoice number
       // If there's a last invoice, increment its number, otherwise start from '001'
       if ($latestInvoice) {
           // Ensure invoice_number is numeric (if it's stored as a string, strip non-numeric characters)
           $lastInvoiceNumber = (int) $latestInvoice->invoice_number;
           $invoiceNumber = str_pad($lastInvoiceNumber + 1, 3, '0', STR_PAD_LEFT); // Increment by 1 and pad with zeros
       } else {
           $invoiceNumber = '001'; // Start from '001' if no invoice exists
       }

       // If editing an invoice, fetch the invoice by ID
       $editInvoice = Invoice::find($id);

       // Pass the necessary data to the view
       return view('User.invoice.create', compact('currencies', 'get_client', 'invoiceNumber', 'editInvoice'));
   }  

   public function update($id)
   {
       $currencies = Currency::all();
       $get_client = Client::orderBy('id', 'DESC')->get();
       $invoiceNumber = Invoice::all(); // Fetch the existing invoice number
       $invoice = InvoiceItem::all();  // Invoice items, assuming you want to show them in the form
       
       // Fetch the invoice you want to edit, make sure to load the related items
       $editInvoice = Invoice::with('items')->find($id); // Load invoice with related items
       
       // Pass the invoice data to the view
       return view('User.invoice.edit', compact('currencies', 'get_client', 'invoiceNumber', 'invoice', 'editInvoice'));
   }


   public function deletedInvoices()
   {
       $deletedInvoices = Invoice::where('is_delete', 1)->with(['currency', 'client'])->get(); // Only show deleted invoices
       return view('User.invoice.deleted', compact('deletedInvoices'));
   }

   public function preview($id)
   {
       // Fetch the invoice along with related items and client using eager loading
       $invoice = Invoice::with('items', 'client')->findOrFail($id);
       
       // Return the preview view with the invoice data
       return view('User.invoice.invoice', compact('invoice'));
   }

   public function restore($id)
   {
       try {
           $invoice = Invoice::findOrFail($id);
   
           // Restore the invoice by setting is_delete to 0
           $invoice->is_delete = 0;
           $invoice->save();  // Save the updated status
   
           return redirect()->route('user.invoice.deleted')->with('success', 'Invoice restored successfully.');
       } catch (\Exception $e) {
           return redirect()->route('user.invoice.deleted')->with('error', 'Error restoring the invoice.');
       }
   }


}
