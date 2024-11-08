<?php

namespace XaviCabot\FilamentLogViewer;

use Filament\Contracts\Plugin;
use Filament\Panel;
use XaviCabot\FilamentLogViewer\Pages\ViewLog;

class FilamentLogViewerPlugin implements Plugin
{
    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function getId(): string
    {
        return 'filament-filament-log-viewer';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function register(Panel $panel): void
    {
        $panel
            ->pages([
                ViewLog::class,
            ]);
    }

    public function boot(Panel $panel): void {}
}
