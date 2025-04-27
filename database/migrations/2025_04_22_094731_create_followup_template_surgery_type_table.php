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
        Schema::create('followup_template_surgery_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surgery_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('followup_template_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followup_template_surgery_type');
    }
};
