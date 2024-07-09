<?php

require dirname(__DIR__) . '/vendor/autoload.php';

\PagHipperSDK\Auth::init(
    '{api_key}',
    '{token}'
);

try {
    $pagHiper = new \PagHipperSDK\PagHiper();

    $items = [];
    $items[] = (new \PagHipperSDK\Entities\Item())
        ->setItemId('1')
        ->setDescription('Descrição do produto')
        ->setQuantity(1)
        ->setPriceCents(30.00);

    $items[] = (new \PagHipperSDK\Entities\Item())
        ->setItemId('2')
        ->setDescription('Descrição do produto 2')
        ->setQuantity(2)
        ->setPriceCents(15.00);

    $payer = (new \PagHipperSDK\Entities\Payer())
        ->setPayerEmail('webmaster@dooca.com.br')
        ->setPayerName('Webmaster Dooca')
        ->setPayerCpfCnpj('11144477735')
        ->setPayerPhone('5139393660')
        ->setPayerStreet('Rua Sapiranga')
        ->setPayerNumber(90)
        ->setPayerComplement('Sala 204')
        ->setPayerDistrict('Mauá')
        ->setPayerCity('Novo Hamburgo')
        ->setPayerState('RS')
        ->setPayerZipCode(93548192);

    $transaction = (new \PagHipperSDK\Entities\Transaction())
        ->setOrderId('TESTE-' . rand(0, 10000))
        ->setNotificationUrl('https://url-de-notificaca.example')
        ->setDiscountCents(10.00)
        ->setShippingPriceCents(19.90)
        ->setShippingMethods('PAC')
        ->setFixedDescription(true)
        ->setDaysDueDate('3')
        ->setPayer($payer)
        ->setItems($items); // Pode ser utilizado setItem(), para settar item indívidual

    $transaction = $pagHiper->createTransaction($transaction);
} catch (\PagHipperSDK\Exception\ErrorException $e) {
    // Exception normalmente gerada pelo retorno do PagHiper
    echo $e->getMessage();
    die;
} catch (\Exception $e) {
    // Outras Exceptions, Auth e Invalid Arguments
    echo $e->getMessage();
    die;
}

echo $transaction->getResult() . PHP_EOL;
echo $transaction->getResponseMessage() . PHP_EOL;
echo $transaction->getTransactionId() . PHP_EOL;
echo $transaction->getCreatedDate() . PHP_EOL;
echo $transaction->getValueCents() . PHP_EOL;
echo $transaction->getStatus() . PHP_EOL;
echo $transaction->getOrderId() . PHP_EOL;
echo $transaction->getDueDate() . PHP_EOL;
echo $transaction->getBankSlip()->getDigitableLine() . PHP_EOL;
echo $transaction->getBankSlip()->getUrlSlip() . PHP_EOL;
echo $transaction->getBankSlip()->getUrlSlipPdf() . PHP_EOL;
echo $transaction->getHttpCode();
