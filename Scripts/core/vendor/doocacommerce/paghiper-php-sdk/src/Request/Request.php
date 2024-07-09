<?php

namespace PagHipperSDK\Request;

use PagHipperSDK\Auth;
use PagHipperSDK\Exception\AuthException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use PagHipperSDK\Exception\ErrorException;

class Request
{
    const API = 'https://api.paghiper.com';

    /**
     * Api para autenticação
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Token para autenticação
     *
     * @var string
     */
    protected $token;

    /**
     * Request constructor.
     * @throws AuthException
     */
    public function __construct()
    {
        $this->apiKey = Auth::getApiKey();
        $this->token = Auth::getToken();

        if (!($this->apiKey) || !($this->token)) {
            throw new AuthException('ApiKey or Token missing', 400);
        }
    }

    /**
     * Enviar request para PagHiper
     *
     * @param string $method
     * @param $uri
     * @param \JsonSerializable|null $content
     * @return bool|mixed
     * @throws ErrorException
     */
    public function sendRequest(string $method, $uri, \JsonSerializable $content = null)
    {
        try {
            $client = new \GuzzleHttp\Client([
                'base_uri' => self::API,
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json;UTF-8',
                ],
            ]);

            $content = \GuzzleHttp\json_encode($content);

            $request = new Psr7\Request($method, $uri, [], $content);
            $response = $client->send($request);

            $data = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
            $result = reset($data) ?? false;

            if (($result['result'] ?? false) === 'reject') {
                // Caso for recusado
                throw new ErrorException($result['response_message'] ?? 'Undefined Error', 400);
            }

            return $data;
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $data = \GuzzleHttp\json_decode($e->getResponseBodySummary($e->getResponse()), true);

                if ($data = (reset($data)['response_message'] ?? false)) {
                    // Tentar buscar mensagem de erro
                    throw new ErrorException($data, $e->getCode());
                }
            }

            throw new ErrorException('Undefined Error', $e->getCode());
        }
    }
}
