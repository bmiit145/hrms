<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\OTsheet;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\RequestStack;

class OvertimeController extends Controller
{
    public function index(Request $request)
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
        return view('admin_add.OverTime.index', compact('employee','data','first_emp'));
    }

    public function store(Request $request)
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

    public function edit(Request $request)
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

    public function delete(Request $request)

    {
        $id = $request->id;
        $data = OTsheet::find($id);
        $data->delete();
        return back();
    }
    
}
