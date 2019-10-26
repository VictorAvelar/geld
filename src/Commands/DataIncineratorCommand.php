<?php


namespace VictorAvelar\Geld\Commands;

use DateTime;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use VictorAvelar\Geld\Models\CurrencyHistory;

class DataIncineratorCommand extends Command
{
    protected $signature = 'geld:incinerate';

    protected $description = 'Removes records older than the specified incineration threshold';

    /**
     * DataIncineratorCommand constructor.
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
        if (config('geld.incinerator')) {
            $edge = new DateTime('@'. strtotime('- '.config('geld.incinerate_after')));

            CurrencyHistory::where('created_at', '<', $edge)
                ->forceDelete();

            Log::info("Data incinerated successfully");
        }
    }
}
