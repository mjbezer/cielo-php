<?php

namespace Criarenet\Cielo;

use Cielo\API30\Merchant;

use Cielo\API30\Ecommerce\Environment;
use Cielo\API30\Ecommerce\Sale;
use Cielo\API30\Ecommerce\CieloEcommerce;
use Cielo\API30\Ecommerce\Payment;
use Cielo\API30\Ecommerce\CreditCard;
use Cielo\API30\Ecommerce\RecurrentPayment;
use Cielo\API30\Ecommerce\Request\CieloRequestException;


class RecurrentCreditCardPayment{


    private $environmentSetup;
    private $brandSetup;
    private $recurrenceSetup;

    public function __construct(
        EnvironmentSetup $environmentSetup, 
        BrandSetup $brandSetup,
        RecurrentPaymentSetup $recurrenceSetup)

    {
        $this->environmentSetup = $environmentSetup;
        $this->brandSetup = $brandSetup;
        $this->recurrenceSetup = $recurrenceSetup;
    }

    public function recurrentTransaction($dataTransaction)
    {
    
        $environment = $this->environmentSetup->setup();
        $brand  = $this->brandSetup->setup($dataTransaction['brand']);
    
        $merchant = new Merchant($dataTransaction['merchant_id'], $dataTransaction['merchant_key']);
        $sale = new Sale($dataTransaction['sales_code']);
        $customer = $sale->customer($dataTransaction['client_name']);
        $payment = $sale->payment($dataTransaction['amount']);
        
        $payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
                ->creditCard($dataTransaction['security_code'], $brand)
                ->setExpirationDate($dataTransaction['expiration_date'])
                ->setCardNumber($dataTransaction['card_number'])
                ->setHolder($dataTransaction['holder_name']);
        
        
        $payment->recurrentPayment(true)->setInterval($this->recurrenceSetup->setup($dataTransaction['recurrence']));
        
        // Crie o pagamento na Cielo
        try {
            // Configure o SDK com seu merchant e o ambiente apropriado para criar a venda
            $sale = (new CieloEcommerce($merchant, $environment))->createSale($sale);
        
            $response = $sale->getPayment()->getRecurrentPayment()->getRecurrentPaymentId();

        } catch (CieloRequestException $e) {
            // Em caso de erros de integração, podemos tratar o erro aqui.
            // os códigos de erro estão todos disponíveis no manual de integração.
            $response = $e->getCieloError();
        }

        return $response;

    }
}
