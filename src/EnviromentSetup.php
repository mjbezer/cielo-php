<?php

namespace Criarenet\Cielo;

use Cielo\API30\Merchant;

use Cielo\API30\Ecommerce\Environment;

class EnvironmentSetup {

    public function setup()
    {
        $setDotEnv = env("ENVIROMENT_CIELO");
        if($setDotEnv == "SANDBOX") {
            return Environment::sandbox();
        }
        if ($setDotEnv == "PRODUCTION") {
            return Environment::production();
        }
    }
}