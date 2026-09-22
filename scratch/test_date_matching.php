<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Contracts\Console\Kernel;

function getLegVolumeAtDate(User $user, Carbon $asOfDate): array
{
    $directs = User::where('sponsor_code', $user->referral_code)->get();
    if ($directs->isEmpty()) {
        return ['power_leg' => 0.0, 'remaining_leg' => 0.0, 'leg_volumes' => []];
    }

    $legVolumes = [];
    foreach ($directs as $direct) {
        // Get downline user IDs of this direct leg
        $downlineIds = $direct->getDownlineUserIds();
        $downlineIds[] = $direct->id;

        $vol = (float) UserPackage::whereIn('user_id', $downlineIds)
            ->where('created_at', '<=', $asOfDate)
            ->sum('invested_amount');

        $legVolumes[] = $vol;
    }

    rsort($legVolumes);
    $powerLeg = $legVolumes[0] ?? 0.0;
    $remainingLeg = array_sum(array_slice($legVolumes, 1));

    return [
        'power_leg' => $powerLeg,
        'remaining_leg' => $remainingLeg,
        'leg_volumes' => $legVolumes,
    ];
}

$dates = [
    '2026-09-14',
    '2026-09-15',
    '2026-09-16',
    '2026-09-17',
    '2026-09-18',
    '2026-09-19',
];

$users = User::where('status', 'active')->get();

foreach ($users as $user) {
    echo "=========================================================\n";
    echo "USER: {$user->name} ({$user->referral_code}) - ID: {$user->id}\n";
    echo "=========================================================\n";

    $alreadyMatchedVolume = 0.0;
    $totalMatchingEarned = 0.0;

    foreach ($dates as $dateStr) {
        $asOfDate = Carbon::parse($dateStr.' 23:59:59');
        $legStats = getLegVolumeAtDate($user, $asOfDate);
        $powerLeg = $legStats['power_leg'];
        $weakerLeg = $legStats['remaining_leg'];
        $cumMatched = min($powerLeg, $weakerLeg);

        $newMatched = max(0.0, $cumMatched - $alreadyMatchedVolume);
        $income = ($newMatched * 5.0) / 100.0;

        if ($newMatched > 0) {
            $alreadyMatchedVolume += $newMatched;
            $totalMatchingEarned += $income;
            $powerCarry = max(0.0, $powerLeg - $alreadyMatchedVolume);
            $weakerCarry = max(0.0, $weakerLeg - $alreadyMatchedVolume);

            echo "  [{$dateStr}] Power: \${$powerLeg} | Weaker: \${$weakerLeg} | Cum Matched: \${$cumMatched} | New Matched: \${$newMatched} | Income (5%): \${$income} | Carry P: \${$powerCarry}, W: \${$weakerCarry}\n";
        } else {
            $powerCarry = max(0.0, $powerLeg - $alreadyMatchedVolume);
            $weakerCarry = max(0.0, $weakerLeg - $alreadyMatchedVolume);
            if ($powerLeg > 0 || $weakerLeg > 0) {
                echo "  [{$dateStr}] No new matched volume. (Power: \${$powerLeg}, Weaker: \${$weakerLeg}, Carry P: \${$powerCarry}, W: \${$weakerCarry})\n";
            }
        }
    }

    echo "TOTAL MATCHING EARNED: \${$totalMatchingEarned}\n\n";
}
