<?php

namespace Database\Seeders;

use App\Models\Surgery;
use App\Models\Followup;
use App\Models\SurgeryType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class SurgeryMigrationSeederFromCSV extends Seeder
{
    public function run(): void
    {
        $hospitalMap = [1 => 3, 3 => 4, 4 => 5];
        $surgeryTypeMap = [1 => 6, 2 => 7, 3 => 8, 4 => 9, 6 => 11, 7 => 10];

        $file = storage_path('app/public/surgeries_bak.csv');
        if (!file_exists($file)) {
            print("❌ الملف غير موجود: $file\n");
            return;
        }

        print("🔁 قراءة الملف: $file\n");
        $rows = array_map('str_getcsv', file($file));
        $header = array_map('trim', array_shift($rows));

        $count = 0;
        foreach ($rows as $index => $row) {
            $data = array_combine($header, $row);

            if (! $data) {
                print("⚠️ صف غير صالح عند index=$index\n");
                continue;
            }

            $surgeryTypeId = $surgeryTypeMap[(int)$data['type_of_surgery']] ?? null;
            $hospitalId = $hospitalMap[(int)$data['hospital']] ?? null;

            if (!$surgeryTypeId || !$hospitalId) {
                print("⛔ تخطي العملية بسبب معرف غير صالح: SurgeryType={$data['type_of_surgery']}, Hospital={$data['hospital']}\n");
                continue;
            }

            $surgery = Surgery::create([
                'patient_id'      => $data['patient_id'],
                'age'             => $data['age'],
                'date_of_surgery' => $data['date_of_surgery'],
                'surgery_type_id' => $surgeryTypeId,
                'child_name'      => $data['child_name'] ?: null,
                'hospital_id'     => $hospitalId,
                'notes'           => $data['notes'] ?: null,
            ]);

            print("✅ عملية مضافة: ID={$surgery->id}, التاريخ={$data['date_of_surgery']}\n");

            // تقييم القيم
            $done3  = $data['followup_3_done'] ?? '0';
            $done9  = $data['followup_9_done'] ?? '0';
            $done39 = $data['followup_39_done'] ?? '0';
            $doneB  = $data['b_date_done'] ?? '0';

            print("🧪 قيمة قبل التنظيف: " . json_encode([$done3]) . "\n");
            print("🧪 قيمة قبل التنظيف: " . json_encode([$done9]) . "\n");
            print("🧪 قيمة قبل التنظيف: " . json_encode([$done39]) . "\n");
            print("🧪 قيمة قبل التنظيف: " . json_encode([$doneB]) . "\n");

            $statuses = [
                3   => self::cleanBool($done3),
                9   => self::cleanBool($done9),
                39  => self::cleanBool($done39),
                365 => self::cleanBool($doneB),
            ];

            print("🔍 تقييم الحالة: 3= \"$done3\", 9= \"$done9\", 39= \"$done39\", 365= \"$doneB\"\n");

            $templates = SurgeryType::find($surgeryTypeId)?->followupTemplates ?? [];

            foreach ($templates as $template) {
                $days = (int)$template->days_after_surgery;
                $status = $statuses[$days] ?? 0;

                Followup::updateOrCreate(
                    [
                        'surgery_id'           => $surgery->id,
                        'followup_template_id' => $template->id,
                    ],
                    [
                        'patient_id'    => $surgery->patient_id,
                        'followup_date' => Carbon::parse($surgery->date_of_surgery)->addDays($days),
                        'completed'     => $status,
                        'type'          => $template->name,
                        'notes'         => $template->message,
                    ]
                );

                print("🗓️ متابعة محدثة - اليوم +$days - الحالة: " . ($status ? 'تمت' : 'قيد الانتظار') . "\n");
            }

            $count++;
        }

        print("✅ تمت ترحيل {$count} عملية بنجاح.\n");
    }

    private static function cleanBool($value): int
    {
        $v = strtolower(trim((string) $value));
        return in_array($v, ['1', 'true'], true) ? 1 : 0;
    }
}