<?php

namespace Criarenet\Cielo;

use Cielo\API30\Ecommerce\CreditCard;

class BrandSetup{

    public function setup($brand)
    {
        switch($brand){
            /**
             * Bandeira Visa
             */
            case 'VISA' : 
                return CreditCard::VISA;
                break;

            /**
             * Bandeira Mastercard
             */
            case 'MASTERCARD' :
                return CreditCard::MASTERCARD;
                break;

            /**
             * Bandeira American Express
             */
            case 'AMEX' : 
                return CreditCard::AMEX;
                break;
            /**
             * Bandeira ELO
             */
            case 'ELO' : 
                return CreditCard::ELO;
                break;

            /**
             * Bandeira Aura
             */
            case 'AURA' : 
                return CreditCard::AURA;
                break;
            /**
             * Bandeira JCB
             */
            case 'JCB' : 
                return CreditCard::JCB;
                break;

            /**
             * Bandeira Diners
             */
            case 'DINERS' : 
                return CreditCard::DINERS;
                break;

            /**
             * Bandeira Discover
             */
            case 'DISCOVER' : 
                return CreditCard::DISCOVER;
                break;

            /**
             * Bandeira Hipercard
             */
            case 'HIPERCARD' : 
                return CreditCard::HIPERCARD;
                break;
        }
    }

}