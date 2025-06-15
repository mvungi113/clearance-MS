<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PalmPesaTransaction extends Model
{
    protected $table = 'palm_pesa_transactions';

    protected $fillable = [
        'reference',
        'phone',
        'amount',
        'transaction_id',
        'status',
        'palm_pesa_response',
    ];

    protected $casts = [
        'palm_pesa_response' => 'array',
        'amount' => 'decimal:2',
    ];
}
