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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 120)->index();
            $table->unsignedBigInteger('main_data_source_id')->index()->comment('Data Source ID.');
            $table->unsignedBigInteger('source_id')->index()->comment('Source ID.');
            $table->string('title', 120);
            $table->string('author', 50)->nullable();
            $table->string('category', 50)->nullable();
            $table->string('description')->index();
            $table->text('content');
            $table->string('image')->nullable();
            $table->dateTime('published_at');

            $table->unique(['title', 'source_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
