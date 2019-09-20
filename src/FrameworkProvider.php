<?php

namespace daxter1987\Framework;
use Illuminate\Support\ServiceProvider;

class FrameworkProvider extends ServiceProvider {

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'Framework');
        $this->commands([
            Commands\Create::class,
            Commands\ConfigureComposer::class,
        ]);
    }

    public function register()
    {
    }
}
