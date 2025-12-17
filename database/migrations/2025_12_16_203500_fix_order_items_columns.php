<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixOrderItemsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'product_name')) {
                $table->string('product_name')->after('product_id')->nullable();
            }
            if (!Schema::hasColumn('order_items', 'unit_price')) {
                $table->unsignedBigInteger('unit_price')->after('product_name')->default(0);
            }
            if (!Schema::hasColumn('order_items', 'subtotal')) {
                $table->unsignedBigInteger('subtotal')->after('quantity')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            //
        });
    }
}
