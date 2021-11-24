<?php

namespace App\Providers;

use App\Classes\Dictionary;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class CustomViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('admin.sidebar', function ($view) {
            $view->with('dictItems', Dictionary::getDicts());
        });

        //TODO: add file version to all css, js, images
        View::composer('*', function ($view) {
            $view->with('fileVersion', time());
        });
    }
}
