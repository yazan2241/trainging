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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('middleName');
            $table->string('lastName');
            $table->string('studentId');
            $table->string('gender');
            $table->string('university');
            $table->string('college');
            $table->string('gpa');
            $table->string('phone');
            $table->string('email');
            $table->string('password');

            $table->string('image');
            $table->string('profileGroup');
            $table->string('country');
            $table->string('nationalId');
            $table->string('grandFather');
            $table->string('fullName');
            $table->string('gender');
            $table->string('degree');
            $table->string('term');
            $table->string('year');
            $table->string('hours');
            $table->string('supervisorName');
            $table->string('supervisorPhone');
            $table->string('startTraining');
            $table->string('endTraining');

            $table->string('ar');
            $table->string('cv');
            $table->string('er');
            $table->string('tr');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
