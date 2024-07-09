<?php

require dirname(__DIR__) . '/vendor/autoload.php';

\PagHipperSDK\Auth::init(
    '{api_key}',
    '{token}'
);

$pagHiper = new \PagHipperSDK\PagHiper();

try {
    $response = $pagHiper->cancelTransaction('{transaction_id}');
} catch (\PagHipperSDK\Exception\ErrorException $e) {
    // Exception normalmente gerada pelo retorno do PagHiper
    echo $e->getMessage();
    die;
} catch (\Exception $e) {
    // Outras Exceptions, Auth e Invalid Arguments
    echo $e->getMessage();
    die;
}

echo $response->getResult() . PHP_EOL;
echo $response->getResponseMessage() . PHP_EOL;
echo $response->getHttpdCode() . PHP_EOL;
