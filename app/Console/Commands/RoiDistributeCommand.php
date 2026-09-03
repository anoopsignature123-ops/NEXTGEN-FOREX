<?php

namespace App\Console\Commands;

use App\Services\Incomes\RoiIncomeService;
use Illuminate\Console\Command;

class RoiDistributeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roi:distribute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically distribute daily ROI yields to active package investment holders up to 2X cap';

    /**
     * Execute the console command.
     */
    public function handle(RoiIncomeService $roiService): int
    {
        $this->info('Starting Daily ROI Yield Distribution Process via Service Layer...');

        $result = $roiService->processAllDailyRoi();

        $this->info("Daily ROI Distribution Complete! Processed {$result['processed_contracts']} contracts. Total ROI Distributed: \$".number_format($result['total_roi_amount'], 2));

        return Command::SUCCESS;
    }
}
