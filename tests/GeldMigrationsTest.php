<?php

namespace VictorAvelar\Geld\Tests;

use Illuminate\Support\Facades\Schema;

class GeldMigrationsTest extends BaseTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'testing']);
    }

    public function testItRunsTheMigrations()
    {
        $schema = Schema::getColumnListing('currencies');
        $schema2 = Schema::getColumnListing('currency_history');
        $pub = [
            'code',
            'rate',
            'imported_at',
        ];

        foreach ($pub as $prop) {
            $this->assertContains($prop, $schema);
        }

        foreach ($pub as $prop) {
            $this->assertContains($prop, $schema2);
        }
    }
}
