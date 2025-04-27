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
        Schema::create('surgeries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('hospital_id')->constrained()->onDelete('cascade');
            $table->foreignId('surgery_type_id')->constrained('surgery_types')->onDelete('cascade');
        
            $table->integer('age')->nullable();
            $table->date('date_of_surgery');
            $table->string('child_name')->nullable();
            $table->text('notes')->nullable();
        
            $table->date('followup_day_3')->nullable();
            $table->date('followup_day_9')->nullable();
            $table->date('followup_day_39')->nullable();
            $table->date('b_date')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surgeries');
    }
};
