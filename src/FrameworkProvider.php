<?php

namespace daxter1987\Framework;
use Illuminate\Support\ServiceProvider;

class FrameworkProvider extends ServiceProvider {

    public function boot()
    {
        $this->commands([
            Commands\Create::class,
        ]);
    }

    public function register()
    {
    }
}
