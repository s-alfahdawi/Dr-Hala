<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['name', 'phone'];

    public function surgeries()
    {
        return $this->hasMany(Surgery::class);
    }

    public function followups()
    {
        return $this->hasMany(\App\Models\Followup::class);
    }

    // لعرض الاسم + رقم الهاتف في الواجهة
    public function getDisplayNameAttribute(): string
    {
        return "{$this->name} - {$this->phone}";
    }
}



