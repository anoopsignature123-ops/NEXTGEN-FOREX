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
        Schema::create('user_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');
            $table->decimal('invested_amount', 15, 2);
            $table->decimal('daily_roi', 5, 2); // ROI % at time of purchase
            $table->decimal('daily_roi_amount', 15, 2);
            $table->integer('duration_days')->default(200);
            $table->decimal('total_return_amount', 15, 2); // invested_amount * 2
            $table->decimal('paid_roi_amount', 15, 2)->default(0.00);
            $table->enum('status', ['active', 'completed'])->default('active');
            $table->timestamp('purchased_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_packages');
    }
};
