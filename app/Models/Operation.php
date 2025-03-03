<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Operation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'status'];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Operation $operation) {
            if ($operation->isDeletable()) {
                abort(403, 'این عمل دارای جراحی ثبت شده است و قابل حذف نمی‌باشد.');
            }
        });
    }

    public function getCreatedAtShamsi()
    {
        return Jalalian::fromDateTime($this->created_at);
    }

    public function getUpdatedAtShamsi()
    {
        return Jalalian::fromDateTime($this->updated_at);
    }

    public function surgeries()
    {
        return $this->belongsToMany(Surgery::class, 'surgery_operation')
            ->withPivot(['amount'])
            ->withTimestamps();
    }

    public function isDeletable(): bool
    {
        return $this->surgeries()->exists();
    }
}
