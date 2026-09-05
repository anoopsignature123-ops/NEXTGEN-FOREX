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
        DB::statement("ALTER TABLE withdrawals MODIFY status ENUM('pending', 'approved', 'completed', 'rejected') NOT NULL DEFAULT 'pending'");

        if (! Schema::hasColumn('withdrawals', 'txn_hash')) {
            Schema::table('withdrawals', function (Blueprint $table) {
                $table->string('txn_hash')->nullable()->after('admin_remark');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('withdrawals', 'txn_hash')) {
            Schema::table('withdrawals', function (Blueprint $table) {
                $table->dropColumn('txn_hash');
            });
        }
    }
};
