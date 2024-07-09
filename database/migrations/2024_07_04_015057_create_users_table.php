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
            $table->longText("email")->nullable();
            $table->longText("avatar")->nullable();
            $table->longText("full_name")->nullable();
            $table->longText("country")->nullable();
            $table->longText("city")->nullable();
            $table->longText("address")->nullable();
            $table->longText("phone_number")->nullable();
            $table->longText("password")->nullable();
            $table->integer("age")->default(0);
            $table->longText("user_name");
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->double("version")->default(0);
            $table->string("ip")->nullable();
            $table->string("otp")->nullable();
            $table->tinyInteger("status")->default(1);
            $table->longText("refresh_token")->nullable();
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
