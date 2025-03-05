<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Invoice extends Model
{
    protected $fillable = [
        'doctor_id',
        'amount',
        'description',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
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