<?php

namespace Criarenet\Cielo;

use Cielo\API30\Merchant;
use Cielo\API30\Ecommerce\Sale;
use Cielo\API30\Ecommerce\CieloEcommerce;
use Cielo\API30\Ecommerce\Payment;
use Cielo\API30\Ecommerce\CreditCard;
use Cielo\API30\Ecommerce\Request\CieloRequestException;


class SingleCreditCardPayment {
    
    private $environmentSetup;
    private $brandSetup;

    public function __construct(
        EnvironmentSetup $environmentSetup, 
        BrandSetup $brandSetup)
    {
        $this->environmentSetup = $environmentSetup;
        $this->brandSetup = $brandSetup;
    }

    public function singleTransaction($dataTransaction)
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
        try {
             // Configure o SDK com seu merchant e o ambiente apropriado para criar a venda
            $sale = (new CieloEcommerce($merchant, $environment))->createSale($sale);

            // Com a venda criada na Cielo, já temos o ID do pagamento, TID e demais
            // dados retornados pela Cielo
            $paymentId = $sale->getPayment()->getPaymentId();

            // Com o ID do pagamento, podemos fazer sua captura, se ela não tiver sido capturada ainda
             $sale = (new CieloEcommerce($merchant, $environment))->captureSale($paymentId, $dataTransaction['amount'], 0);

            } catch (CieloRequestException $e) {
            // Em caso de erros de integração, podemos tratar o erro aqui.
            // os códigos de erro estão todos disponíveis no manual de integração.
            $sale = $e->getCieloError();
        }

        return $sale;
    }
}