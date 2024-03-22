<?php

use Illuminate\Support\Facades\Route;
use Nodesol\Lightcms\Http\Controllers\AuthController;
use Nodesol\Lightcms\Http\Controllers\PageController;
use Nodesol\Lightcms\Models\Page;

Route::group(['middleware' => 'web'], function () {

    Route::group(['prefix' => config('lightcms.admin_url_prefix')], function () {
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

            Route::resource('pages', PageController::class)->only('index', 'edit', 'update', 'store')->names([
                'store' => 'lightcms-admin-pages-store',
                'index' => 'lightcms-admin-pages-index',
                'edit' => 'lightcms-admin-pages-edit',
                'update' => 'lightcms-admin-pages-update',
            ]);
            Route::get('pages/{page}/contents', [PageController::class, 'contents'])->name('lightcms-admin-contents-index');
            Route::post('pages/{page}/contents', [PageController::class, 'contentStore'])->name('lightcms-admin-contents-store');
        });
    });

    Route::group(['prefix' => config('lightcms.pages_url_prefix')], function () {
        Route::get('{slug}', function ($slug) {
            $page = Page::whereSlug($slug)->first();
            if(!$page || !$page->id){
                abort(404);
            }

            return view(config('lightcms.views_prefix').'.'.$page->name, ['page' => $page]);
        });
    });

});
