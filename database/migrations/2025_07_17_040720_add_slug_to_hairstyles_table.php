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
        Schema::table('hairstyles', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hairstyles', function (Blueprint $table) {
            $dropColumn = $table->dropColumn('slug');
        });
    }
};
