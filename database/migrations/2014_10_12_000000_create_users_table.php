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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('');
            $table->string('email')->default('');
            $table->string('phone')->default('');
            $table->integer('email_verified')->default(0);
            $table->string('password')->default('');
            $table->integer('status')->comment("1-active, 0-inactive")->default(1);
            $table->string('user_type')->default('');
            $table->string('company_tax')->default('');
            $table->json('services')->default("[]");
            $table->string('company_type')->default("");
            $table->string('no_employee')->comment("number of employees")->default('');
            $table->string('email_code')->default('');
            $table->longText('description')->default('');
            $table->longText('g_token')->default('');
            $table->longText('a_code')->default('');
            $table->string('lat', 255)->default('');
            $table->string('long', 255)->default('');
            $table->longText('firebase_id')->default('');
            $table->longText('device_id')->default('');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
