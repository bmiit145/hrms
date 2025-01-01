<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTsheet extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'emp_id','date','start_time','end_time','total_hourse'];
}
