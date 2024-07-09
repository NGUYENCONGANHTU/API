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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('images');
            $table->double('price');
            $table->integer('category_id');
            $table->integer('trademark_id');
            $table->double('sale_price')->nullable();
            $table->text('is_view')->nullable();
            $table->text('is_purchases')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('heart')->default(0);
            $table->tinyInteger('star')->default(0);
            $table->tinyInteger('type')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
