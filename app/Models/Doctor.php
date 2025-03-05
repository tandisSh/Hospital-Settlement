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

    protected static function booted(): void
    {
        static::deleting(function (Doctor $doctor) {
            if ($doctor->isDeletable()) {
                abort(403, 'این پزشک دارای عمل جراحی ثبت شده است و قابل حذف نمی‌باشد.');
            }
        });
    }
    public function isDeletable(): bool
    {
        return $this->surgeries()->exists();
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

    public function roles()
    {
        return $this->belongsToMany(DoctorRole::class, 'doctor_doctor_role', 'doctor_id', 'doctor_role_id')
            ->withTimestamps();
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function surgeries()
    {
        return $this->belongsToMany(Surgery::class, 'surgery_doctor')
            ->withPivot(['doctor_role_id', 'amount'])
            ->withTimestamps();
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
