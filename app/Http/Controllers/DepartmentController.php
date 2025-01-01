<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Department_name;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
   public function department_view()
   {
      $department_view = DB::table('department_names')->where('is_deleted', 0)->get();
      return view('admin_add.department', compact('department_view'));

   }

   public function add_department(Request $request)
   {

      $request->validate([
         'department_name' => 'required'
      ]);
      $department = new Department_name;
      $department->department_name = $request->department_name;
      $department->save();
      return redirect()->back();
   }


   public function edit_department(Request $request)
   {
      $id = $request->id;
      $data = Department_name::find($id);
      $data->department_name = $request->department_name;
      $data->update();
      return redirect()->back();

   }

   public function delete_department(Request $request)
   {
      $id = $request->id;
      $data = Department_name::find($id);
      $data->is_deleted = 1;
      $data->update();
      return redirect()->back();
   }
}
