<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department_name extends Model
{
    use HasFactory;
    protected $fillable = ['id','department_name'];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'emp_department_name', 'id'); 
    }
}
