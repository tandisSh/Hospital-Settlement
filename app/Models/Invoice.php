<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Invoice extends Model
{
    protected $fillable = ['doctor_id', 'amount', 'description', 'status'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function surgeries()
    {
        return $this->belongsToMany(
            Surgery::class,
            'doctor_surgery', // جدول واسط
            'doctor_id', // FK در جدول واسط برای doctor
            'surgery_id', // FK در جدول واسط برای surgery
            'doctor_id', // FK محلی در invoices
            'id' // FK مربوطه در surgeries
        )->withPivot(['invoice_id']); // اگر invoice_id در جدول واسط ذخیره می‌شود
    }
    public function getCreatedAtShamsi()
    {
        return Jalalian::fromDateTime($this->created_at);
    }
    public function getSurgeriedAtShamsi()
    {
        return Jalalian::fromDateTime($this->surgeried_at)->format('Y/m/d');
    }

    protected static function booted()
    {
        static::deleting(function ($invoice) {
            if (!$invoice->isDeletable()) {
                throw new \Exception('این فاکتور قابل حذف نیست.');
            }
        });
    }

    public function isDeletable()
    {
        return $this->status == 0;
    }
}
