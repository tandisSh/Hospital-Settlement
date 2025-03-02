<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Surgery extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name',
        'patient_national_code',
        'basic_insurance_id',
        'supp_insurance_id',
        'document_number',
        'description',
        'surgeried_at',
        'released_at',
    ];

    protected $dates = [
        'surgeried_at',
        'released_at',
        'created_at',
        'updated_at'
    ];

    public function basicInsurance() {
        return $this->belongsTo(Insurance::class, 'basic_insurance_id');
    }

    public function suppInsurance() {
        return $this->belongsTo(Insurance::class, 'supp_insurance_id');
    }

    public function doctors() {
        return $this->belongsToMany(Doctor::class, 'surgery_doctor');
    }

    public function operations() {
        return $this->belongsToMany(Operation::class, 'surgery_operation');
    }

    public function getSurgeriedAtShamsi()
    {
        return Jalalian::fromDateTime($this->surgeried_at)->format('Y/m/d');
    }

    public function getReleasedAtShamsi()
    {
        return Jalalian::fromDateTime($this->released_at)->format('Y/m/d');
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
