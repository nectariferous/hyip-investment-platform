<?php

namespace PagHipperSDK;

use PagHipperSDK\Entities\Transaction;
use PagHipperSDK\Entities\TransactionListFilters;
use PagHipperSDK\Entities\TransactionPix;
use PagHipperSDK\Exception\ValidationException;
use PagHipperSDK\Request\Request;
use PagHipperSDK\Response\CancelTransaction;
use PagHipperSDK\Response\CreateTransaction;
use PagHipperSDK\Response\CreateTransactionPix;
use PagHipperSDK\Response\GetTransaction;
use PagHipperSDK\Response\GetTransactionPix;

class PagHiper
{
    /**
     * Cria a transaction e retorna.
     *
     * @param Transaction $transaction
     * @return CreateTransaction
     * @throws Exception\AuthException
     * @throws Exception\ErrorException
     */
    public function createTransaction(Transaction $transaction)
    {
        $response = (new Request())->sendRequest('POST', '/transaction/create/', $transaction);

        return CreateTransaction::populate($response);
    }

    /**
     * Busca transações.
     *
     * @param TransactionListFilters|null $filters
     * @return mixed
     * @throws Exception\AuthException
     * @throws Exception\ErrorException
     */
    public function listTransactions(?TransactionListFilters $filters)
    {
        $response = (new Request())->sendRequest('POST', '/transaction/list/', $filters);

        // TODO: fazer um response para essa lista
        return $response['transaction_list_request'];
    }
    /**
     * Cria a transaction e retorna.
     *
     * @param TransactionPix $transaction
     * @return CreateTransactionPix
     * @throws Exception\AuthException
     * @throws Exception\ErrorException
     */
    public function createTransactionPix(TransactionPix $transaction)
    {
        $response = (new Request())->sendRequest('POST', 'https://pix.paghiper.com/invoice/create/', $transaction);
        
        return CreateTransactionPix::populate($response);
    }

    /**
     * Consulta uma transicação.
     *
     * @param string $transactionId
     * @return GetTransaction
     * @throws Exception\AuthException
     * @throws Exception\ErrorException
     */
    public function getTransaction(string $transactionId)
    {
        $transaction = new Transaction();
        $transaction->setTransactionId($transactionId);

        $response = (new Request())->sendRequest('POST', '/transaction/status/', $transaction);

        return GetTransaction::populate($response);
    }

    /**
     * Cancela uma transição.
     *
     * @param string $transactionId
     * @return CancelTransaction
     * @throws Exception\AuthException
     * @throws Exception\ErrorException
     * @throws ValidationException
     */
    public function cancelTransaction(string $transactionId)
    {
        if (!($transactionId ?? false)) {
            throw new ValidationException('Missing transaction_id', 400);
        }

        $transaction = new Transaction();
        $transaction->setTransactionId($transactionId);
        $transaction->setStatus('canceled');

        $response = (new Request())->sendRequest('POST', '/transaction/cancel/', $transaction);

        return CancelTransaction::populate($response);
    }

    /**
     * Consulta uma notificação.
     *
     * @param Transaction $transaction
     * @return GetTransaction
     * @throws Exception\AuthException
     * @throws Exception\ErrorException
     */
    public function getNotification(Transaction $transaction)
    {
        $response = (new Request())->sendRequest('POST', '/transaction/notification/', $transaction);

        // Utilizando o Response da getTransaction, não tem todos os campos, porém possuí todos os necessários
        return GetTransaction::populate($response);
    }

    /**
     * Consulta uma notificação.
     *
     * @param TransactionPix $transaction
     * @return GetTransactionPix
     * @throws Exception\AuthException
     * @throws Exception\ErrorException
     */
    public function getNotificationPix(TransactionPix $transaction)
    {
        $response = (new Request())->sendRequest('POST', 'https://pix.paghiper.com/invoice/status/', $transaction);
       
        // Utilizando o Response da getTransactionPix, não tem todos os campos, porém possuí todos os necessários
        return GetTransactionPix::populate($response);
    }
}
