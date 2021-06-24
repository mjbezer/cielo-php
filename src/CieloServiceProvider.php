<?php 

namespace Mjbezer\Cielo;

use Illuminate\Support\ServiceProvider;

class CieloServiceProvider extends ServiceProvider 
{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('singlePayment', function () {
            return new SingleCreditCardPayment();
        });
    }
}       