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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('name')->default('');
            $table->string('image')->default('');
            $table->string('time')->default('');
            $table->string('lat')->default('');
            $table->string('long')->default('');
            $table->string('location')->default('');
            $table->longText('description')->default('');
            $table->json('services')->default("[]");
            $table->json('company_type')->default("[]");
            $table->integer('status')->comment("0-drafted, 1-open, 2-inProgress, 3-completed")->default(0);
            $table->string('project_type')->default('');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
