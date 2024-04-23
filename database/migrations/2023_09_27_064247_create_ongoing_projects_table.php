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
        Schema::create('ongoing_projects', function (Blueprint $table) {
            $table->id();
            $table->string('company_id')->default('');
            $table->string('project_id')->default('');
            $table->integer('status')->comment("1-open,2-in-progress,3-completed")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ongoing_projects');
    }
};
