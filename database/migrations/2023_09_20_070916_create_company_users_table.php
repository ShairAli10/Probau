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
        Schema::create('company_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->unsigned();
            $table->string('name')->default('');
            $table->string('phone_no')->default('');
            $table->string('image')->default('');
            $table->string('email')->default('');
            $table->string('designation')->default('');
            $table->string('joining_date')->default('');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_users');
    }
};
