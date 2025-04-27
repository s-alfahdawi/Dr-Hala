<?php

namespace App\Models;

use App\Models\Followup;
use App\Models\Hospital;
use App\Models\SurgeryType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class Surgery extends Model
{
    protected $fillable = [
        'patient_id',
        'hospital_id',
        'surgery_type_id',
        'date_of_surgery',
        'age',
        'child_name',
        'notes',
    ];

    protected $casts = [
        'date_of_surgery' => 'datetime',
    ];

    // علاقات
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function surgeryType()
    {
        return $this->belongsTo(SurgeryType::class);
    }

    public function followups()
    {
        return $this->hasMany(Followup::class, 'surgery_id');
    }

    // اسم عرض مخصص للـ Select
    public function getDisplayNameAttribute(): string
    {
        $type = optional($this->surgeryType)->name ?? 'غير معروف';
        $date = optional($this->date_of_surgery)->format('Y-m-d');
        return $type . " بتاريخ " . $date;
    }

    protected static function booted(): void
{
    static::created(function (Surgery $surgery) {
        $templates = $surgery->surgeryType->followupTemplates;
    
        foreach ($templates as $template) {
            Followup::create([
                'surgery_id'             => $surgery->id,
                'patient_id'             => $surgery->patient_id,
                'followup_date'          => $surgery->date_of_surgery->copy()->addDays($template->days_after_surgery),
                'type'                   => $template->name,
                'notes'                  => $template->message,
                'followup_template_id'   => $template->id, // ✅ هذا هو المهم
            ]);
        }
    });

    static::updated(function (Surgery $surgery) {
        if ($surgery->isDirty('date_of_surgery')) {
            Log::info("🔁 Updating followups for surgery {$surgery->id}");
    
            foreach ($surgery->followups as $followup) {
                $template = $followup->followupTemplate;
                if ($template) {
                    $newDate = $surgery->date_of_surgery->copy()->addDays($template->days_after_surgery);
                    Log::info("🗓️ Updating followup {$followup->id} to {$newDate}");
                    $followup->update(['followup_date' => $newDate]);
                }
            }
        }
    });
}
}