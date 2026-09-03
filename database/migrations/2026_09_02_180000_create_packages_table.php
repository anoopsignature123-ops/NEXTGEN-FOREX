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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // e.g. PACKAGE 1, PACKAGE 2
            $table->decimal('min_amount', 15, 2)->nullable();
            $table->decimal('max_amount', 15, 2)->nullable();
            $table->decimal('daily_roi', 5, 2)->nullable(); // e.g. 0.50, 0.75, 1.00, 1.25, 1.50 %
            $table->integer('duration_days')->default(200); // 200 Days
            $table->decimal('total_return_multiplier', 5, 2)->default(2.00); // 2X Return
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
