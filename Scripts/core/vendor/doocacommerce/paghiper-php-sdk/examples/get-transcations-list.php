<?php

require dirname(__DIR__) . '/vendor/autoload.php';

\PagHipperSDK\Auth::init(
    '{api_key}',
    '{token}'
);

$pagHiper = new \PagHipperSDK\PagHiper();

try {
    $filters = (new \PagHipperSDK\Entities\TransactionListFilters())
        ->setPage(1)
        ->setLimit(1);

    $transactions = $pagHiper->listTransactions($filters);
    echo '<pre>';
    print_r($transactions);
} catch (\PagHipperSDK\Exception\ErrorException $e) {
    // Exception normalmente gerada pelo retorno do PagHiper
    echo $e->getMessage() . PHP_EOL;
    echo $e->getCode() . PHP_EOL;
} catch (\Exception $e) {
    // Outras Exceptions, Auth e Invalid Arguments
    echo $e->getMessage();
    die;
}