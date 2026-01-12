<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('old_stock');
            $table->integer('new_stock');
            $table->integer('adjustment'); // Can be positive or negative
            $table->string('reason');
            $table->timestamps();
            
            $table->index(['product_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_movements');
    }
};
