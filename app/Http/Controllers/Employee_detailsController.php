<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\employee_details;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class Employee_detailsController extends Controller
{

    public function index()
    {
        $emp_details = DB::table('admins')->orderBy('id', 'DESC')->where('is_deleted', 0)->whereIn('role', [1, 2, 3])->get();
        $department_name = DB::table('department_names')->get();
        $team_head_name = Admin::orderBy('id', 'DESC')->where('role', 1)->get();
        $department_name = DB::table('department_names')->where('is_deleted', 0)->get();
        return view('admin_add.emp_list', compact('emp_details', 'department_name', 'team_head_name'));
    }

    // public function teamHead_employee_list()
    // {
    //     $emp_details = DB::table('admins')->where('is_deleted', 0)->whereIn('role', [1, 2, 3])->get();
    //     $department_name = DB::table('department_names')->get();
    //     return view('admin_add.emp_list', compact('emp_details','department_name'));
    // }



    public function emp_form()
    {
        $department_name = DB::table('department_names')->get();
        $team_head_name = Admin::orderBy('id', 'DESC')->where('role', 1)->get();
        return view('admin_add.empstoreform', compact('department_name', 'team_head_name'));
    }

    public function form_store(Request $request)
    {

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
            // 'emp_document' => 'required|array|min:1',
            'add_emp_document.*' => 'mimes:jpeg,png,jpg,gif,svg,jfif,webp,pdf', //Validate each file
            'emp_bank_document.*' => 'mimes:jpeg,png,jpg,gif,svg,jfif,webp', //Validate each file
            // 'profile_image' => 'required',
            'add_profile_image.*' => 'mimes:jpeg,png,jpg,gif,svg,jfif,webp',
            'add_role' => 'required',
            'add_emp_team_head_id' => 'required_if:role,2',

        ], [
            'add_emp_name.required' => 'Name is required',
            'add_emp_email.required' => 'Email is required',
            'add_emp_email.unique' => 'Email already exists',
            'add_emp_password.required' => 'Password  is required',
            'add_emp_mobile_no.required' => 'Mobile Number is required',
            'add_joining_date.required' => 'Joining Date is required',
            'add_monthly_selery.required' => 'Monthly Salary is required',
            'add_emp_department_name.required' => 'Department Name is required',
            'add_emp_address.required' => 'Address is required',
            'add_emp_birthday_date.required' => 'Birthday Date  is required',
            // 'emp_document.required' => 'Employee Document is required',
            // 'profile_image.required' => 'Profile Image is required',
            'add_role.required' => 'Role select is compulsory',
            'add_emp_team_head_id.required_if' => 'Team Head selection is required for Employees',


        ]);

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
        $details->joining_date = Carbon::parse($request->add_joining_date)->format('Y-m-d');
        $details->monthly_selery = $request->add_monthly_selery;
        $details->emp_department_name = $request->add_emp_department_name;
        $details->emp_address = $request->add_emp_address;
        $details->emp_father_mobile_no = $request->emp_father_mobile_no;
        $details->emp_mother_mobile_no = $request->emp_mother_mobile_no;
        $details->bank_no = $request->bank_no;
        $details->bank_name = $request->bank_name;
        $details->emp_brother_sister_mobile_no = $request->emp_brother_sister_mobile_no;
        $details->emp_birthday_date = Carbon::parse($request->add_emp_birthday_date)->format('Y-m-d');
        if ($request->add_Notes) {
            $details->emp_notes = $request->add_Notes;
        }

        // $empDocuments = [];
        // foreach ($request->file('emp_document') as $empDocument) {
        //     $empImgName = 'lv_' . rand() . '.' . $empDocument->extension();
        //     $empDocument->move(public_path('emp_document/'), $empImgName);
        //     $empDocuments[] = $empImgName;
        // }
        // $details->emp_document = implode(',', $empDocuments);
        if ($request->hasFile('add_emp_document') && count($request->file('add_emp_document')) > 0) {
            $empDocuments = [];
            foreach ($request->file('add_emp_document') as $empDocument) {
                $empImgName = 'lv_' . rand() . '.' . $empDocument->extension();
                $empDocument->move(public_path('emp_document/'), $empImgName);
                $empDocuments[] = $empImgName;
            }
            $details->emp_document = implode(',', $empDocuments);
        } else {
            // Handle the case where no files are uploaded (optional)
            $details->emp_document = null;
        }
        if ($request->emp_bank_document) {
            $details->emp_bank_document = $imgName;
        }
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
        return redirect()->route('admin.employee')->with('success_inquiry', ' Employee Add successfully');
    }


    public function employee_edit($id)
    {
        try {
            $data = Admin::findOrFail($id);
            $department_name = DB::table('department_names')->get();
            $team_head_name = Admin::orderBy('id', 'DESC')->where('role', 1)->get();
            return view('admin_add.employee_edit', compact('data', 'department_name', 'team_head_name'));
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    public function emp_details_edit(Request $request)
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
        $details->joining_date = Carbon::parse($request->joining_date)->format('Y-m-d');
        $details->monthly_selery = $request->monthly_selery;
        $details->emp_department_name = $request->emp_department_name;
        $details->emp_address = $request->emp_address;
        $details->emp_father_mobile_no = $request->emp_father_mobile_no;
        $details->emp_mother_mobile_no = $request->emp_mother_mobile_no;
        $details->bank_no = $request->bank_no;
        $details->bank_name = $request->bank_name;
        $details->emp_brother_sister_mobile_no = $request->emp_brother_sister_mobile_no;
        $details->emp_birthday_date = Carbon::parse($request->emp_birthday_date)->format('Y-m-d');
        $details->emp_notes = $request->notes;

        // Handle emp_document uploads (only update if new documents are provided)
        if ($request->hasFile('emp_document') && count($request->file('emp_document')) > 0) {
            // Step 1: Initialize an array to hold the new documents
            $empDocuments = [];

            // Step 2: Add the newly uploaded documents to the array
            foreach ($request->file('emp_document') as $empDocument) {
                $empImgName = 'lv_' . rand() . '.' . $empDocument->extension();
                $empDocument->move(public_path('emp_document/'), $empImgName);
                $empDocuments[] = $empImgName;
            }

            // Step 3: Check if there are existing documents
            if ($details->emp_document) {
                // If there are existing documents, append the new ones to them
                $existingDocuments = explode(',', $details->emp_document); // Convert the existing document string to an array
                $empDocuments = array_merge($existingDocuments, $empDocuments); // Merge existing documents with new ones
            }

            // Step 4: Update the emp_document field with the combined list of existing and new documents
            $details->emp_document = implode(',', $empDocuments); // Convert the array back to a comma-separated string
        } else {
            // If no new documents are uploaded, retain the existing ones
            if ($details->emp_document) {
                $details->emp_document = $details->emp_document; // No change (keep existing documents)
            }
        }

        // Handle emp_bank_document upload (update only if file is provided)
        if ($request->hasFile('emp_bank_document')) {
            $details->emp_bank_document = $imgName;
        }

        // Handle profile image upload
        $profileimgName = $details->profile_image; // Retain current profile image by default

        // If there's a new profile image uploaded
        if ($request->hasFile('profile_image')) {
            // Check if there is an old profile image, and delete it
            if ($details->profile_image && file_exists(public_path('profile_image/' . $details->profile_image))) {
                unlink(public_path('profile_image/' . $details->profile_image));  // Delete the old image file
            }

            // Generate new profile image name
            $profileimgName = 'lv_' . rand() . '.' . $request->profile_image->extension();

            // Move the new profile image to the storage folder
            $request->profile_image->move(public_path('profile_image/'), $profileimgName);

            // Update the profile image name in the request data (for saving to the database)
            $requestData['profile_image'] = $profileimgName;
        }

        // Update the profile in the database with the new profile image (if any)
        $details->profile_image = $profileimgName;

        // Handle the employee's role
        $details->role = $request->role;
        $details->emp_team_head_id = $request->emp_team_head_id;

        // Save the updated employee record
        $details->save();
        return response()->json(['success' => true, 'message' => 'Employee details updated successfully']);
        // return redirect()->route('admin.employee')->with('success_inquiry', ' Employee Add successfully');
    }

    public function change_passowed(Request $request)
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

    public function EmployeeChangePassowed(Request $request)
    {
        $id = $request->id;
        $data = Admin::find($id);

        if ($data) {
            // Update the password
            $data->password = Hash::make($request->emp_password);
            $data->save(); // Use save() instead of update() for a single model instance

            return redirect()->back();

            // Redirect to the login page or any other page
            return redirect()->route('login'); // Adjust the route name as necessary
        }

        // If the admin is not found, you can handle it accordingly
        return redirect()->back()->withErrors(['error' => 'Admin not found.']);
    }


    public function emp_deleted(Request $request)
    {
        $id = $request->id;
        $delete = Admin::find($id);
        $delete->is_deleted = 1;
        $delete->update();
        return redirect()->back();
    }

    public function user_lock(Request $request)
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

    public function checkEmail(Request $request)
    {
        $empEmail = $request->input('emp_email');
        $addEmpEmail = $request->input('add_emp_email');
        $userId = $request->input('user_id');

        $exists = Admin::where(function ($query) use ($empEmail, $addEmpEmail) {
            $query->where('email', $empEmail)
                ->orWhere('email', $addEmpEmail);
        })
            ->where('id', '!=', $userId)
            ->exists();

        // Log the result of the email check
        \Log::info("Email exists: " . ($exists ? 'Yes' : 'No'));

        // Return response: true if the email doesn't exist, false if it does
        return response()->json(!$exists);
    }

    public function deleteEMPDocument(Request $request)
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

    public function deleteBankDocument(Request $request)
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

    public function deleteProfileDocument(Request $request)
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

    public function admin_employee_view($id)
    {
        $data = Admin::find($id);
        return view('admin_add.emp_detail_view', compact('data'));
    }
}
