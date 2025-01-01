<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = [
        'id',
        'emp_id',
        'emp_name',
        'first_in',
        'last_out',
        'after_breck_first_in',
        'after_breck_last_out',
        'today_date',
        'ip_address',
        'status',
        'is_delete',
    ];

    public function get_today_attedance()
    {
        return $this->belongsTo(Admin::class, 'emp_id'); 
                }   

    public function get_attedance_sheet()
    {
        return $this->belongsTo(Admin::class, 'emp_id');

    }

    public function get_emp_name()
    {
        return $this->belongsTo(Admin::class, 'emp_id');
    }
        
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'emp_id');
    }

    public function overTime()
    {
        return $this->hasMany(OTsheet::class,'emp_id');
    }
    
}
