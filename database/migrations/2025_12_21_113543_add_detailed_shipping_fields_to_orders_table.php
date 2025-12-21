<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailedShippingFieldsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'shipping_name')) {
                $table->string('shipping_name')->nullable();
            }
            if (!Schema::hasColumn('orders', 'shipping_phone')) {
                $table->string('shipping_phone')->nullable();
            }
            if (!Schema::hasColumn('orders', 'shipping_city')) {
                $table->string('shipping_city')->nullable();
            }
            if (!Schema::hasColumn('orders', 'shipping_postal_code')) {
                $table->string('shipping_postal_code', 10)->nullable();
            }
            if (!Schema::hasColumn('orders', 'shipping_province')) {
                $table->string('shipping_province')->nullable();
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_name', 'shipping_phone', 'shipping_city', 'shipping_postal_code', 'shipping_province']);
        });
    }
}
