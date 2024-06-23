<?php

use App\Models\UserProfile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(UserProfile::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('positionHeld');
            $table->date('startDate');
            $table->date('endDate')->nullable();
            $table->longText('reasonForLeaving')->nullable();
            $table->string('organisation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
