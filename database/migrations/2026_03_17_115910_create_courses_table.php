<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('category_id')->index()->constrained();
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->string('duration')->nullable(); // e.g., "6 weeks", "12 hours"
            $table->integer('students_count')->default(0);
            $table->decimal('rating', 3, 2)->nullable();
            $table->boolean('is_new')->default(false);
            $table->string('status')->default('active'); // active, draft, archived
            $table->json('objectives')->nullable();
            $table->json('requirements')->nullable();
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
