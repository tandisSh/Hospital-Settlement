<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorRole extends Model
{
    use HasFactory;

    protected $table = 'doctor_roles';

    protected $fillable = [
        'title',
        'required',
        'quota',
        'status',
    ];

    protected $casts = [
        'required' => 'boolean',
        'status' => 'boolean',
    ];
}
