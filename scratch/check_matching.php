<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

$users = User::all();
foreach ($users as $u) {
    $txns = Transaction::where('user_id', $u->id)->where('type', 'matching_income')->get();
    if ($txns->count() > 0) {
        echo "User: {$u->name} (ID: {$u->id})\n";
        print_r($u->leg_volume_stats);
        echo 'Transactions (Total: $'.$txns->sum('amount')."):\n";
        foreach ($txns as $t) {
            echo "  {$t->created_at} | {$t->txn_number} | \${$t->amount} | {$t->description}\n";
        }
        echo "----------------------------------------\n";
    }
}
