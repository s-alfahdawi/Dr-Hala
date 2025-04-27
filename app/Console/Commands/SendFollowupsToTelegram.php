<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Followup;

class SendFollowupsToTelegram extends Command
{
    protected $signature = 'followups:telegram';
    protected $description = 'Send today\'s followups to Telegram automatically.';

    public function handle()
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        $followups = Followup::whereDate('followup_date', today())
            ->where('completed', false)
            ->with(['patient', 'surgery', 'followupTemplate'])
            ->get();

        if ($followups->isEmpty()) {
            $message = "📢 لا توجد متابعات مجدولة لليوم. 😇";
        } else {
            $count = $followups->count();

            $message = "📅 *متابعات اليوم:*\n";
            $message .= "عدد المتابعات: *{$count}*\n\n";

            foreach ($followups as $followup) {
                $patientName = $followup->patient->name ?? '-';
                $surgeryName = $followup->surgery->display_name ?? '-';
                $followupTypeName = $followup->followupTemplate->name ?? '-';

                $message .= "👩‍⚕️ *{$patientName}*\n";
                $message .= "🔹 نوع المتابعة: _{$followupTypeName}_\n";
                $message .= "🔹 العملية: _{$surgeryName}_\n\n";
            }
        }

        Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'Markdown',
        ]);

        $this->info('تم إرسال إشعار المتابعات بنجاح عبر تيليجرام.');
    }
}