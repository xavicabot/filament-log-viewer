# Filament Log Viewer

This package allows you to easily add a log viewer to your Filament application. Inspired in rap2hpoutre/laravel-log-viewer

## Installation

Require the package using composer:

```bash
composer require xavicabot/filament-log-viewer
```

Publish the assets:

```bash
php artisan vendor:publish --provider="Xavicabot\FilamentLogViewer\FilamentLogViewerServiceProvider"
```

## Usage

This plugin adds a 'Log Viewer' functionality in your filament panel(s), letting you view your logs in a more user-friendly way.

## Registering the plugin

```bash

use XaviCabot\FilamentLogViewer\FilamentLogViewerPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            FilamentLogViewerPlugin::make(),
        ])
}
```

## Configuration

Once you have published the assets, you can configure the package by editing the `config/filament-log-viewer.php` file.

