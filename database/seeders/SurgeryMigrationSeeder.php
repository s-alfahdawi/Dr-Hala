<?php

namespace Database\Seeders;

use App\Models\Surgery;
use App\Models\Followup;
use App\Models\SurgeryType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

class SurgeryMigrationSeeder extends Seeder
{
    public function run(): void
    {
        $hospitalMap = [1 => 3, 3 => 4, 4 => 5];
        $surgeryTypeMap = [1 => 6, 2 => 7, 3 => 8, 4 => 9, 6 => 11, 7 => 10];
        $file = database_path('seeders/sql/surgeries.sql');

        if (!File::exists($file)) {
            print("❌ الملف غير موجود: $file\n");
            return;
        }

        print("🔁 قراءة الملف: $file\n");
        $sql = File::get($file);
        preg_match_all("/\((.*?)\),?/s", $sql, $matches);

        $count = 0;

        foreach ($matches[1] as $index => $line) {
            $columns = str_getcsv($line, ',', "'");

            if (count($columns) < 16) {
                print("⚠️ صف غير مكتمل عند index=$index\n");
                continue;
            }

            [$id, $patientId, $age, $date, $typeOld, $childName, $hospitalOld, $notes,
                $day3, $day9, $day39, $bDate,
                $done3, $done9, $done39, $doneB] = $columns;

            $surgeryTypeId = $surgeryTypeMap[(int) $typeOld] ?? null;
            $hospitalId = $hospitalMap[(int) $hospitalOld] ?? null;

            if (! $surgeryTypeId || ! $hospitalId) {
                print("⛔ تخطي العملية بسبب معرّف غير صالح\n");
                continue;
            }

            $surgery = Surgery::create([
                'patient_id'      => $patientId,
                'age'             => $age,
                'date_of_surgery' => $date,
                'surgery_type_id' => $surgeryTypeId,
                'child_name'      => $childName ?: null,
                'hospital_id'     => $hospitalId,
                'notes'           => $notes ?: null,
            ]);

            print("✅ عملية مضافة: ID={$surgery->id}, التاريخ={$date}\n");

            $statuses = [
                3   => self::cleanBool($done3),
                9   => self::cleanBool($done9),
                39  => self::cleanBool($done39),
                365 => self::cleanBool($doneB),
            ];

            print("🔍 تقييم الحالة: 3= " . json_encode($done3) . ", 9= " . json_encode($done9) . ", 39= " . json_encode($done39) . ", 365= " . json_encode($doneB) . "\n");
            
            $templates = SurgeryType::find($surgeryTypeId)?->followupTemplates;

            foreach ($templates as $template) {
                $days = (int) $template->days_after_surgery;
                $status = $statuses[$days] ?? 0;

                $exists = Followup::where('surgery_id', $surgery->id)
                    ->where('followup_template_id', $template->id)
                    ->exists();

                if ($exists) {
                    print("↩️ تم تخطي المتابعة لأنها موجودة: يوم +$days\n");
                    continue;
                }

                Followup::create([
                    'surgery_id'           => $surgery->id,
                    'patient_id'           => $patientId,
                    'followup_template_id' => $template->id,
                    'followup_date'        => Carbon::parse($date)->addDays($days),
                    'completed'            => $status,
                    'type'                 => $template->name,
                    'notes'                => $template->message,
                ]);

                print("🗓️ متابعة مضافة - اليوم +{$days} - الحالة: " . ($status ? 'تمت' : 'قيد الانتظار') . "\n");
            }

            $count++;
        }

        print("✅ تمت ترحيل {$count} عملية بنجاح.\n");
    }

    // 🔁 Helper to clean boolean strings
    private static function cleanBool($value): bool
    {
        $v = strtolower(trim((string) $value));
        return in_array($v, ['1', 'true'], true);
    }
}