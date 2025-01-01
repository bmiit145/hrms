<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Make sure to import the SoftDeletes trait

class Invoice extends Model
{
    use HasFactory; // Correct usage of both HasFactory and SoftDeletes traits

    protected $fillable = [
        'date_issued',
        'due_date',
        'currency_id',
        'client_id',
        'subtotal',
        'discount_persentage',
        'sgst_persentage',
        'cgst_persentage',
        'discount',
        'sgst',
        'cgst',
        'total',
        'invoice_number',
        'is_delete',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}
