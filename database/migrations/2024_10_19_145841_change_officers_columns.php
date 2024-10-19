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
            // drop rank, division and badge number
            $table->dropColumn('rank');
            $table->dropColumn('division');
            $table->dropColumn('badge_number');

            // add address, phone number and email
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officers', function (Blueprint $table) {
            // drop address, phone number and email
            $table->dropColumn('address');
            $table->dropColumn('phone_number');
            $table->dropColumn('email');

            // add rank, division and badge number
            $table->string('rank')->nullable();
            $table->string('division')->nullable();
            $table->string('badge_number')->nullable();
        });
    }
};
