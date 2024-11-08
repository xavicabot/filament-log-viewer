<?php

namespace XaviCabot\FilamentLogViewer;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentLogViewerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-log-viewer')
            ->hasViews();
    }
}
