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
        Schema::table('complaints', function (Blueprint $table) {
            // make the city_id column nullable
            Schema::disableForeignKeyConstraints();
            $table->unsignedBigInteger('city_id')->nullable()->change();
            Schema::enableForeignKeyConstraints();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            // make the city_id column non-nullable
            Schema::disableForeignKeyConstraints();
            $table->unsignedBigInteger('city_id')->nullable(false)->change();
            Schema::enableForeignKeyConstraints();
        });
    }
};
