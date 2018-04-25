<?php

namespace JianhuaWang\PdfToImage;

use Illuminate\Support\ServiceProvider;

class PdfToImageServiceProvider extends ServiceProvider
{
     /**
     * 服务提供者加是否延迟加载.
     *
     * @var bool
     */
    protected $defer = true;
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('PdfToImage',function(){
            return new \JianhuaWang\PdfToImage\PdfToImageMaker();
        });
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['PdfToImage'];
    }
    
}
