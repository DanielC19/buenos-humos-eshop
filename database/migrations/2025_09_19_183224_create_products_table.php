<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->integer('price')->default(0);
            $table->string('sku', 100)->unique();
            $table->string('brand', 150)->nullable(false);
            $table->string('image', 255)->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')
                  ->references('id')->on('product_categories')
                  ->onDelete('restrict');

            $table->index(['name', 'brand']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
