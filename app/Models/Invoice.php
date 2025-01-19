<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'coil_number',
        'width',
        'lenght',
        'thickness',
        'weight',
        'price',
    ];

    public function companyInvoice()
    {
        return $this->belongsTo(CompanyInvoice::class);
    }
}
