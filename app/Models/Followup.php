<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Followup extends Model
{
    protected $fillable = [
        'surgery_id',
        'patient_id',
        'followup_date',
        'completed',
        'type',
        'notes',
        'followup_template_id',
    ];

    protected $casts = [
        'followup_date' => 'datetime',
        'completed' => 'boolean',
    ];

    public function surgery(): BelongsTo
    {
        return $this->belongsTo(Surgery::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function followupTemplate(): BelongsTo
    {
        return $this->belongsTo(FollowupTemplate::class);
    }
}