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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('range_for_user_project')->comment("for user projects range")->default(10)->after('notification_range');
            $table->integer('range_for_company_projects')->comment("for company projects range")->default(10)->after('range_for_user_project');
            $table->integer('range_for_nearby_projects')->comment("for nearby projects")->default(10)->after('range_for_company_projects');
            $table->integer('range_for_recommended_companies')->comment("for recommended companies")->default(10)->after('range_for_nearby_projects');
            $table->integer('range_for_nearby_companies')->comment("for nearby companies")->default(10)->after('range_for_recommended_companies');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('range_for_user_project');
            $table->dropColumn('range_for_company_projects');
            $table->dropColumn('range_for_nearby_projects');
            $table->dropColumn('range_for_recommended_companies');
            $table->dropColumn('range_for_nearby_companies');

        });
    }
};
