<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['id','client_id','project_name','amount','commission','text','total_earning','start_date','end_date','working_emp','payment','project_progress','is_delete'];

    public function getWorkingEmployee()
    {
        $employeeId = explode(',',$this->working_emp);
        return Admin::whereIn('id',$employeeId)->get();
    }

    public function getClientName()
    {
        return $this->hasOne(Client::class,'id','client_id');
    }

    public function getpayment()
    {
        return $this->hasMany(Payment::class,'project_id','id');
    }
}
