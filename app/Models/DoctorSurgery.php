<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class DoctorSurgery extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'doctor_surgery';

    protected $fillable = [
        'doctor_id',
        'surgery_id',
        'invoice_id',
        'amount',
        'doctor_role_id',
    ];

    // ارتباط با مدل Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // ارتباط با مدل Surgery
    public function surgery()
    {
        return $this->belongsTo(Surgery::class);
    }

    // ارتباط با مدل Invoice
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    // ارتباط با مدل DoctorRole
    public function doctorRole()
    {
        return $this->belongsTo(DoctorRole::class, 'doctor_role_id');
    }


}
