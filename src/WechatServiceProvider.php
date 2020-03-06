<?php
namespace zxf5115\Wechat;

use Illuminate\Support\ServiceProvider;

class WechatServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $config_file = __DIR__ . '/../config/config.php';

        $this->mergeConfigFrom($config_file, 'wechat');

        $this->publishes([
            $config_file => config_path('wechat.php')
        ], 'wechat');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('wechat', function ()
        {
            return new Wechat();
        });

        $this->app->alias('wechat', Wechat::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['wechat', Wechat::class];
    }
}
