<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar_url')->nullable();

            $table->timestamps();
        });

        Schema::create('time_capsules', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by_user_id')->default(0);

            $table->string('title')->nullable()->index();
            $table->string('reveal_date')->nullable();
            $table->boolean('is_revealed')->default(false);
            $table->string('color');
            $table->string('location');
            $table->boolean('is_surprise_mode');
            $table->enum('visibility', ['public', 'unlisted', 'private']);
            $table->enum('content_type', ['text', 'voice', 'image']);
            $table->text('content_text')->nullable()->fulltext(); // fullText for indexing, allowing for faster searching
            $table->string('content_voice_url')->nullable();
            $table->string('content_image_url')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('favorite_time_capsules', function (Blueprint $table) {
            $table->id();
            $table->integer('time_capsule_id')->default(0);
            $table->integer('user_id')->default(0);
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->integer('time_capsule_id')->default(0);
            $table->integer('user_id')->default(0);

            $table->text('content');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('time_capsules');
        Schema::dropIfExists('favorite_time_capsules');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('comments');
    }
};
