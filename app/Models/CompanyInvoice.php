<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'company_name',
        'delivery_date',
        'submit_date',
        'amount',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
