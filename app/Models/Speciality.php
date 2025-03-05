<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Speciality extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'title',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Speciality $speciality) {
            if ($speciality->isDeletable()) {
                abort(403, 'این تخصص دارای پزشک است و قابل حذف نمی‌باشد.');
            }
        });
    }

    public function isDeletable(): bool
    {
        return $this->doctors()->exists();
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
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
