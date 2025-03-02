<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Insurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'discount',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function surgeries()
    {
        return $this->hasMany(Surgery::class, 'basic_insurance_id')
            ->orWhere('supp_insurance_id', $this->id);
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
