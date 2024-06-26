<?php

use App\Models\WorkExperience;
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
        Schema::create('work_duties', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(WorkExperience::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('dutyDescription');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_duties');
    }
};
