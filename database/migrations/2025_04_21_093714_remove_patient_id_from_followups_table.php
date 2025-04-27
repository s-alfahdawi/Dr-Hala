<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('followups', function (Blueprint $table) {
            // 🧨 حذف الـ foreign key أولاً
            $table->dropForeign(['patient_id']);

            // ✅ ثم حذف العمود
            $table->dropColumn('patient_id');
        });
    }

    public function down(): void
    {
        Schema::table('followups', function (Blueprint $table) {
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
        });
    }
};