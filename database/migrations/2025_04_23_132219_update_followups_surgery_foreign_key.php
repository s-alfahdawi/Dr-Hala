<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('followups', function (Blueprint $table) {
            // نحذف المفتاح الأجنبي الحالي أولًا
            $table->dropForeign(['surgery_id']);

            // ثم نضيف المفتاح مع onDelete cascade
            $table->foreign('surgery_id')
                ->references('id')
                ->on('surgeries')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('followups', function (Blueprint $table) {
            $table->dropForeign(['surgery_id']);

            // نرجعه بدون onDelete cascade
            $table->foreign('surgery_id')
                ->references('id')
                ->on('surgeries');
        });
    }
};