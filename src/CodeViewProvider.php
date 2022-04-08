<?php
namespace Wqb\CodeView;
use Illuminate\Support\ServiceProvider;
class CodeViewProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/codeview.php');
        $this->publishes([
            __DIR__.'/../config/codemirror-5.31.0' => base_path('public/src/codemirror-5.31.0'),
        ]);
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('codeview', function ($app) {
            return new CodeView($app['config']);
        });
    }
}