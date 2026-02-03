<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code', 50)->unique();

            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->foreignId('service_id')
                  ->constrained('services')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->foreignId('package_id')
                  ->nullable()
                  ->constrained('packages')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            $table->date('event_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('location')->nullable();
            $table->text('brief')->nullable();

            $table->decimal('total_price', 12, 2)->default(0);

            $table->enum('status', [
                'pending',
                'confirmed',
                'in_progress',
                'done',
                'cancelled'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
