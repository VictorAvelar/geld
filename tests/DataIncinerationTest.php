<?php


namespace VictorAvelar\Geld\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use VictorAvelar\Geld\Models\CurrencyHistory;

class DataIncinerationTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'testing']);
        $this->artisan('geld:update');
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('geld.incinerate_after', '1 month');
    }

    public function testDataIsIncinerated()
    {
        $t = \DateTime::createFromFormat('d-m-Y', '01-10-2019');
        CurrencyHistory::where('imported_at', '>', $t)
            ->update(['created_at' => $t, 'imported_at' => $t]);

        Artisan::call('geld:retention');
        $exitCode = Artisan::call('geld:incinerate');

        $this->assertEquals(0, $exitCode);
        $history = CurrencyHistory::all()->count();
        $this->assertEquals(0, $history);
        $deleted = CurrencyHistory::withTrashed()->get()->count();
        $this->assertEquals(0, $deleted);
    }
}
