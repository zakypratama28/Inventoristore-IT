<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique()->comment('e.g., hero, features, testimonials');
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->string('image_path')->nullable();
            $table->json('extra_data')->nullable()->comment('Additional JSON data for flexibility');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landing_page_sections');
    }
};
