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

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_doctor_role', 'doctor_role_id', 'doctor_id')
            ->withTimestamps();
    }
}
