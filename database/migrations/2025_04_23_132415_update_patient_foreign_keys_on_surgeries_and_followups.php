<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // surgeries.patient_id
        Schema::table('surgeries', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->foreign('patient_id')
                ->references('id')->on('patients')
                ->onDelete('cascade');
        });

        // followups.patient_id
        Schema::table('followups', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->foreign('patient_id')
                ->references('id')->on('patients')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('surgeries', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->foreign('patient_id')->references('id')->on('patients');
        });

        Schema::table('followups', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->foreign('patient_id')->references('id')->on('patients');
        });
    }
};