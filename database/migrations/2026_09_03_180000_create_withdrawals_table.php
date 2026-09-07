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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('trx_number')->unique();
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('charge', 15, 2)->nullable();
            $table->decimal('net_amount', 15, 2)->nullable();
            $table->string('usdt_address')->nullable();
            $table->string('wallet_type')->default('earning_wallet');
            $table->enum('status', ['pending', 'approved', 'completed', 'rejected'])->default('pending');
            $table->text('admin_remark')->nullable();
            $table->string('txn_hash')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
