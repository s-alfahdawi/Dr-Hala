<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    protected $fillable = [
        'surgery_id',
        'patient_id',
        'followup_date',
        'completed',
        'type',
        'notes',
        'followup_template_id', // ✅ أضف هذا
    ];

    protected $casts = [

        'followup_date' => 'datetime',
'completed' => 'boolean',
    ];

    public function surgery()
    {
        return $this->belongsTo(\App\Models\Surgery::class);
    }

    public function patient()
{
    return $this->belongsTo(Patient::class);
}

public function followupTemplate()
{
    return $this->belongsTo(FollowupTemplate::class);
}
}