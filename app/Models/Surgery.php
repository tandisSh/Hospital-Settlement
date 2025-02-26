<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsToMany(Operation::class, 'surgery_operations');
    }
}
