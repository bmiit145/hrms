<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveRequestMail;
use App\Mail\ApprovalSendMail;
use App\Models\Attendance;
use App\Models\Admin;
use App\Models\leave_type;
use App\Models\Leave_management;
use App\Models\Company_Progress;
use App\Models\Client;
use App\Models\Project;
use App\Models\description;
use App\Models\User;
use App\Models\Holiday;
use App\Models\festival;
use Carbon\Carbon;


class TeamheadController extends Controller
{
    public function teamdashboard()
    {
      $currentDate = now()->format('Y-m-d');
      $data = DB::table('admins')
                  ->where('role', 1)
                  ->where('is_deleted', 0)
                    ->where('emp_birthday_date', $currentDate)
                  ->get();
        $fromDate = now()->toDateString();  // Current date
        $todayDate = now()->toDateString();
        $leave_data = DB::table('leave_managements')
              ->join('admins', 'admins.id', 'leave_managements.user_id')
              ->select('leave_managements.*', 'admins.emo_name')
              ->where('from_date', '<=', $todayDate)
              ->where('to_date', '>=', $todayDate)
              ->where('team_head_status', 1)
              ->get();
      $getHolidays = Holiday::orderBy('id','DESC')->where('is_deleted', 0)->get();
      $getFestival = festival::orderBy('id','DESC')->where('is_delete', 0)->get();
      return view('team_head.dashboard', compact('data','getHolidays','getFestival'));
    }


    

    public function teamHead_employee_list()
    {
        $teamHead = Auth::user(); // Logged-in Team Head
    
        // Get Team Head's department
        $teamHeadDepartment = $teamHead->department->id;
    
        // Fetch employees who belong to the same department
        $data = Admin::where('role', '2') // Role 2 indicates employees
                     ->where('emp_department_name', $teamHeadDepartment)
                     ->get();
    
        return view('team_head.emp_detail_list', compact('data'));
    }
    
   
    public function teamHead_employee_view($id)
    {
      $data = Admin::find($id);
      return view('team_head.emp_detail_view', compact('data'));
    }






    public function teamHead_attendance_list()
    {
        // Get the currently logged-in user's ID
        $loggedInUserId = auth()->user()->id;
    
        // Fetch attendance data for the logged-in user
        $data = Attendance::with('get_today_attedance')
            ->where('emp_id', $loggedInUserId) // Filter by logged-in user's employee ID
            ->whereMonth('today_date', Carbon::now()->month) // Filter by the current month
            ->whereYear('today_date', Carbon::now()->year) // Filter by the current year
            ->get(); // Remove grouping for easier access
    
        return view('team_head.employee_attendance', compact('data'));
    }

    public function teamHead_empolyee_attendance_list(Request $request)
    {
        // Get the selected month and year from the request, with defaults to the current month and year
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        // Get the current user's department
        $teamHeadDepartment = auth()->user()->emp_department_name;

        // Fetch attendance data for employees in the same department and filter by month/year
        $data = Attendance::with(['get_emp_name' => function ($query) use ($teamHeadDepartment) {
            $query->where('role', 2) // Employees only
                  ->where('emp_department_name', $teamHeadDepartment); // Same department
        }])
        ->whereMonth('today_date', $month) // Selected month
        ->whereYear('today_date', $year)   // Selected year
        ->get()
        ->groupBy('emp_id'); // Group attendance by employee ID

        // Filter out attendance where the related employee is null
        $data = $data->filter(function ($attendanceGroup) {
            return $attendanceGroup->first()->get_emp_name !== null; // Only keep valid attendance
        });

        return view('team_head.emp_list', compact('data')); // Pass the filtered data to the view
    }
    
    public function teamHead_attendance_sheet(Request $request)
    {
        // Get selected month and year or default to the current month and year
        $selectedMonth = $request->input('month', Carbon::now()->month);
        $selectedYear = $request->input('year', Carbon::now()->year);
    
        // Get the currently logged-in user's ID
        $loggedInUserId = auth()->user()->id;
    
        // Fetch the attendance data only for the logged-in user
        $data = Attendance::with('get_attedance_sheet')
            ->where('emp_id', $loggedInUserId) // Filter by logged-in user's employee ID
            ->whereMonth('today_date', $selectedMonth) // Filter by the selected month
            ->whereYear('today_date', $selectedYear) // Filter by the selected year
            ->get()
            ->groupBy('emp_id'); // Group the data by employee ID

    
        // Pass data, selected month, and year to the view
        return view('team_head.attendance_sheet', compact('data', 'selectedMonth', 'selectedYear'));
    }
    


  




