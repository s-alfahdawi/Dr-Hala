<?php

namespace App\Observers;

use App\Models\Surgery;
use App\Models\Followup;
use App\Models\FollowupTemplate;
use Carbon\Carbon;

class SurgeryObserver
{
    public function created(Surgery $surgery): void
    {
        // جلب جميع قوالب المتابعة المسجلة
        $followupTemplates = FollowupTemplate::all();

        foreach ($followupTemplates as $template) {
            Followup::create([
                'surgery_id' => $surgery->id,
                'patient_id' => $surgery->patient_id,
                'followup_date' => Carbon::parse($surgery->date_of_surgery)->addDays($template->days_after_surgery),
                'type' => $template->name,
                'followup_template_id' => $template->id,
            ]);
        }
    }
}