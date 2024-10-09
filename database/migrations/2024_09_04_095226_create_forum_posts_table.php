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
        Schema::create('forum_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');  // Post title
            $table->text('description');  // Post description
            $table->string('image_path')->nullable();  // Image path (optional)
            $table->string('youtube_link')->nullable();  // YouTube link (optional)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // User who created the post
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_posts');
    }
};
