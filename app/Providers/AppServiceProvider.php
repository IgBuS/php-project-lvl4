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
        if (env('REDIRECT_HTTPS')) {
            \URL::forceScheme('https');
        }
        \Form::component('bsSelect', 'components.form.select', [
            'name', 'values', 'value' => null, 'attributes' => []
        ]);
        \Form::component('bsTextarea', 'components.form.textarea', [
            'name', 'value' => null, 'attributes' => []
        ]);
        \Form::component('bsText', 'components.form.text', [
            'name', 'value' => null, 'attributes' => []
        ]);
    }
}
