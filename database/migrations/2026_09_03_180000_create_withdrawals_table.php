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
            $table->decimal('amount', 15, 2)->nullable(); // Requested gross amount ($)
            $table->decimal('charge', 15, 2)->nullable(); // 10% withdrawal deduction ($)
            $table->decimal('net_amount', 15, 2)->nullable(); // Net amount to be paid ($)
            $table->string('usdt_address')->nullable(); // USDT BEP20 wallet address
            $table->string('wallet_type')->default('earning_wallet');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_remark')->nullable();
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
