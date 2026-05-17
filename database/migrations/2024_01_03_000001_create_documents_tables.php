<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('group')->default('Umum'); // Grouping kategori
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->string('color', 20)->default('#DC2626');
            $table->json('templates')->nullable();   // array nama template
            $table->json('fields')->nullable();      // array field yang dibutuhkan
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('document_categories')->cascadeOnDelete();
            $table->string('title');
            $table->string('template_used')->nullable();
            $table->json('form_data');          // data form yang diisi user
            $table->string('color_theme')->nullable();
            $table->string('status')->default('draft'); // draft, completed
            $table->string('file_path')->nullable();    // path pdf yang sudah di-generate
            $table->timestamp('last_downloaded_at')->nullable();
            $table->integer('download_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
        Schema::dropIfExists('document_categories');
    }
};
