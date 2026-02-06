<?php

namespace MyVendor\Quotes\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use MyVendor\Quotes\QuotesServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            QuotesServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('cache.default', 'array');
    }
}
