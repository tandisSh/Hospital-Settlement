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

    protected static function booted(): void
    {
        static::deleting(function (Insurance $insurance) {
            if ($insurance->isDeletable()) {
                abort(403, 'این بیمه دارای جراحی ثبت شده است و قابل حذف نمی‌باشد.');
            }
        });
    }

    public function isDeletable(): bool
    {
        return $this->basicSurgeries()->exists() || $this->suppSurgeries()->exists();
    }

    public function basicSurgeries()
    {
        return $this->hasMany(Surgery::class, 'basic_insurance_id');
    }

    public function suppSurgeries()
    {
        return $this->hasMany(Surgery::class, 'supp_insurance_id');
    }

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
