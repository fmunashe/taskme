<?php

use App\Models\RecordStatus;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ServiceCategory::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(RecordStatus::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('serviceName');
            $table->longText('serviceDescription');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_listings');
    }
};
