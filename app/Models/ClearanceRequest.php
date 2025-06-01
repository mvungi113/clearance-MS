<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClearanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'student_name',
        'department',
        'status',
        'remarks',
        'library_status',
        'hostel_status',
        'financial_status',
        'sports_status',
        'hod_status',
        'estate_status',        
        'computer_lab_status',   
    ];

    public function student()
    {
        return $this->belongsTo(\App\Models\User::class, 'student_id');
    }
}


