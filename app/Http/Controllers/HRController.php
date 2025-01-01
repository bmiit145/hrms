<?php

namespace App\Http\Controllers;

use Exception;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Mail\LeaveRequestMail;

use App\Models\Admin;
use App\Models\Country;
use App\Models\Holiday;
use App\Models\festival;
use App\Models\Attendance;
use App\Models\Benefits;
use App\Models\OTsheet;
use App\Models\Adjustment;
use App\Models\Currency;
use App\Models\Leave_management;
use Illuminate\Support\Facades\Auth;
use App\Models\leave_type;
use App\Models\description;
use App\Models\Company_Progress;
use App\Models\Client;
use App\Models\Project;
use App\Models\employee_details;
use App\Models\Invoice;
use App\Models\InvoiceItem;


class HRController extends Controller
{
    public function dashboard()
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
        return view('HR.dashboard', compact('data', 'getHolidays', 'getFestival', 'upcomingBirthdayFirst', 'absentEmployees'));
    }

    public function department_view()
    {
        $department_view = DB::table('department_names')->where('is_deleted', 0)->get();
        return view('HR.department', compact('department_view'));
    }

    public function hr_emp_index()
    {
        $countrys = Country::all();
        $emp_details = DB::table('admins')->orderBy('id', 'DESC')->where('is_deleted', 0)->whereIn('role', [1, 2, 3])->get();
        $department_name = DB::table('department_names')->get();
        $team_head_name = Admin::orderBy('id', 'DESC')->where('role', 1)->get();
        $department_name = DB::table('department_names')->where('is_deleted', 0)->get();
        return view('HR.emp_list', compact('emp_details', 'department_name', 'team_head_name', 'countrys'));
    }


    public function hr_emp_form()
    {
        $department_name = DB::table('department_names')->get();
        $team_head_name = Admin::orderBy('id', 'DESC')->where('role', 1)->get();
        return view('HR.empstoreform', compact('department_name', 'team_head_name'));
    }

    public function hr_emp_form_store(Request $request)
    {
        // Handle the date formatting before storing it
        $joining_date = Carbon::createFromFormat('d-m-Y', $request->joining_date)->format('Y-m-d'); // Convert to 'YYYY-MM-DD'
        $emp_birthday_date = Carbon::createFromFormat('d-m-Y', $request->emp_birthday_date)->format('Y-m-d'); // Convert to 'YYYY-MM-DD'

        // Validate the input fields
        $request->validate([
            'add_emp_name' => 'required',
            'add_emp_password' => 'required',
            'add_emp_email' => 'required|email|unique:admins,email',
            'add_emp_mobile_no' => 'required',
            'add_joining_date' => 'required',
            'add_monthly_selery' => 'required',
            'add_emp_department_name' => 'required',
            'add_emp_address' => 'required',
            'add_emp_birthday_date' => 'required',
            'add_emp_document.*' => 'mimes:jpeg,png,jpg,gif,svg,jfif,webp,pdf', // Validate each file
            'add_profile_image.*' => 'mimes:jpeg,png,jpg,gif,svg,jfif,webp',
            'add_role' => 'required',
            'add_emp_team_head_id' => 'required_if:role,2',
        ]);

        // Handle file uploads (if any)
        if ($request->add_emp_bank_document) {
            $imgName = 'lv_' . rand() . '.' . $request->add_emp_bank_document->extension();
            $request->add_emp_bank_document->move(public_path('emp_bank_document/'), $imgName);
            $requestData['add_emp_bank_document'] = $imgName;
        }

        $details = new Admin;
        $details->emo_name = $request->add_emp_name;
        $details->password = Hash::make($request->add_emp_password);
        $details->email = $request->add_emp_email;
        $details->emp_mobile_no = $request->add_emp_mobile_no['main'];
        $details->joining_date = $joining_date;  // Store formatted date
        $details->monthly_selery = $request->add_monthly_selery;
        $details->emp_department_name = $request->add_emp_department_name;
        $details->emp_address = $request->add_emp_address;
        $details->emp_father_mobile_no = $request->emp_father_mobile_no;
        $details->emp_mother_mobile_no = $request->emp_mother_mobile_no;
        $details->bank_no = $request->bank_no;
        $details->bank_name = $request->bank_name;
        $details->emp_brother_sister_mobile_no = $request->emp_brother_sister_mobile_no;
        $details->emp_birthday_date = $emp_birthday_date;  // Store formatted date
        if ($request->add_Notes) {
            $details->emp_notes = $request->add_Notes;
        }

        // Handle document uploads (if any)
        if ($request->hasFile('add_emp_document') && count($request->file('add_emp_document')) > 0) {
            $empDocuments = [];
            foreach ($request->file('add_emp_document') as $empDocument) {
                $empImgName = 'lv_' . rand() . '.' . $empDocument->extension();
                $empDocument->move(public_path('emp_document/'), $empImgName);
                $empDocuments[] = $empImgName;
            }
            $details->emp_document = implode(',', $empDocuments);
        } else {
            $details->emp_document = null;
        }

        // Handle profile image upload (if any)
        $profileimgName = null;
        if ($request->hasFile('add_profile_image')) {
            $profileimgName = 'lv_' . rand() . '.' . $request->add_profile_image->extension();
            $request->add_profile_image->move(public_path('profile_image/'), $profileimgName);
            $requestData['add_profile_image'] = $profileimgName;
        }

        $details->profile_image = $profileimgName;
        $details->role = $request->add_role;
        $details->emp_team_head_id = $request->add_emp_team_head_id;
        $details->save();

        return redirect()->route('hr.employee')->with('success_inquiry', 'Employee added successfully');
    }


    public function hr_employee_edit($id)
    {
        try {
            $data = Admin::findOrFail($id);

            // Convert the stored dates (YYYY-MM-DD) to DD-MM-YYYY format for display in the form
            $data->joining_date = Carbon::parse($data->joining_date)->format('d-m-Y');
            $data->emp_birthday_date = Carbon::parse($data->emp_birthday_date)->format('d-m-Y');

            $department_name = DB::table('department_names')->get();
            $team_head_name = Admin::orderBy('id', 'DESC')->where('role', 1)->get();

            return view('HR.employee_edit', compact('data', 'department_name', 'team_head_name'));
        } catch (Exception $e) {
            return redirect()->back();
        }
    }


    public function hr_emp_details_edit(Request $request)
    {
        if ($request->hasFile('emp_bank_document')) {
            $imgName = 'lv_' . rand() . '.' . $request->emp_bank_document->extension();
            $request->emp_bank_document->move(public_path('emp_bank_document/'), $imgName);
            $requestData['emp_bank_document'] = $imgName;
        }

        // Find the existing employee record by ID
        $details = Admin::find($request->id);

        // Update the employee details with the new values
        $details->emo_name = $request->emp_name;
        $details->email = $request->emp_email;
        $details->emp_mobile_no = $request->emp_mobile_no['main'];
        $details->monthly_selery = $request->monthly_selery;
        $details->emp_department_name = $request->emp_department_name;
        $details->emp_address = $request->emp_address;
        $details->emp_father_mobile_no = $request->emp_father_mobile_no;
        $details->emp_mother_mobile_no = $request->emp_mother_mobile_no;
        $details->bank_no = $request->bank_no;
        $details->bank_name = $request->bank_name;
        $details->emp_brother_sister_mobile_no = $request->emp_brother_sister_mobile_no;
        $data->emp_birthday_date = Carbon::parse($request->emp_birthday_date)->format('Y-m-d');
        $data->joining_date = Carbon::parse($request->joining_date)->format('Y-m-d');
        $details->emp_notes = $request->notes;

        // Handle emp_document uploads (only update if new documents are provided)
        if ($request->hasFile('emp_document') && count($request->file('emp_document')) > 0) {
            $empDocuments = [];
            foreach ($request->file('emp_document') as $empDocument) {
                $empImgName = 'lv_' . rand() . '.' . $empDocument->extension();
                $empDocument->move(public_path('emp_document/'), $empImgName);
                $empDocuments[] = $empImgName;
            }
            if ($details->emp_document) {
                $existingDocuments = explode(',', $details->emp_document);
                $empDocuments = array_merge($existingDocuments, $empDocuments);
            }
            $details->emp_document = implode(',', $empDocuments);
        }

        if ($request->hasFile('emp_bank_document')) {
            $details->emp_bank_document = $imgName;
        }

        // Handle profile image upload
        $profileimgName = $details->profile_image; // Retain current profile image by default

        if ($request->hasFile('profile_image')) {
            if ($details->profile_image && file_exists(public_path('profile_image/' . $details->profile_image))) {
                unlink(public_path('profile_image/' . $details->profile_image));
            }
            $profileimgName = 'lv_' . rand() . '.' . $request->profile_image->extension();
            $request->profile_image->move(public_path('profile_image/'), $profileimgName);
        }

        $details->profile_image = $profileimgName;
        $details->role = $request->role;
        $details->emp_team_head_id = $request->emp_team_head_id;

        $details->save();

        return response()->json(['success' => true, 'message' => 'Employee details updated successfully']);
    }


    public function hr_change_password(Request $request)
    {
        $id = $request->id;
        $data = Admin::find($id);

        if ($data) {
            // Update the password
            $data->password = Hash::make($request->emp_password);
            $data->save(); // Use save() instead of update() for a single model instance

            // Log out the user
            Auth::logout();

            // Optionally, you can flash a message to the session
            $request->session()->flash('status', 'Password changed successfully. Please log in again.');

            // Redirect to the login page or any other page
            return redirect()->route('login'); // Adjust the route name as necessary
        }

        // If the admin is not found, you can handle it accordingly
        return redirect()->back()->withErrors(['error' => 'Admin not found.']);
    }

    public function hr_emp_deleted(Request $request)
    {
        $id = $request->id;
        $delete = Admin::find($id);
        $delete->is_deleted = 1;
        $delete->update();
        return redirect()->back();
    }

    public function hr_user_lock(Request $request)
    {
        $id = $request->id;
        $lock = Admin::find($id);
        if ($lock->is_lock == 0) {
            $lock->is_lock = 1;
        } else {
            $lock->is_lock = 0;
        }
        $lock->update();
        return redirect()->back();
    }

    public function hr_checkEmail(Request $request)
    {
        $email = $request->input('emp_email');
        $userId = $request->input('user_id');  // Assume you're passing user_id for updates

        // Check if the email exists, but exclude the current user's email (in case of update)
        $exists = Admin::where('email', $email)
            ->where('id', '!=', $userId)  // Exclude current user's email
            ->exists();

        // Log the result of the email check
        \Log::info("Email exists: " . ($exists ? 'Yes' : 'No'));

        // Return response: true if the email doesn't exist, false if it does
        return response()->json(!$exists);
    }

    public function hr_deleteEMPDocument(Request $request)
    {
        $userId = $request->user_id;        // Get the user ID from the request
        $documentName = $request->document; // Get the document name (e.g., 'test.png')

        // Find the user's record in the database
        $documentRecord = Admin::find($userId);

        if ($documentRecord) {
            // Split the emp_document string into an array of document names
            $empDocuments = explode(',', $documentRecord->emp_document);

            // Trim whitespace from each document name in the array
            $empDocuments = array_map('trim', $empDocuments);

            // Debug: Output the list of documents and the document we're trying to delete
            \Log::debug('Document List:', $empDocuments);
            \Log::debug('Document to Delete:', [$documentName]);

            // Check if the document exists in the array (after trimming)
            if (in_array(trim($documentName), $empDocuments)) {
                // Remove the document name from the array
                $empDocuments = array_diff($empDocuments, [trim($documentName)]);

                // Debug: Output the updated document list
                \Log::debug('Updated Document List:', $empDocuments);

                // Convert the array back into a comma-separated string
                $updatedDocumentString = implode(',', $empDocuments);

                // Update the user's record in the database with the new document list
                $documentRecord->emp_document = $updatedDocumentString;
                $documentRecord->save(); // Save the changes to the database

                // Assuming documents are stored in the 'public/emp_document' folder in storage
                $filePath = public_path('emp_document/' . $documentName);

                // Check if the file exists before deleting it
                if (file_exists($filePath)) {
                    unlink($filePath);  // Delete the file from storage
                }

                // Return success response
                return response()->json(['success' => true, 'message' => 'Document deleted successfully']);
            } else {
                // Document not found in the user's list
                return response()->json(['success' => false, 'message' => 'Document not found']);
            }
        } else {
            // User not found
            return response()->json(['success' => false, 'message' => 'User not found']);
        }
    }

    public function hr_deleteBankDocument(Request $request)
    {
        $documentId = $request->input('user_id');
        $documentName = $request->input('document'); // Get the document name (e.g., 'lv_343588259.png')

        // Find the document by ID (adjust according to your model structure)
        $document = Admin::find($documentId);

        if ($document && $document->emp_bank_document) {
            // Ensure the file name matches the document stored in the database
            if ($document->emp_bank_document !== $documentName) {
                return response()->json(['success' => false, 'message' => 'Document name mismatch'], 400);
            }

            // Delete the file from storage
            $filePath = public_path('emp_bank_document/' . $document->emp_bank_document);

            // Check if the file exists and attempt to delete it
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    // Optionally, update the database (remove the file reference)
                    $document->emp_bank_document = null;
                    $document->save();

                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Failed to delete the file'], 500);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'File does not exist'], 404);
            }
        }

        return response()->json(['success' => false, 'message' => 'Document not found or already deleted'], 404);
    }

    public function hr_deleteProfileDocument(Request $request)
    {
        $documentId = $request->input('user_id');
        $documentName = $request->input('document'); // Get the document name (e.g., 'lv_343588259.png')

        // Find the document by ID (adjust according to your model structure)
        $document = Admin::find($documentId);

        if ($document && $document->profile_image) {
            // Ensure the file name matches the document stored in the database
            if ($document->profile_image !== $documentName) {
                return response()->json(['success' => false, 'message' => 'Document name mismatch'], 400);
            }

            // Delete the file from storage
            $filePath = public_path('profile_image/' . $document->profile_image);

            // Check if the file exists and attempt to delete it
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    // Optionally, update the database (remove the file reference)
                    $document->profile_image = null;
                    $document->save();

                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Failed to delete the file'], 500);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'File does not exist'], 404);
            }
        }

        return response()->json(['success' => false, 'message' => 'Document not found or already deleted'], 404);
    }

    public function hr_employee_view($id)
    {
        $data = Admin::find($id);
        return view('HR.emp_detail_view', compact('data'));
    }

    public function Add_holiday()
    {
        $holidays = DB::table('holidays')->where('is_deleted', 0)->get();
        return view('HR.holiday', compact('holidays'));
    }

    public function holiday_store(Request $request)
    {
       

        $data = new  Holiday;
        $data->holiday_name = $request->holiday_name;
        $data->holiday_date = Carbon::parse($request->holiday_date)->format('Y-m-d');
        $data->end_date = Carbon::parse($request->holiday_end_date)->format('Y-m-d');
        $data->details = $request->details;
        $data->save();
        return redirect()->back()->with('success', 'Holiday added successfully.');
    }

    public function holiday_edit(Request $request)
    {
        // Retrieve the holiday by ID
        $id = $request->id;
        $data = Holiday::find($id);

        if ($data) {
            // Convert stored dates from 'YYYY-MM-DD' to 'DD-MM-YYYY' format
            $data->holiday_date = Carbon::parse($data->holiday_date)->format('d-m-Y');
            $data->end_date = $data->end_date ? Carbon::parse($data->end_date)->format('d-m-Y') : null;

            // Update the holiday details
            $data->holiday_name = $request->holiday_name;
            $data->holiday_date = Carbon::createFromFormat('d-m-Y', $request->holiday_date)->format('Y-m-d');
            $data->end_date = $request->has('holiday_end_date') ? Carbon::createFromFormat('d-m-Y', $request->holiday_end_date)->format('Y-m-d') : null;
            $data->details = $request->details;
            $data->update();
        }

        return redirect()->back()->with('success', 'Holiday updated successfully.');
    }

    public function holiday_delete(Request $request)
    {
        // Get the comma-separated holiday IDs from the request
        $ids = explode(',', $request->input('ids')); // Convert the comma-separated string into an array

        // Update all holidays with the given IDs to mark them as deleted
        Holiday::whereIn('id', $ids)
            ->update(['is_deleted' => 1]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Selected holidays deleted successfully!');
    }


    public function upcoming_festival()
    {
        $festival = DB::table('festivals')->where('is_delete', 0)->get();
        return view('HR.upcoming_festival', compact('festival'));
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


    public function festival_delete(Request $request)
    {
        $ids = explode(',', $request->input('ids')); // Convert the comma-separated string into an array

        // Mark the selected festivals as deleted (soft delete)
        Festival::whereIn('id', $ids)->update(['is_delete' => 1]);

        return response()->json(['success' => true, 'message' => 'Festival(s) deleted successfully.']);
    }

    public function hr_today_blade(Request $request)
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
        return view('HR.attendance.todays_attendance', compact('data', 'user'));
    }

    public function hr_store(Request $request)
    {
        
    
        // Create a new Attendance record
        $data = new Attendance;
        $data->emp_id = $request->emp_id;
        $data->first_in = $request->first_in;
        $data->last_out = $request->last_out;
        $data->today_date = Carbon::parse($request->today_date)->format('Y-m-d');
        $data->notes = $request->notes;  
        $data->status = $request->status;

        // Save the data to the database
        $data->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Attendance record added successfully.');
    }

    public function hr_update(Request $request)
    {
        $id = $request->id;
        $data = Attendance::find($id);

        // Update the attendance record with the new data from the form
        $data->emp_id = $request->emp_id;
        $data->first_in = $request->first_in;
        $data->last_out = $request->last_out;
        $data->today_date = Carbon::parse($request->today_date)->format('Y-m-d');
        $data->status = $request->status;
        $data->notes = $request->notes;  // Adding the notes field as well

        // Save the updated data
        $data->update();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Attendance updated successfully!');
    }

    public function hr_delete(Request $request)
    {
        // Get the comma-separated IDs from the request
        $ids = explode(',', $request->input('ids')); // Convert the comma-separated string into an array

        // Update all rows with the given IDs to mark them as deleted
        Attendance::whereIn('id', $ids)
            ->update(['is_delete' => 1]); // You can change 'is_delete' to 'is_deleted' if needed

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Selected Attendance deleted successfully!');
    }


    public function employeeAttendance(Request $request)
    {
        // Get the selected month and year from the request
        $month = $request->input('month', Carbon::now()->month); // Default to current month
        $year = $request->input('year', Carbon::now()->year); // Default to current year

        // Fetch the attendance data with the employee relationship
        $data = Attendance::with('get_emp_name') // Make sure 'get_emp_name' is a defined relationship in the Attendance model
            ->whereMonth('today_date', $month)  // Filter by the selected month
            ->whereYear('today_date', $year)  // Filter by the selected year
            ->where('is_delete', 0) // Exclude deleted records
            ->whereHas('get_emp_name', function ($query) {
                $query->where('is_deleted', 0); // Apply condition on the related model
            })
            ->get()
            ->groupBy('emp_id'); // Group the data by employee ID

        return view('HR.attendance.employee_attendance', compact('data')); // Pass the data to the view
    }

    public function profileEdit()
    {
        $data = Auth::user();
        return view('HR.profile.edit', compact('data'));
    }

    public function profileUpdate(Request $request)
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

    public function hr_leave()
    {
        $user = Auth::user();
        $data = Leave_management::with('leaveType')
            ->where('user_delete', 0)
            ->where('user_id', $user->id)
            ->get();

        $leave = leave_type::all(); // All leave types
        return view('HR.leavemanagement', compact('data', 'leave'));
    }

    public function hr_leave_request_store(Request $request)
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

    public function hr_edit_leave_request(Request $request)
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

    public function hr_delete_leave_request_user(Request $request)
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
        return view('HR.companyprogress', compact('income_data', 'expense_data', 'total_income', 'total_expense', 'income_description','expense_description'));
    }

    public function project_index()
    {
        $getEmployee = Admin::orderBy('id', 'DESC')->whereIn('role', [1, 2])->get();
        $data = Project::orderBy('id', 'DESC')->get();
        $getClient = Client::orderBy('id', 'DESC')->where('is_delete',0)->get();
        return view('HR.project.index', compact('getEmployee', 'data', 'getClient'));
    }

    public function Client_view()
    {
        $countrys = Country::all();
        $currencies = Currency::all();
        $data = Client::where('is_delete', 0)->get();
        return view('HR.client', compact('data','countrys','currencies'));
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

        return view('HR.clinetincome', compact('data'));
    }

    public function benifit_index(Request $request)
    {
        // Get month, year, and employee ID from the request, default to current month and year
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $emp = $request->input('emp');

        // Fetch the first employee's details by ID
        $first_emp = Admin::where('role', '!=', 0)
            ->where('is_deleted', 0)
            ->where('id', $emp)
            ->first();

        // Get the list of employees (non-deleted and non-role 0)
        $employee = Admin::where('role', '!=', 0)
            ->where('is_deleted', 0)
            ->get();

        // Fetch the benefits data filtered by year, month, and employee ID
        $data = Benefits::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->where('emp_id', $emp)
            ->get();

        // Format the 'date' field before passing it to the view
        $data = $data->map(function ($item) {
            // Format the date as 'DD-MM-YYYY' for display
            $item->date = Carbon::parse($item->date)->format('d-m-Y');
            return $item;
        });

        // Return the view with the necessary data
        return view('HR.Benefits.index', compact('employee', 'data', 'first_emp'));
    }

    public function benifit_store(Request $request)
    {
        // Handle the date formatting before storing it
        $data = new Benefits;
        $data->emp_id = $request->emp_id;
        $data->date = Carbon::parse($request->date)->format('Y-m-d');
        $data->start_time = $request->start_time;
        $data->end_time = $request->end_time;
        $data->total_hourse = $request->total_hourse;
        $data->total_amount = $request->total_amount;
        $data->save();


        // Redirect back to the same page
        return back();
    }

    public function benifit_edit(Request $request)
    {
        $id = $request->emp_id;
        $data = Benefits::find($id);

        if ($data) {
            $data->date = Carbon::parse($request->date)->format('Y-m-d');
            $data->start_time = $request->start_time;
            $data->end_time = $request->end_time;
            $data->total_hourse = $request->total_hourse;
            $data->total_amount = $request->total_amount;

            // Save the changes
            $data->save();
        }

        return back();
    }

    public function benifit_delete(Request $request)
    {
        $id = $request->id;
        $data = Benefits::find($id);
        $data->delete();
        return back();
    }

    public function ot_index(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $emp = $request->input('emp');
        $first_emp = Admin::where('role', '!=', 0)->where('is_deleted', 0)->where('id', $emp)->first();
        $employee = Admin::where('role', '!=', 0)->where('is_deleted', 0)->get();
        $data = OTsheet::whereMonth('date', $month)
            ->whereYear('date', $year)->where('emp_id', $emp)->get();

        $data = $data->map(function ($item) {
            // Format the date as 'DD-MM-YYYY' for display
            $item->date = Carbon::parse($item->date)->format('d-m-Y');
            return $item;
        });
        return view('HR.OverTime.index', compact('employee', 'data', 'first_emp'));
    }

    public function ot_store(Request $request)
    {
        $data = new OTsheet;
        $data->emp_id = $request->emp_id;
        $data->date = Carbon::parse($request->date)->format('Y-m-d');
        $data->start_time = $request->start_time;
        $data->end_time = $request->end_time;
        $data->total_hourse = $request->total_hourse;
        $data->total_amount = $request->total_amount;
        $data->save();
        return back();
    }

    public function ot_edit(Request $request)
    {
        $id = $request->emp_id;
        $data = OTsheet::find($id);

        if ($data) {
            $data->date = Carbon::parse($request->date)->format('Y-m-d');
            $data->start_time = $request->start_time;
            $data->end_time = $request->end_time;
            $data->total_hourse = $request->total_hourse;
            $data->total_amount = $request->total_amount;

            // Save the changes
            $data->save();
        }

        return back();
    }

    public function ot_delete(Request $request)
    {
        $id = $request->id;
        $data = OTsheet::find($id);
        $data->delete();
        return back();
    }


    public function index()
    {
        $invoices = Invoice::where('is_delete', 0)->with(['currency', 'client'])->get(); // Only show non-deleted invoices
        return view('HR.invoice.index', compact('invoices'));
    }

    public function create(Request $request, $id = null)
    {
        // Validate for unique invoice number, ignoring the current invoice if it's being edited
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
        return view('HR.invoice.create', compact('currencies', 'get_client', 'invoiceNumber', 'editInvoice'));
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
        return view('HR.invoice.edit', compact('currencies', 'get_client', 'invoiceNumber', 'invoice', 'editInvoice'));
    }

    public function deletedInvoices()
    {
        $deletedInvoices = Invoice::where('is_delete', 1)->with(['currency', 'client'])->get(); // Only show deleted invoices
        return view('HR.invoice.deleted', compact('deletedInvoices'));
    }

    public function preview($id)
    {
        // Fetch the invoice along with related items and client using eager loading
        $invoice = Invoice::with('items', 'client')->findOrFail($id);
        
        // Return the preview view with the invoice data
        return view('HR.invoice.invoice', compact('invoice'));
    }

    public function restore($id)
    {
        try {
            $invoice = Invoice::findOrFail($id);
    
            // Restore the invoice by setting is_delete to 0
            $invoice->is_delete = 0;
            $invoice->save();  // Save the updated status
    
            return redirect()->route('hr.invoice.index')->with('success', 'Invoice restored successfully.');
        } catch (\Exception $e) {
            return redirect()->route('hr.invoice.index')->with('error', 'Error restoring the invoice.');
        }
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
        return view('HR.attendance.salary_slip', compact(
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
}
