<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->tinyInteger('duration_months')->unsigned();
            $table->unsignedBigInteger('total_price');
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->string('midtrans_order_id')->nullable()->unique();
            $table->text('snap_token')->nullable();
            // extensible: add notification_sent_at timestamp when notification system is implemented
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
