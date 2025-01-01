<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['id','name','currency','phone','address','email','company_name','project_name','client_payment_details','total_earning','earning_date'];
}
