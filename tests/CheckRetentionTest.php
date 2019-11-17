<?php


namespace VictorAvelar\Geld\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use VictorAvelar\Geld\Models\CurrencyHistory;

class CheckRetentionTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'testing']);
        $this->artisan('geld:update');
    }

    public function testOldDataIsSoftDeleted()
    {
        $t = \DateTime::createFromFormat('d-m-Y', '01-11-2019');
        CurrencyHistory::where('imported_at', '>', $t)
            ->update(['created_at' => $t, 'imported_at' => $t]);

        $exitCode = Artisan::call('geld:retention');

        $this->assertEquals(0, $exitCode);
        $history = CurrencyHistory::all()->count();
        $this->assertEquals(0, $history);
        $deleted = CurrencyHistory::withTrashed()->get()->count();
        $this->assertEquals(1, $deleted);
    }
}
