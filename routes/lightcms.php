<?php

use Illuminate\Support\Facades\Route;
use Nodesol\Lightcms\Http\Controllers\AuthController;
use Nodesol\Lightcms\Http\Controllers\PageController;
use Nodesol\Lightcms\Models\Page;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => config('lightcms.url_prefix'), 'middleware' => 'web'], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', function () {
            if (! auth(config('lightcms.guard'))->check()) {
                return redirect()->route('lightcms-admin-login');
            }

            return redirect()->route('lightcms-admin-dashboard');
        });

        Route::get('login', function () {
            return view('lightcms::admin.login');
        })->name('lightcms-admin-login');

        Route::get('dashboard', function () {
            return view('lightcms::admin.dashboard');
        })->name('lightcms-admin-dashboard');

        Route::post('login', [AuthController::class, 'login'])->name('lightcms-admin-postlogin');

        Route::group(['middleware' => 'auth:lightcms'], function () {
            Route::any('logout', [AuthController::class, 'logout'])->name('lightcms-admin-logout');

            Route::resource('pages', PageController::class)->only('index', 'edit', 'update')->names([
                'index' => 'lightcms-admin-pages-index',
                'edit' => 'lightcms-admin-pages-edit',
                'update' => 'lightcms-admin-pages-update',
            ]);
        });
    });

    Route::group(['prefix' => 'pages'], function () {
        Route::get('{slug}', function ($slug) {
            $page = Page::whereSlug($slug)->first();

            return view(config('lightcms.views_prefix').'.'.$page->name, ['page' => $page]);
        });
    });

});
