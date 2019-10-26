<?php

namespace VictorAvelar\Geld\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use VictorAvelar\Fixer\Resources\LatestRatesResource;
use VictorAvelar\Geld\Events\RatesUpdated;

class UpdateExchangeRatesCommand extends Command
{
    protected $signature = 'geld:update
{--dry : Execute without saving to the database}
{--no-history : Do not track the history for this execution}';

    protected $description = 'Updates the exchange rates on currencies table';

    /**
     * @var LatestRatesResource
     */
    private $latestRatesResource;

    /**
     * UpdateExchangeRatesCommand constructor.
     *
     * @param LatestRatesResource $latestRatesResource
     */
    public function __construct(LatestRatesResource $latestRatesResource)
    {
        parent::__construct();
        $this->latestRatesResource = $latestRatesResource;
    }

    /**
     * Execute the update exchange rates workflow.
     *
     * @throws GuzzleException
     */
    public function handle()
    {
        $rates = $this->latestRatesResource->execute();

        $info = json_decode($rates->getBody()->getContents(), true);

        if ($this->option('dry')) {
            $this->printRates($info);
        } else {
            $this->saveExchangeRates($info['rates']);
            event(new RatesUpdated());
        }
        Log::info('Currency import completed');
    }

    /**
     * @param $info
     */
    private function printRates($info): void
    {
        $this->info("Rates pulled at {$info['timestamp']}");
        foreach ($info['rates'] as $code => $rate) {
            $this->info(sprintf('Current rate for %s is %f', $code, $rate));
        }
    }

    /**
     * Saves the information to the database.
     * @param array $rates
     */
    private function saveExchangeRates(array $rates)
    {
        $cu = now();
        $data = [];
        foreach ($rates as $code => $rate) {
            if (in_array($code, config('geld.supported'))) {
                $record = [
                    'code' => $code,
                    'rate' => $rate,
                    'created_at' => $cu,
                    'updated_at' => $cu
                ];

                Db::table('currencies')
                    ->updateOrInsert(
                        ['code' => $code],
                        $record
                    );

                $data[] = $record;
            }
        }

        if (!$this->option('no-history') or !config('geld.history_mode')) {
            Db::table('currency_history')->insert($data);
        }
    }
}
