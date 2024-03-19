<?php

namespace Nodesol\Lightcms;

use Nodesol\Lightcms\Commands\UserMakeCommand;
use Illuminate\Support\Facades\Config;
use Nodesol\Lightcms\Commands\PageContentMakeCommand;
use Nodesol\Lightcms\Commands\PageMakeCommand;
use Nodesol\Lightcms\Models\LightcmsUser;
use Nodesol\Lightcms\ViewComposers\LightCms;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasViewComposer('lightcms.*', LightCms::class)
            ->hasMigration('create_pages_table', 'create_page_contents_table', 'create_admin_users_table')
            ->hasCommand(PageMakeCommand::class, PageContentMakeCommand::class, UserMakeCommand::class);
    }

    public function bootingPackage()
    {
        Config::set('auth.guards.lightcms', [
            'driver' => 'session',
            'provider' => 'lightcms',
        ]);

        Config::set('auth.providers.lightcms', [
            'driver' => 'eloquent',
            'model' => LightcmsUser::class,
        ]);
    }
}
