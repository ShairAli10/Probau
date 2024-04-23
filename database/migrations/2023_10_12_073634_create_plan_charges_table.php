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
        Schema::create('plan_charges', function (Blueprint $table) {
            $table->id();
            $table->integer('plan_id')->default(0);
            $table->string('name')->default('');
            $table->integer('price')->default(0)->comment('is considered to be in euro €');
            $table->integer('validity')->default(0)->comment('is considered in months');
            $table->string('description')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_charges');
    }
};
