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
        Schema::table('ongoing_projects', function (Blueprint $table) {
            $table->string('start_time')->default('')->after('status');
            $table->string('end_time')->default('')->after('start_time');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ongoing_projects', function (Blueprint $table) {
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');

        });
    }
};
