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
        // Settings table for global site configs (links, hero content, theme colors, etc.)
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });

        // Advertisements & Promo Banners
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('badge')->nullable();
            $table->text('description')->nullable();
            $table->string('button_text')->default('Batafsil');
            $table->string('button_url')->default('#');
            $table->string('image')->nullable();
            $table->string('position')->default('middle_feed'); // 'hero_bottom', 'middle_feed', 'sidebar', 'footer'
            $table->string('bg_gradient')->default('from-emerald-600 to-teal-800');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Biology categories / branches
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->default('bi-dna');
            $table->text('description')->nullable();
            $table->string('color')->default('emerald');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Biology articles & educational topics
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('image')->nullable();
            $table->string('read_time')->default('5 daqiqa');
            $table->unsignedBigInteger('views_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        // Webinars and Online Lessons
        Schema::create('webinars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('badge')->default('Jonli efir');
            $table->string('instructor_name');
            $table->string('instructor_title')->nullable();
            $table->string('date_time_text')->default('25-Oktabr, 19:00');
            $table->string('duration')->default('90 daqiqa');
            $table->boolean('is_free')->default(true);
            $table->string('price_text')->nullable();
            $table->text('description')->nullable();
            $table->string('join_link')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Stats Counters
        Schema::create('stats_counters', function (Blueprint $table) {
            $table->id();
            $table->string('number'); // e.g. 4000
            $table->string('suffix')->default('+'); // e.g. +
            $table->string('label'); // e.g. O'quvchilar
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Leads / Registration inquiries
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('interest')->nullable(); // e.g. "Vebinarga yozilish", "Botanika kursi", etc.
            $table->text('message')->nullable();
            $table->string('status')->default('new'); // 'new', 'contacted', 'completed'
            $table->timestamps();
        });

        // Interactive quiz questions
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->string('correct_option'); // 'a', 'b', 'c', 'd'
            $table->text('explanation')->nullable();
            $table->string('difficulty')->default('Ortacha');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('inquiries');
        Schema::dropIfExists('stats_counters');
        Schema::dropIfExists('webinars');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('site_settings');
    }
};
