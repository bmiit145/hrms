<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee_details extends Model
{
    use HasFactory;
    protected $table = 'employee_details';
    protected $fillable = ['id',
                'emp_name',
                'emp_address',
                'emp_mobile_no',
                'emp_email',
                'emp_document',
                'emp_bank_document',
                'emp_department_name',
                'joining_date',
                'emp_password',
                'is_deleted'
            ];
}
