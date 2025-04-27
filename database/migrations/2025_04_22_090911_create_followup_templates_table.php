<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('followup_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // مثل: "متابعة بعد 3 أيام"
            $table->integer('days_after_surgery'); // كم يوم بعد العملية
            $table->string('message')->nullable(); // رسالة التذكير أو التنبيه
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followup_templates');
    }
};
