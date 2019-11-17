<?php

namespace VictorAvelar\Geld\Commands;

use DateTime;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use VictorAvelar\Geld\Models\CurrencyHistory;

class CheckRetentionCommand extends Command
{
    protected $signature = 'geld:retention';

    protected $description = 'Soft deletes records older than the retention period config value';

    /**
     * CheckRetentionCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        if (config('geld.history_mode')) {
            $retention = '@'.strtotime('-'.config('geld.retention'));
            $edge = new DateTime($retention);
            CurrencyHistory::where('created_at', '<', $edge)
                ->delete();

            Log::info("History records soft deleted successfully");
        }
    }
}