    public function teamHead_empolyee_leave_list(Request $request)
    {
        $AuthUser = Auth::user();
    
        // Get the department of the logged-in team head
        $teamHeadDepartment = $AuthUser->emp_department_name;
    
        // Initialize the query for leave management
        $query = Leave_management::with(['admin', 'leaveType'])
            ->where('admin_delete', 0)
            ->whereHas('admin', function ($query) use ($AuthUser) {
                $query->where('emp_team_head_id', $AuthUser->id);
            });
    
        // Filter by date range
        if ($request->has('from_date') && $request->has('to_date') && $request->from_date && $request->to_date) {
            $query->where(function ($q) use ($request) {
                $q->whereBetween('from_date', [$request->from_date, $request->to_date])
                ->orWhereBetween('to_date', [$request->from_date, $request->to_date]);
            });
        } elseif ($request->has('from_date') && $request->from_date) {
            $query->where(function ($q) use ($request) {
                $q->where('from_date', '<=', $request->from_date)
                ->where('to_date', '>=', $request->from_date);
            });
        } elseif ($request->has('to_date') && $request->to_date) { 
            $query->where(function ($q) use ($request) {
                $q->where('from_date', '<=', $request->to_date)
                ->where('to_date', '>=', $request->to_date);
            });
        }

    
        // Filter by status (Approved or Rejected)
        if ($request->has('status') && $request->status) {
            $status = $request->status;
            if ($status === 'Approved') {
                $query->where(function ($q) {
                    $q->where('status', 1)->orWhere('team_head_status', 1);
                });
            } elseif ($status === 'Rejected') {
                $query->where(function ($q) {
                    $q->where('status', 0)->orWhere('team_head_status', 0);
                });
            }
        }
    
        // Search by employee name
        if ($request->has('search_name') && $request->search_name) {
            $searchName = $request->search_name;
            $query->whereHas('admin', function ($q) use ($searchName) {
                $q->where('id', $searchName);
            });
        }
    
        // Fetch leave management data
        $data = $query->get();
    
        // Fetch employees belonging to the same department as the team head
        $getEmployee = Admin::orderBy('id', 'DESC')
            ->where('role', 2) // Only users with role 2
            ->where('emp_department_name', $teamHeadDepartment) // Matching department
            ->get();
    
        return view('team_head.all_leave_request', compact('data', 'getEmployee'));
    }  

    public function teamHead_user_request_leave_approved(Request $request)
    {
        $id = $request->id;
        $user = Auth::user();
    
        // Fetch leave management record and eager load related models
        $data = Leave_management::with(['admin', 'leaveType'])->find($id);
    
        // Check if the leave request exists
        if (!$data) {
            return redirect()->back()->with('error', 'Leave request not found.');
        }
    
        // Update leave team_head_status and reason
        $data->team_head_status = $request->status;
        if ($request->rejected_reason) {
            $data->team_head_rejected_reasons = $request->rejected_reason;
        }
        $data->update();

        // Get leave type for email subject
        $leaveType = leave_type::find($request->leave_type);

        // Get the head/admin email
        $admin = Admin::where('role', 0)->where('is_deleted', 0)->first(); // Fetch admin (head)
        $department_head = Admin::where('role', 2)
        ->where('is_deleted', 0)
        ->where('emp_department_name', $user->emp_department_name)
        ->first(); // Fetch department head
        
        //  dd($department_head);
        // Get department name
        $departmentName = $user->department ? $user->department->department_name : 'N/A';

        // Prepare email data
            $emailData = [
                'userName' => $data->admin->emo_name ?? 'N/A',
                'departmentName' => $data->admin->emp_department_name ?? 'N/A',
                'contactNumber' => $data->admin->emp_mobile_no ?? 'N/A',
                'fromDate' => $data->from_date,
                'toDate' => $data->to_date,
                'leaveReason' => $data->leave_reason,
                'leaveType' => $data->leaveType->leave_type ?? 'N/A',
                'status' => $data->team_head_status == 1 ? 'Approved' : 'Rejected',
                'rejectedReason' => $data->team_head_rejected_reasons ?? 'N/A'
            ];

        // Send the email to admin (head)
        if ($admin) {
            Mail::to($admin->email)->send(new ApprovalSendMail($emailData));
        }

        // Send the email to department head
        if ($department_head) {
            Mail::to($department_head->email)->send(new ApprovalSendMail($emailData));
        }

        return redirect()->back();    
    }

