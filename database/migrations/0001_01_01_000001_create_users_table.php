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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->default(2)->constrained('roles')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('referral_code')->unique(); // Main Member Identifier e.g. NGF-0967542
            $table->string('sponsor_code')->nullable(); // Sponsor's referral_code e.g. NGF-0000001
            $table->enum('position', ['left', 'right'])->nullable(); // Left or Right Binary Tree leg
            $table->enum('status', ['active', 'inactive'])->default('inactive'); // Default inactive until package purchased
            $table->decimal('deposit_wallet', 15, 2)->default(0.00); // For depositing funds & buying packages
            $table->decimal('earning_wallet', 15, 2)->default(0.00); // For ROI earnings, referral commissions, matching bonuses
            $table->timestamp('email_verified_at')->nullable();
            $table->string('wallet_address')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->string('image')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
