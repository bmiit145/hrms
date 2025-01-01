<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leave_type extends Model
{
    use HasFactory;

    protected $table = 'leave_types';

    protected $fillable = ['id', 'leave_type'];

    // Relationship with Leave Management
    public function leaveManagements()
    {
        return $this->hasMany(Leave_management::class, 'leave_type', 'id');
    }
}