    public function teamHead_user_request_leave_delete(Request $request)
    {
        $id = $request->id;
        $data = leave_management::find($id);
        $data->admin_delete = 1;
        $data->update();

        return redirect()->back();
    } 
    
    
   







    public function teamHead_leave()
    {
        $user = Auth::user();
        $data = Leave_management::with('leaveType')
                                ->where('user_delete', 0)
                                ->where('user_id', $user->id)
                                ->get();

        $leave = leave_type::all(); // All leave types
        return view('team_head.leavemanagement', compact('data', 'leave'));
    }
 
    public function teamHead_leave_request_store(Request $request)
    {

        $request->validate([
            'leave_type' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'leave_reason' => 'required|string|max:255',
        ]);


        $user = Auth::user(); // Get the currently authenticated user
        // Create a new leave request record
        $data = new Leave_management;   
        $data->leave_type = $request->leave_type;
        $data->from_date = $request->from_date;
        $data->to_date = $request->to_date;
        $data->leave_reason = $request->leave_reason;
        $data->user_id = $user->id;
        $data->save();
    
        // Get leave type for email subject
        $leaveType = leave_type::find($request->leave_type);
    
        // Get the admin email (single admin)
        $admin = Admin::where('role', 0)->where('is_deleted', 0)->first(); // Fetch admin (head)
    
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin not found. Email could not be sent.',
            ], 404);
        }
    
        // Prepare the email data
        $emailData = [
            'adminName' => $admin->name,
            'leaveType' => $leaveType->leave_type ?? 'N/A',
            'fromDate' => $request->from_date,
            'toDate' => $request->to_date ?? 'N/A',
            'leaveReason' => $request->leave_reason,
            'userName' => $user->emo_name,
            'departmentName' => $user->department->department_name ?? 'N/A',
            'contactNumber' => $user->emp_mobile_no,
        ];
    
        // Send the email to admin only
        Mail::to($admin->email)->send(new LeaveRequestMail($emailData));
    
        return response()->json([
            'success' => true,
            'message' => 'Leave request created successfully, and email sent to Admin.',
        ], 200);
    }    
    
   public function teamHead_edit_leave_request(Request $request)
   {
      $id = $request->id;
      $data = leave_management::find($id);
      $data->leave_type = $request->leave_type;
      $data->from_date = $request->from_date;
      $data->to_date = $request->to_date;
      $data->leave_reason = $request->leave_reason;
      $data->update();

      return redirect()->back();
   }

   public function teamHead_delete_leave_request(Request $request)
   {
       $id = $request->id;
   
       // Check if the record exists
       $data = leave_management::find($id);
   
       if ($data) {
           // Mark the record as deleted
           $data->user_delete = 1;
           $data->update();
   
           return response()->json(['message' => 'Record deleted successfully.']);
       } else {
           return response()->json(['message' => 'Record not found.'], 404);
       }
   }
   
    






    public function teamhead_profileEdit()
    {
      $data = Auth::user();
      return view('team_head.profile.edit',compact('data'));
    }
  
    public function teamhead_profileUpdate(Request $request)
    {
      $data = Admin::find($request->user_id);
      $data->emo_name = $request->emp_name;
      $data->email = $request->emp_email;
      $data->emp_mobile_no = $request->emp_mobile_no['main'];
      $data->emp_birthday_date = $request->emp_birthday_date;
      $data->emp_address = $request->address;
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
        $description  = description::all();
      return view('User.companyprogress', compact('income_data','expense_data','total_income','total_expense','description'));
   }

   public function project_index()
   {
       $getEmployee = Admin::orderBy('id', 'DESC')->whereIn('role', [1, 2])->get();
       $data = Project::orderBy('id', 'DESC')->get();
       $getClient = Client::orderBy('id','DESC')->get();
       return view('User.project.index', compact('getEmployee', 'data','getClient'));
   }

   public function Client_view()
   {
     $data = Client::where('is_delete', 0)->get();
     return view('User.client', compact('data'));
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

  
 
}
