<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Benefits;
use Carbon\Carbon;

class BenefitsController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        // Get month, year, and employee ID from the request, default to current month and year
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $emp = $request->input('emp');  // Employee ID

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
        return view('admin_add.Benefits.index', compact('employee', 'data', 'first_emp'));
    }

    public function store(Request $request)
    {
        // Handle the date formatting before storing it
        // $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d'); // Convert to 'YYYY-MM-DD'

        // Create a new Benefits record
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

    public function edit(Request $request)
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

    public function delete(Request $request)

    {
        $id = $request->id;
        $data = Benefits::find($id);
        $data->delete();
        return back();
    }
}
