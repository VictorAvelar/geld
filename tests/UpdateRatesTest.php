<?php

namespace VictorAvelar\Geld\Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use VictorAvelar\Geld\Events\RatesUpdated;
use VictorAvelar\Geld\Models\Currency;
use VictorAvelar\Geld\Models\CurrencyHistory;

class UpdateRatesTest extends BaseTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'testing']);
    }

    public function testItPullsTheRatesFromTheSource()
    {
        Event::fake();
        $exitCode = Artisan::call("geld:update");

        $this->assertEquals(0, $exitCode);

        Event::assertDispatched(RatesUpdated::class);

        $total = Currency::all()->count();
        $history = CurrencyHistory::all()->count();

        $this->assertEquals(1, $total);
        $this->assertEquals(1, $history);
    }
}
