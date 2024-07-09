<?php

namespace PagHipperSDK;

class Auth
{
    /**
     * Api para autenticação
     *
     * @var string
     */
    protected static $apiKey;

    /**
     * Token para autenticação
     *
     * @var string
     */
    protected static $token;

    /**
     * Setta as credenciais
     *
     * @param string$apiKey
     * @param string $token
     */
    public static function init(string $apiKey, string $token): void
    {
        self::$apiKey = $apiKey;
        self::$token = $token;
    }

    /**
     * @return mixed
     */
    public static function getApiKey()
    {
        return self::$apiKey;
    }

    /**
     * @return mixed
     */
    public static function getToken()
    {
        return self::$token;
    }
}
