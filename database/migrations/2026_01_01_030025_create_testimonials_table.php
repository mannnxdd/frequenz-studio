<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')
                  ->nullable()
                  ->constrained('bookings')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            $table->string('customer_name', 150);
            $table->unsignedTinyInteger('rating');
            $table->text('message');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};

