<?php

namespace Nodesol\Lightcms;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Nodesol\Lightcms\Commands\LightcmsCommand;

class LightcmsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('lightcms')
            ->hasConfigFile('lightcms')
            ->hasViews()
            ->hasMigration('create_pages_table', 'create_page_contents_table', 'create_admin_users_table')
            ->hasCommand(LightcmsCommand::class);
    }
}
