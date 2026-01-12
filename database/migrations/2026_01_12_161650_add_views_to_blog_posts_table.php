<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewsToBlogPostsTable extends Migration
{
    public function up()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            // Only add if column doesn't exist
            if (!Schema::hasColumn('blog_posts', 'views')) {
                $table->integer('views')->default(0)->after('published_at');
            }
        });
    }

    public function down()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            if (Schema::hasColumn('blog_posts', 'views')) {
                $table->dropColumn('views');
            }
        });
    }
}
