<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FollowupTemplate extends Model
{
    protected $fillable = ['name', 'days_after_surgery', 'message'];

    public function surgeryTypes(): BelongsToMany
    {
        return $this->belongsToMany(SurgeryType::class);
    }
}