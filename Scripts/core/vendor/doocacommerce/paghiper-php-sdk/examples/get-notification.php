<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$notificaitonId = $_POST['notification_id'];
$transactionId = $_POST['transaction_id'];

\PagHipperSDK\Auth::init(
    '{api_key}',
    '{token}'
);

$transaction = new \PagHipperSDK\Entities\Transaction();

$transaction->setTransactionId($transactionId);
$transaction->setNotificationId($notificaitonId);

$pagHiper = new \PagHipperSDK\PagHiper();
try {
    $notification = $pagHiper->getNotification($transaction);
} catch (\PagHipperSDK\Exception\ErrorException $e) {
    // Exception normalmente gerada pelo retorno do PagHiper
    echo $e->getMessage();
    die;
} catch (\Exception $e) {
    // Outras Exceptions, Auth e Invalid Arguments
    echo $e->getMessage();
    die;
}

echo $notification->getResult() . PHP_EOL;
echo $notification->getResponseMessage() . PHP_EOL;
echo $notification->getOrderId() . PHP_EOL;
echo $notification->getStatus() . PHP_EOL;
echo $notification->getStatusDate() . PHP_EOL;
echo $notification->getDueDate() . PHP_EOL;
echo $notification->getValueCents() . PHP_EOL;
echo $notification->getValueCentsPaid() . PHP_EOL; // Pode ser null
echo $notification->getLatePaymentFine() . PHP_EOL; // Pode ser null
echo $notification->isPerDayInterest() . PHP_EOL; // Pode ser null
echo $notification->getEarlyPaymentDiscountsDays() . PHP_EOL; // Pode ser null
echo $notification->getEarlyPaymentDiscountsCents() . PHP_EOL; // Pode ser null
echo $notification->getOpenAfterDayDue() . PHP_EOL; // Pode ser null
echo $notification->getBankSlip()->getDigitableLine() . PHP_EOL;
echo $notification->getBankSlip()->getUrlSlip() . PHP_EOL;
echo $notification->getBankSlip()->getUrlSlipPdf() . PHP_EOL;
echo $notification->getHttpCode() . PHP_EOL;
