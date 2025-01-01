<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave_management extends Model
{
    use HasFactory;

    protected $table = 'leave_managements';

    protected $fillable = [
        'id',
        'user_id',
        'from_date',
        'to_date',
        'leave_type',
        'leave_reason',
        'status',
        'rejected_reason',
        'user_delete',
        'admin_delete'
    ];

    // Relationship with Admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'user_id', 'id'); // 'user_id' is the foreign key in leave_managements
    }

    // Relationship with Leave_type
    public function leaveType()
    {
        return $this->belongsTo(leave_type::class, 'leave_type', 'id');
    }
}

