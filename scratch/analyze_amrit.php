<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPackage;
use Illuminate\Contracts\Console\Kernel;

$amrit = User::where('name', 'like', '%Amrit%')->first() ?? User::find(24);

echo "Amrit User ID: {$amrit->id}, Name: {$amrit->name}\n";
echo "Sponsor Code: {$amrit->sponsor_code}, Referral Code: {$amrit->referral_code}\n";

echo "\n--- Direct Referrals ---\n";
$directs = User::where('sponsor_code', $amrit->referral_code)->get();
foreach ($directs as $d) {
    echo "Direct: ID {$d->id} | {$d->name} ({$d->referral_code}) | Status: {$d->status}\n";
    $pkgs = UserPackage::where('user_id', $d->id)->get();
    foreach ($pkgs as $p) {
        echo "   Package: \${$p->invested_amount} on {$p->created_at}\n";
    }
}

echo "\n--- All Downline Users & Packages ---\n";
$downlineIds = $amrit->getDownlineUserIds();
foreach ($downlineIds as $id) {
    $u = User::find($id);
    if ($u) {
        $pkgs = UserPackage::where('user_id', $u->id)->get();
        if ($pkgs->count() > 0) {
            echo "Downline ID {$u->id} | {$u->name} | Sponsor: {$u->sponsor_code}\n";
            foreach ($pkgs as $p) {
                echo "   Pkg: \${$p->invested_amount} on {$p->created_at}\n";
            }
        }
    }
}

echo "\n--- Amrit Matching Income Transactions ---\n";
$txns = Transaction::where('user_id', $amrit->id)->where('type', 'matching_income')->orderBy('created_at')->get();
foreach ($txns as $t) {
    echo "  {$t->created_at} | {$t->txn_number} | \${$t->amount} | {$t->description}\n";
}
