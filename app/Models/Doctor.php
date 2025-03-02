<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'speciality_id',
        'national_code',
        'medical_number',
        'mobile',
        'password',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'password' => 'hashed',
    ];

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }
    public function roles()
    {
        return $this->belongsToMany(DoctorRole::class, 'doctor_role_assignments', 'doctor_id', 'doctor_role_id');
    }

    public function getCreatedAtShamsi()
    {
        return Jalalian::fromDateTime($this->created_at);
    }

    public function getUpdatedAtShamsi()
    {
        return Jalalian::fromDateTime($this->updated_at);
    }
}
