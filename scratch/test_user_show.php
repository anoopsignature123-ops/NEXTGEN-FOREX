<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

$user = User::find(3);

if ($user) {
    $totalInvested = (float) $user->userPackages()->where('status', 'active')->sum('invested_amount');
    $totalEarnings = (float) $user->transactions()->where('type', 'credit')->sum('amount');
    echo 'USER ID 3: '.$user->name."\n";
    echo 'Total Invested: $'.number_format($totalInvested, 2)."\n";
    echo 'Total Earnings: $'.number_format($totalEarnings, 2)."\n";
    echo "QUERY EXECUTED SUCCESSFULLY WITHOUT ERRORS!\n";
} else {
    echo "User ID 3 not found.\n";
}
