<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('portfolio_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')
                  ->constrained('portfolios')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->enum('media_type', ['image', 'video'])->default('image');
            $table->text('url');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_media');
    }
};
