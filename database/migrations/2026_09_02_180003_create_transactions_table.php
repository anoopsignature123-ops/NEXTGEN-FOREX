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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('txn_number')->unique();
            $table->enum('wallet_type', ['deposit_wallet', 'earning_wallet'])->default('earning_wallet');
            $table->decimal('amount', 15, 2)->default(0.00);
            $table->decimal('charge', 15, 2)->default(0.00);
            $table->decimal('post_balance', 15, 2)->default(0.00);
            $table->string('trx_type', 5)->default('+');
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->string('reference_id')->nullable();
            $table->enum('status', ['completed', 'pending', 'cancelled'])->default('completed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
