<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Holiday;
use Carbon\Carbon;


use Illuminate\Http\Request;

class HolidayConteoller extends Controller
{
    public function Add_holiday()
    {
        $holidays = DB::table('holidays')->where('is_deleted', 0)->get();
        return view('admin_add.holiday', compact('holidays'));
    }

    public  function store(Request $request)
    {

        $request->validate([
            'holiday_name' => 'required',
            'holiday_date' => 'required',
            'holiday_end_date' => 'required',
        ]);
        $data = new  Holiday;
        $data->holiday_name = $request->holiday_name;
        $data->holiday_date = Carbon::parse($request->holiday_date)->format('Y-m-d');
        $data->end_date = Carbon::parse($request->holiday_end_date)->format('Y-m-d');
        $data->details = $request->details;
        $data->save();

        return redirect()->back();
    }


    public function edit(Request $request)
    {
        $id = $request->id;
        $data = Holiday::find($id);
        if ($data) {
            $data->holiday_name = $request->holiday_name;
            $data->holiday_date = Carbon::parse($request->holiday_date)->format('Y-m-d');
            $data->end_date = Carbon::parse($request->holiday_end_date)->format('Y-m-d');
            $data->details = $request->details;
            $data->update();
        }
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $delete = Holiday::find($id);
        $delete->is_deleted = 1;
        $delete->update();
        return redirect()->back();
    }

    public function user_holiday_list()
    {
        $data = DB::table('holidays')->where('is_deleted', 0)->get();
        return view('user.holidaylist', compact('data'));
    }
}
