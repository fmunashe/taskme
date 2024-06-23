<?php

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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->date('dob')->nullable();
            $table->string('idNumber')->nullable();
            $table->string('profession')->nullable();
            $table->enum('highestEductionQualification', ['Tertiary', 'Secondary', 'Degree', 'Diploma', 'Certificate', 'Ordinary Level Certificate', 'Advanced Level Certificate', 'Grade Seven'])->nullable();
            $table->longText('bio')->nullable();
            $table->enum('maritalStatus', ['Married', 'Single', 'Widow', 'Widower'])->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->string('religion')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
