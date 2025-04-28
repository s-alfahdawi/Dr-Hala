<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $fillable = ['name', 'phone'];

    public function surgeries(): HasMany
    {
        return $this->hasMany(Surgery::class);
    }

    public function followups(): HasMany
    {
        return $this->hasMany(Followup::class);
    }

    public function getDisplayNameAttribute(): string
    {
        return "{$this->name} - {$this->phone}";
    }
}