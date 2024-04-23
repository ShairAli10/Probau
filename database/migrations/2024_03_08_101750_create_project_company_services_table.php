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
        Schema::create('project_company_services', function (Blueprint $table) {
            $table->id();
            $table->integer('project_company_type_id')->default(0);
            $table->integer('service_id')->default(0);
            $table->string('name')->default("");
            $table->longText('description')->default("");
            $table->integer('status')->default(0)->comment('1- requests open, 0- requests closed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_company_services');
    }
};
