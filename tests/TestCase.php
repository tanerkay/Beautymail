<?php

namespace Snowfire\Beautymail\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Snowfire\Beautymail\BeautymailServiceProvider;

class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('beautymail', require __DIR__.'/../src/config/settings.php');
    }

    public function getPackageProviders($app): array
    {
        return [
            BeautymailServiceProvider::class,
        ];
    }
}
