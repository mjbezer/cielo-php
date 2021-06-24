<?php

namespace Mjbezer\Cielo;


class CallbackUrlSetup{


    public function setup() 
    {
        $protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        return $protocol.$host.env('CALLBACK_ROUTE');
    }


}




