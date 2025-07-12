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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('writer_id')->constrained('users')->cascadeOnDelete();

            $table->foreignId('editor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('title_slug')->unique();
            $table->string('image')->nullable();
            $table->text('content');
            $table->text('summary')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->foreignId('status_id')->constrained('statuses');

            $table->text('notes')->nullable();
            $table->foreignId('assigned_editor_id')->nullable()->constrained('users')->nullOnDelete();

            $table->boolean('comments_enable')->default(true);
            $table->foreignId('status_requestEdit')->nullable()->constrained('statuses')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
