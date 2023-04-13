<?php
namespace Hexxondiv\SwitchappLaravel;
use Illuminate\Support\ServiceProvider;

class SwitchAppServiceProvider extends ServiceProvider{
    public function register(){
        $this->app->bind('switchApp', function($app) {
            return new SwitchAppService($app);
        });
    }

    public function boot(){
        //
    }
}
