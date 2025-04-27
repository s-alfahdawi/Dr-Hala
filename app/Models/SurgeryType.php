<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurgeryType extends Model
{
    protected $fillable = ['name'];

    public function surgeries()
    {
        return $this->hasMany(\App\Models\Surgery::class, 'surgery_type_id');
    }

    public function followupTemplates()
    {
        return $this->belongsToMany(\App\Models\FollowupTemplate::class);
    }
}