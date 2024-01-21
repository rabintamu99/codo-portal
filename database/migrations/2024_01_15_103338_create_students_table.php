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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            // $table->string('first_name', 100);
            // $table->string('last_name', 100);
            // // $table->date('date_of_birth')->nullable();
            // // $table->string('phone', 15)->nullable();
            // // $table->text('address')->nullable();
            // // $table->string('major', 100)->nullable();
            // // $table->string('department', 100)->nullable();
            // // $table->date('enrollment_date')->nullable();
            // // $table->string('status', 50);
            // // $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
