<?php

namespace Mjbezer\Cielo;

use Cielo\API30\Ecommerce\RecurrentPayment;


class RecurrentPaymentSetup{

    public function setup($recurrence)
    {
        switch($recurrence){

            case 1:
                return RecurrentPayment::INTERVAL_MONTHLY;
                break;

            case 2:
                return RecurrentPayment::INTERVAL_BIMONTHLY;
                break;
      
            case 4:
                return RecurrentPayment::INTERVAL_QUARTERLY;
                break;

            case 6:
                return RecurrentPayment::INTERVAL_SEMIANNUAL;
                break;
        
            case 12:
                return RecurrentPayment::INTERVAL_ANNUAL;
                break;

        }
    }
}