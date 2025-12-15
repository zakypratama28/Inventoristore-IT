<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedBigInteger('unit_price'); // disalin dari product saat dimasukkan
            $table->timestamps();

            $table->unique(['user_id', 'product_id']); // 1 baris per produk per user
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
