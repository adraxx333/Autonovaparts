<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->uuid('id')->primary(true);
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('image_url')->nullable();
            $table->uuid('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabla pivot para la relación muchos a muchos entre partes y modelos
        Schema::create('model_part', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('model_id');
            $table->uuid('part_id');
            $table->timestamps();

            $table->foreign('model_id')->references('id')->on('models')->onDelete('cascade');
            $table->foreign('part_id')->references('id')->on('parts')->onDelete('cascade');
            $table->unique(['model_id', 'part_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_part');
        Schema::dropIfExists('parts');
    }
};
