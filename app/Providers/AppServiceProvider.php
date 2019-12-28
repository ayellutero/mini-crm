<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('employees_import', function($attribute, $value, $parameters) {
            $extenstion = $value->getClientOriginalExtension();
            $valid = [
                'xlsx', 'csv'
            ];

            return in_array($extenstion, $valid);
        });
    }
}
