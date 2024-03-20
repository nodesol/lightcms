<?php

namespace Nodesol\Lightcms;

use Illuminate\Support\Facades\Config;
use Nodesol\Lightcms\Commands\PageContentMakeCommand;
use Nodesol\Lightcms\Commands\PageMakeCommand;
use Nodesol\Lightcms\Commands\UserMakeCommand;
use Nodesol\Lightcms\Models\LightcmsUser;
use Nodesol\Lightcms\ViewComposers\Lightcms;
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
            ->hasViews('lightcms')
            ->hasViewComposer('lightcms.*', Lightcms::class)
            ->hasRoute('lightcms')
            ->hasMigrations(
                'create_pages_table',
                'create_page_contents_table',
                'create_admin_users_table'
            )
            ->hasCommands(
                PageMakeCommand::class,
                PageContentMakeCommand::class,
                UserMakeCommand::class
            );
    }

    public function bootingPackage()
    {
        $guard = config('lightcms.guard');
        Config::set("auth.guards.$guard", [
            'driver' => 'session',
            'provider' => 'lightcms',
        ]);

        Config::set("auth.providers.$guard", [
            'driver' => 'eloquent',
            'model' => LightcmsUser::class,
        ]);
    }
}
