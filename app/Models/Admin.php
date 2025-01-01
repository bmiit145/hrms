<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';
    protected $guard = 'admin';

    protected $fillable = [
        'id',
        'emp_id',
        'name',
        'password',
        'email',
        'role',
        'emo_name',
        'emp_address',
        'emp_father_mobile_no',
        'emp_mother_mobile_no',
        'emp_brother_sister_mobile_no',
        'emp_mobile_no',
        'emp_document',
        'emp_bank_document',
        'emp_department_name',
        'emp_team_head_id',
        'joining_date',
        'emp_birthday_date',
        'emp_notes',
        'profile_image',
        'is_lock',
        'is_deleted',

    ];

    // Relationship with Leave_management
    public function leaveManagements()
    {
        return $this->hasMany(Leave_management::class, 'user_id', 'id'); // user_id foreign key in leave_managements
    }

    // Relationship with Department_name
    public function department()
    {
        return $this->belongsTo(Department_name::class, 'emp_department_name', 'id');
    }

    public function page_role()
    {
        return $this->hasOne(Role::class, 'employee_id', 'id');
    }

 

  

}



