<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company_Progress extends Model
{
    use HasFactory;
    protected $fillable = ['id','date','amount','desc','progress_type'];

    public function description()
    {
        return $this->hasOne(description::class, 'id', 'desc'); 
        
    }

}

