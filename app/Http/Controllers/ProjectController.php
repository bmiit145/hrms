<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Project;
use Carbon\Carbon;

class ProjectController extends Controller
{
    public function index()
    {
        $getEmployee = Admin::orderBy('id', 'DESC')->where('is_deleted',0)->whereIn('role', [1, 2])->get();
        $data = Project::orderBy('id', 'DESC')->get();
        $getClient = Client::orderBy('id','DESC')->where('is_delete',0)->get();
        return view('admin_add.project.index', compact('getEmployee', 'data','getClient'));
    }

    public function store(Request $request)
    {
        $data = new Project();
        $data->client_id = $request->client_id;
        $data->project_name = $request->project_name;
        $data->amount = $request->amount;
        $data->commission = $request->commission;
        $data->text = $request->tax;
        $data->total_earning = $request->total_earning;
        $data->start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $data->end_date = Carbon::parse($request->end_date)->format('Y-m-d');
        $data->working_emp = !empty($request->working_employee) ? implode(',', $request->working_employee) : '';
        $data->payment = $request->payment;
        $data->project_progress = $request->project_progress;
        $data->save();
        return redirect()->back();
    }

    public function edit(Request $request)
    {
        $data = Project::find($request->id);
        $data->client_id = $request->client_id;
        $data->project_name = $request->project_name;
        $data->amount = $request->amount;
        $data->commission = $request->commission;
        $data->text = $request->tax;
        $data->total_earning = $request->total_earning;
        $data->start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $data->end_date = Carbon::parse($request->end_date)->format('Y-m-d');
        $data->working_emp = !empty($request->working_employee) ? implode(',', $request->working_employee) : '';
        $data->payment = $request->payment;
        $data->project_progress = $request->project_progress;
        $data->update();
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        try {
            $data = Project::findOrFail($request->id);
            $data->delete();  
            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting project.']);
        }
    }
}
