<?php namespace Gufy\CpanelWhm;

use Illuminate\Support\ServiceProvider;

class CpanelWhmServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // $this->package('gufy/cpanel-whm');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('cpanel-whm', function(){
            return new CpanelWhm;
        });

        $this->publishes([
            dirname(__FILE__) . '/../../config/config.php' => config_path('cpanel-whm.php')
        ]);

        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $aliases = config('app.aliases');

            // Alias the Datatable package
            if (empty($aliases['CpanelWhm'])) {
                $loader->alias('CpanelWhm', 'Gufy\CpanelWhm\Facades\CpanelWhm');
            }
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
