<?php

namespace App\Http\Controllers;
use App\Mail\AdminLeaveStatusUpdate;
use App\Models\Attendance;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use App\Models\leave_type;
use App\Models\Leave_management;
use App\Models\OTsheet;
use App\Models\Adjustment;
use App\Models\Benefits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveRequestMail;
use Carbon\Carbon;
use SebastianBergmann\CodeUnit\FunctionUnit;
use Symfony\Component\HttpFoundation\RequestStack;
// use Barryvdh\DomPDF\Facade as PDF;
use PDF;
use function PHPUnit\Framework\returnCallback;
use App\Mail\SalarySlipMail;
use Exception;

class AttendanceController extends Controller
{
    public function today_blade(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month); 
        $year = $request->input('year', Carbon::now()->year); 
    
        $currentDate = now()->format('Y-m-d');
       
        $data = DB::table('attendances')
            ->leftJoin('admins', 'admins.id', '=', 'attendances.emp_id')
            ->leftJoin('department_names', 'department_names.id', '=', 'admins.emp_department_name')
            ->select(
                'attendances.*', 
                'admins.emo_name as user_name',
                'admins.is_deleted as admin_is_deleted', 
                'admins.emp_department_name', 
                'department_names.department_name as de_name'
            )
            ->where('attendances.is_delete', 0)
            ->where('admins.is_deleted', 0) // Corrected this line
            ->whereMonth('attendances.today_date', $month)
            ->orderBy('attendances.today_date', 'desc')
            ->get();
     
        $user = DB::table('admins')
            ->where('is_lock', 0)
            ->where('is_deleted', 0)
            ->whereIn('role', [1, 2, 3])
            ->get();
            
