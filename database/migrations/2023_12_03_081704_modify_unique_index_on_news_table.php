<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropUnique(['title', 'source_id']);
            $table->unique(['title', 'source_id', 'data_source_id', 'published_at']);
        });
    }

    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->unique(['title', 'source_id']);
            $table->dropUnique(['title', 'source_id', 'data_source_id', 'published_at']);
        });
    }
};
