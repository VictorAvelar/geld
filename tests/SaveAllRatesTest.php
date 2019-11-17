<?php


namespace VictorAvelar\Geld\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use VictorAvelar\Geld\Events\RatesUpdated;
use VictorAvelar\Geld\Models\Currency;
use VictorAvelar\Geld\Models\CurrencyHistory;

class SaveAllRatesTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'testing']);
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('geld.supported', []);
    }

    /** @test */
    public function testItSavesAllAvailableRatesIfSupportedIsEmpty()
    {
        Event::fake();
        $exitCode = Artisan::call("geld:update");

        $this->assertEquals(0, $exitCode);

        Event::assertDispatched(RatesUpdated::class);

        $total = Currency::all();
        $history = CurrencyHistory::all();

        $this->assertEquals(168, $total->count());
        $this->assertEquals(168, $history->count());
    }
}
