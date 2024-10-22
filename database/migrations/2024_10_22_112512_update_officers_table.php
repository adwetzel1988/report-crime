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
        Schema::table('officers', function (Blueprint $table) {
            $table->string('race')->nullable();
            $table->string('eye_color')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('nickname')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('work_location')->nullable();
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officers', function (Blueprint $table) {
            $table->dropColumn('race');
            $table->dropColumn('eye_color');
            $table->dropColumn('weight');
            $table->dropColumn('height');
            $table->dropColumn('nickname');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('work_location');
            $table->dropColumn('gender');
            $table->dropColumn('age');
        });
    }
};
