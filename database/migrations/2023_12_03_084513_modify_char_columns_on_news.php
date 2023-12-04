<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('author', 150)->change();
            $table->text('description')->change();
            $table->text('image')->change();
            $table->string('title')->change();
        });
    }

    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('author', 50)->change(); // Original length
            $table->string('title', 120)->change();
            $table->string('description')->change();
            $table->string('image')->change();

        });
    }
};
