<?php

use Orchestra\Testbench\TestCase;
use XaviCabot\FilamentLogViewer\Models\Log;
use XaviCabot\FilamentLogViewer\FilamentLogViewerServiceProvider;

class LogTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            FilamentLogViewerServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function testLog()
    {
        $log = Log::withPath('tests')->get();

        $this->assertIsArray($log->toArray());
    }
}