        return view('admin_add.attendance.todays_attendance', compact('data', 'user'));
    }
    

    public function store(Request $request)
    {

        $data = new Attendance;
        $data->emp_id = $request->emp_id;
        $data->first_in = $request->first_in;
        $data->last_out = $request->last_out;
        $data->today_date = Carbon::parse($request->today_date)->format('Y-m-d');
        $data->status = $request->status;
        $data->notes = $request->notes;
        $data->save();
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $data = Attendance::find($id);
        $data->emp_id = $request->emp_id;
        $data->first_in = $request->first_in;
        $data->last_out = $request->last_out;
        $data->today_date = Carbon::parse($request->today_date)->format('Y-m-d');
        $data->status = $request->status;
        $data->notes = $request->notes;
        $data->update();
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $data = Attendance::find($id);
        $data->is_delete = 1;
        $data->update();
        return redirect()->back();
    }

    public function attendance_sheet()
    {

        return view('admin_add.attendance.attendance_sheet');
    }

    public function user_leave()
    {
        $user = Auth::user();
        $data = Leave_management::with('leaveType')
            ->where('user_delete', 0)
            ->where('user_id', $user->id)
            ->get();

        $leave = leave_type::all(); // All leave types
        return view('user.leavemanagement', compact('data', 'leave'));
    }



    // public function admin_leave()
    // {
    //     // Eloquent Relationships to load data
    //     $data = Leave_management::orderBy('id', 'DESC')->with(['admin', 'leaveType']) // admin (from Admins table) and leaveType (from Leave_types table)
    //         ->where('admin_delete', 0)
    //         ->get();
    //     $getEmployee = Admin::orderBy('id', 'DESC')->where('is_deleted', 0)->whereIn('role', [1, 2, 3])->get();

    //     return view('admin_add.all_leave_request', compact('data','getEmployee'));
    // }

    public function admin_leave(Request $request)
    {
        // Initialize the query to fetch the leave data
        $query = Leave_management::orderBy('id', 'DESC')
            ->with(['admin', 'leaveType']) // Eloquent relationships to load data from Admins and Leave_types tables
            ->where('admin_delete', 0)
            ->where('user_delete', 0)
            ->whereHas('admin', function ($q) {
                $q->where('is_deleted', 0); // Ensure admin is not deleted
            });
        // Filter by 'search_name' (employee) if selected
        if ($request->has('search_name') && $request->search_name != '') {
            $searchName = $request->search_name;
            $query->whereHas('admin', function ($q) use ($searchName) {
                $q->where('id', '=', $searchName); // Filter by the exact ID of the selected employee
            });
        }

        // Apply 'from_date' filter if provided
        // Check if both 'from_date' and 'to_date' are provided
        if ($request->has('from_date') && $request->has('to_date') && $request->from_date != '' && $request->to_date != '') {
            // Handle both dates by applying overlapping logic
            $query->where(function ($q) use ($request) {
                // Overlapping condition: records where the leave period falls within the selected range
                $q->whereBetween('from_date', [$request->from_date, $request->to_date])
                    ->orWhereBetween('to_date', [$request->from_date, $request->to_date])
                    ->orWhere(function ($q2) use ($request) {
                        // Records where the leave period completely overlaps the selected range
                        $q2->where('from_date', '<=', $request->to_date)
                            ->where('to_date', '>=', $request->from_date);
                    });
            });
        } else {
            // If only 'from_date' is provided
            if ($request->has('from_date') && $request->from_date != '') {
                // If only from_date is selected, show all records where the 'from_date' is exactly equal to the selected date
                $query->whereDate('from_date', '=', $request->from_date);
            }

            // If only 'to_date' is provided
            if ($request->has('to_date') && $request->to_date != '') {
                // If only to_date is selected, show all records where the 'to_date' is exactly equal to the selected date
                $query->whereDate('to_date', '=', $request->to_date);
            }
        }

        // Apply status filter if provided
        if ($request->has('status') && $request->status != '') {
            $status = $request->status;
            if ($status === 'Approved') {
                $query->where(function ($q) {
                    $q->where('status', 1)
                        ->orWhere('team_head_status', 1);
                });
            } elseif ($status === 'Rejected') {
                $query->where(function ($q) {
                    $q->where('status', 0)
                        ->orWhere('team_head_status', 0);
                });
            }
        }

        // Get filtered data
        $data = $query->get();
      

        // Get employees for the dropdown
        $getEmployee = Admin::where('is_deleted', 0)->whereIn('role', [1, 2, 3])->get();

        // Return the view with the filtered data and employee list
        return view('admin_add.all_leave_request', compact('data', 'getEmployee'));
    }



    public function leave_request_store(Request $request)
    {
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



    public function edit_leave_request(Request $request)
    {
        $id = $request->id;
        $data = Leave_management::find($id);
        $data->leave_type = $request->leave_type;
        $data->from_date = $request->from_date;
        $data->to_date = $request->to_date;
        $data->leave_reason = $request->leave_reason;
        $data->update();

        return redirect()->back();
    }

    public function delete_leave_request_user(Request $request)
    {
        $id = $request->id;
        $data = Leave_management::find($id);
        $data->user_delete = 1;
        $data->update();

        return redirect()->back();
    }

    public function leave_approved(Request $request)
    {
        $id = $request->id;
    
        // Find the leave request
        $data = Leave_management::find($id);
    
        // Update the status
        $data->status = $request->status;
    
        // Handle rejected_reason based on status
        if ($request->status == 1) {
            $data->rejected_reason = null; 
            $data->team_head_status = 1;
        } else {
            $data->rejected_reason = $request->rejected_reason; 
        }
    
        // Save the updated data
        $data->update();
    
        // Fetch admin information
        $user = $data->admin;
    
        // Send email notification
        Mail::to($user->email)->send(new AdminLeaveStatusUpdate($data));
    
        // Redirect back with success message
        return redirect()->back();
    }

    public function delete_leave_request_admin(Request $request)
    {
        $id = $request->id;
        $data = Leave_management::find($id);
        $data->admin_delete = 1;
        $data->update();

        return redirect()->back();
    }

    // Employee Attendance List Function
    public function employeeAttendance(Request $request)
    {
        // Get the selected month and year from the request
        $month = $request->input('month', Carbon::now()->month); 
        $year = $request->input('year', Carbon::now()->year); 
    
        // Fetch the attendance data with the employee relationship
        $data = Attendance::with(['get_emp_name', 'overTime'])
            ->whereMonth('today_date', $month)
            ->whereYear('today_date', $year)
            ->where('is_delete', 0)
            ->whereHas('get_emp_name', function ($query) {
                $query->where('is_deleted', 0); // Apply condition on the related model
            })
            ->get()
            ->groupBy('emp_id');
    
        return view('admin_add.attendance.employee_attendance', compact('data'));
    }
    
    public function getOt($id, $month, $year)
    {
        $data = OTsheet::where('emp_id', $id)->whereMonth('date', $month)
        ->whereYear('date', $year)->sum('total_amount');
        return $data;
    }

    public function getPL($id, $month, $year){
        $data = Attendance::where('emp_id', $id)    
        ->whereMonth('today_date', $month)
        ->whereYear('today_date', $year) 
        ->where('is_delete', 0)
        ->where('status', 0)
        ->get();

        if ($data->isEmpty()) {
            return 'PL'; 
        } else {
            return '0'; 
        }
    }

    public function storeAdjustment(Request $request)
    {
        // Check if the request contains an ID for editing
        if ($request->has('id') && $request->id) {
            // Find the existing record by ID
            $data = Adjustment::find($request->id);
    
            // If the record exists, update its fields
            if ($data) {
                $data->emp_id = $request->emp_id;
                $data->datea_and_month = $request->datea_and_month;
                $data->dedunction = $request->dedunction;
                $data->adjustment = $request->adjustment;
                $data->amont = $request->amont;
                $data->date_and_year = $request->date_and_year;
                $data->save();
    
                return back()->with('success', 'Adjustment updated successfully.');
            } else {
                return back()->with('error', 'Adjustment not found.');
            }
        }
    
        // If no ID, create a new record
        $data = new Adjustment;
        $data->emp_id = $request->emp_id;
        $data->datea_and_month = $request->datea_and_month;
        $data->dedunction = $request->dedunction;
        $data->adjustment = $request->adjustment;
        $data->amont = $request->amont;
        $data->date_and_year = $request->date_and_year;
        $data->save();
    
        return back()->with('success', 'Adjustment created successfully.');
    }
    

    public function getdedunction($id, $month , $year)
    {
        $data = Adjustment::where('datea_and_month', $month)->where('date_and_year', $year)->where('emp_id', $id)->where('dedunction', 1)
            ->first();
        return $data;
    }

    public function getadjustment($id, $month, $year)
    {
        $data = Adjustment::where('datea_and_month', $month)->where('emp_id', $id)->where('date_and_year', $year)->where('adjustment', 1)
            ->first();
        return $data;
    }

    public function getbenefits($id, $month, $year)
    {
        $data = Benefits::where('emp_id', $id)->whereMonth('date', $month)
        ->whereYear('date', $year)->sum('total_amount');
        return $data;
    }

    public function salary_priview($id, $month, $year)
    {
        $totalAttendance = 0;
        $workingDays = 0; // Initialize working days count
        $daysInMonth = Carbon::create()->month($month)->year($year)->daysInMonth;
    
        // Calculate working days
        foreach (range(1, $daysInMonth) as $day) {
            $currentDate = Carbon::createFromDate($year, $month, $day);
            $isSunday = $currentDate->isSunday();
            $isSecondOrFourthSaturday = $currentDate->isSaturday() && (ceil($day / 7) == 2 || ceil($day / 7) == 4);
    
            if (!$isSunday && !$isSecondOrFourthSaturday) {
                $workingDays++;
            }
        }
    
        // Fetch attendance records
        $attendances = Attendance::with('get_emp_name')
            ->whereMonth('today_date', $month)
            ->whereYear('today_date', $year)
            ->where('emp_id', $id)
            ->where('is_delete', 0)
            ->get();
    
        foreach (range(1, $daysInMonth) as $day) {
            $currentDate = Carbon::createFromDate($year, $month, $day);
            $isSunday = $currentDate->isSunday();
            $isSecondOrFourthSaturday = $currentDate->isSaturday() && (ceil($day / 7) == 1 || ceil($day / 7) == 3);
    
            $isHoliday = $isSunday || $isSecondOrFourthSaturday;
    
            $attendanceForDay = $attendances->firstWhere('today_date', $currentDate->toDateString());
    
            if ($attendanceForDay) {
                if ($attendanceForDay->status == 0) {
                    $totalAttendance += 0;
                } elseif ($attendanceForDay->status == 1) {
                    $totalAttendance += 1;
                } elseif ($attendanceForDay->status == 2) {
                    $totalAttendance += 0.5;
                }
            }
        }
    
        $leave_days = $workingDays - $totalAttendance;
    
        // Fetch employee details
        $employee = Admin::with('department')->where('id', $id)->first();

        $overtime = OTsheet::where('emp_id', $id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('total_amount');
        $Benefits = Benefits::where('emp_id', $id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('total_amount');
    
        // Ensure $workingDays is numeric and greater than 0
        $workingDays = max(1, $workingDays);

    
        // Calculate per-day salary and ensure it's numeric
        $perDay = $employee->monthly_selery / $workingDays;
        $dayselery = number_format($perDay, 0, '', '');
       
    
        // Ensure $totalAttendance is numeric
        $totalAttendance = number_format($totalAttendance) ? $totalAttendance : 0;
    
        // Calculate total and monthly salary
        $total_selery = $employee->monthly_selery;

  
        $employe_month_selery = $totalAttendance * $dayselery;
    
        $paid_leav = Attendance::where('emp_id', $id)
            ->whereMonth('today_date', $month)
            ->whereYear('today_date', $year)
            ->where('is_delete', 0)
            ->where('status', 0)
            ->get();
    
        if ($paid_leav->isEmpty()) {
            $paid_leav = $dayselery;
        } else {
            $paid_leav = '0';
        }
    
        $paid_leav_count = Attendance::where('emp_id', $id)
            ->whereMonth('today_date', $month)
            ->whereYear('today_date', $year)
            ->where('is_delete', 0)
            ->where('status', 0)
            ->first();
    
        if ($paid_leav_count) {
            $deduction = $total_selery - $employe_month_selery - $perDay;
        } else {
            $deduction = $total_selery - $employe_month_selery;
        }
    
        $adjustment = Adjustment::where('datea_and_month', $month)->where('emp_id', $id)->where('dedunction', 1)->where('date_and_year', $year)
            ->first();

        $plus = Adjustment::where('datea_and_month', $month)->where('emp_id', $id)->where('adjustment', 1)->where('date_and_year', $year)
            ->sum('amont');
        
    
        // Pass all required data to the view
        return view('admin_add.attendance.salary_slip', compact(
            'attendances',
            'employee',
            'month',
            'year',
            'workingDays',
            'totalAttendance',
            'leave_days',
            'overtime',
            'paid_leav',
            'deduction',
            'adjustment',
            'Benefits',
            'plus'
        ));
    }

    public function sendSalarySlip($id, $month, $year)
    {

        
        $totalAttendance = 0;
        $workingDays = 0; // Initialize working days count
        $daysInMonth = Carbon::create()->month($month)->year($year)->daysInMonth;
    
        // Calculate working days
        foreach (range(1, $daysInMonth) as $day) {
            $currentDate = Carbon::createFromDate($year, $month, $day);
            $isSunday = $currentDate->isSunday();
            $isSecondOrFourthSaturday = $currentDate->isSaturday() && (ceil($day / 7) == 2 || ceil($day / 7) == 4);
    
            if (!$isSunday && !$isSecondOrFourthSaturday) {
                $workingDays++;
            }
        }
    
        // Fetch attendance records
        $attendances = Attendance::with('get_emp_name')
            ->whereMonth('today_date', $month)
            ->whereYear('today_date', $year)
            ->where('emp_id', $id)
            ->where('is_delete', 0)
            ->get();
    
        foreach (range(1, $daysInMonth) as $day) {
            $currentDate = Carbon::createFromDate($year, $month, $day);
            $isSunday = $currentDate->isSunday();
            $isSecondOrFourthSaturday = $currentDate->isSaturday() && (ceil($day / 7) == 1 || ceil($day / 7) == 3);
    
            $isHoliday = $isSunday || $isSecondOrFourthSaturday;
    
            $attendanceForDay = $attendances->firstWhere('today_date', $currentDate->toDateString());
    
            if ($attendanceForDay) {
                if ($attendanceForDay->status == 0) {
                    $totalAttendance += 0;
                } elseif ($attendanceForDay->status == 1) {
                    $totalAttendance += 1;
                } elseif ($attendanceForDay->status == 2) {
                    $totalAttendance += 0.5;
                }
            }
        }
    
        $leave_days = $workingDays - $totalAttendance;
    
        // Fetch employee details
        $employee = Admin::with('department')->where('id', $id)->first();

        $overtime = OTsheet::where('emp_id', $id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('total_amount');
        $Benefits = Benefits::where('emp_id', $id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('total_amount');
    
        // Ensure $workingDays is numeric and greater than 0
        $workingDays = max(1, $workingDays);

    
        // Calculate per-day salary and ensure it's numeric
        $perDay = $employee->monthly_selery / $workingDays;
        $dayselery = number_format($perDay, 0, '', '');
       
    
        // Ensure $totalAttendance is numeric
        $totalAttendance = number_format($totalAttendance) ? $totalAttendance : 0;
    
        // Calculate total and monthly salary
        $total_selery = $employee->monthly_selery;

  
        $employe_month_selery = $totalAttendance * $dayselery;
    
        $paid_leav = Attendance::where('emp_id', $id)
            ->whereMonth('today_date', $month)
            ->whereYear('today_date', $year)
            ->where('is_delete', 0)
            ->where('status', 0)
            ->get();
    
        if ($paid_leav->isEmpty()) {
            $paid_leav = $dayselery;
        } else {
            $paid_leav = '0';
        }
    
        $paid_leav_count = Attendance::where('emp_id', $id)
            ->whereMonth('today_date', $month)
            ->whereYear('today_date', $year)
            ->where('is_delete', 0)
            ->where('status', 0)
            ->first();
    
        if ($paid_leav_count) {
            $deduction = $total_selery - $employe_month_selery - $perDay;
        } else {
            $deduction = $total_selery - $employe_month_selery;
        }
    
        $adjustment = Adjustment::where('datea_and_month', $month)->where('emp_id', $id)->where('dedunction', 1)->where('date_and_year', $year)
            ->first();

        $plus = Adjustment::where('datea_and_month', $month)->where('emp_id', $id)->where('adjustment', 1)->where('date_and_year', $year)
            ->sum('amont');
            
        // Fetch the attendance record from the database
        $attendance = Attendance::where('emp_id', $id)->first();
        
    
        if (!$attendance) {
            return response()->json(['success' => false, 'message' => 'Attendance record not found']);
        }
    
        try {
            // Get the related Admin data
            $admin = Admin::find($attendance->emp_id);
            if (!$admin) {
                return response()->json(['success' => false, 'message' => 'Admin record not found']);
            }
    
            // Generate the PDF for the salary slip (you can pass any required data)
            $pdf = PDF::loadView('emails.salary-slip-pdf', compact('attendance', 'admin','employee','month',
            'year',
            'workingDays',
            'totalAttendance',
            'leave_days',
            'overtime',
            'paid_leav',
            'deduction',
            'adjustment',
            'Benefits',
            'plus'));
    
            // Send the email with the attached PDF
            Mail::to($admin->email)->send(new SalarySlipMail($admin, $pdf));
    
            return response()->json(['success' => true, 'message' => 'Salary slip sent successfully!']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
        
    }
}
