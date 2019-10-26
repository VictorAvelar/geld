<?php

namespace VictorAvelar\Geld\Tests;

use Orchestra\Testbench\TestCase;
use VictorAvelar\Geld\GeldServiceProvider;

/**
 * Class BaseTestCase
 *
 * @package VictorAvelar\Geld\Tests
 * @author Victor Avelar <deltatuts@gmail.com>
 */
class BaseTestCase extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [GeldServiceProvider::class];
    }

    /**
     * {@inheritdoc}
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
    }
}
