<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowupTemplate extends Model
{
    protected $fillable = ['name', 'days_after_surgery', 'message'];

    public function surgeryTypes()
    {
        return $this->belongsToMany(SurgeryType::class);
    }
}