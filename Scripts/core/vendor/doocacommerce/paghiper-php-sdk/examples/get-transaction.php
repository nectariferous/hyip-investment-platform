<?php

require dirname(__DIR__) . '/vendor/autoload.php';

\PagHipperSDK\Auth::init(
    '{api_key}',
    '{token}'
);

$pagHiper = new \PagHipperSDK\PagHiper();

try {
    $transaction = $pagHiper->getTransaction('{transaction_id}');
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
echo $transaction->getOrderId() . PHP_EOL;
echo $transaction->getStatus() . PHP_EOL;
echo $transaction->getStatusDate() . PHP_EOL;
echo $transaction->getDueDate() . PHP_EOL;
echo $transaction->getValueCents() . PHP_EOL;
echo $transaction->getValueCentsPaid() . PHP_EOL; // Pode ser null
echo $transaction->getLatePaymentFine() . PHP_EOL; // Pode ser null
echo $transaction->isPerDayInterest() . PHP_EOL; // Pode ser null
echo $transaction->getEarlyPaymentDiscountsDays() . PHP_EOL; // Pode ser null
echo $transaction->getEarlyPaymentDiscountsCents() . PHP_EOL; // Pode ser null
echo $transaction->getOpenAfterDayDue() . PHP_EOL; // Pode ser null
echo $transaction->getBankSlip()->getDigitableLine() . PHP_EOL;
echo $transaction->getBankSlip()->getUrlSlip() . PHP_EOL;
echo $transaction->getBankSlip()->getUrlSlipPdf() . PHP_EOL;
echo $transaction->getHttpCode() . PHP_EOL;
