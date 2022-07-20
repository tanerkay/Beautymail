<?php

namespace Snowfire\Beautymail;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class BeautymailServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/settings.php' => config_path('beautymail.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/beautymail'),
        ], 'public');

        $this->loadViewsFrom(__DIR__.'/views', 'beautymail');

        Event::listen(
            MessageSending::class,
            CssInlinerListener::class
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Beautymail::class,
            function () {
                return new Beautymail(
                    array_merge(
                        config('beautymail.view'),
                        [
                            'css' => !is_null(config('beautymail.css')) && count(config('beautymail.css')) > 0 ? implode(' ', config('beautymail.css')) : '',
                        ]
                    )
                );
            });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
