<?php

namespace Pnlinh\InfobipSms;

class InfobipSmsService
{
    /** @var int retry time */
    public const RETRY_TIME = 3;

    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /** @var string */
    private $postUrl = 'https://api.infobip.com/sms/1/text/single';

    /** @var array */
    private $header = ['Content-Type:application/json', 'Accept:application/json'];

    /** @var string */
    private $from;

    /**
     * InfobipSmsService constructor.
     *
     * @param $from
     * @param $username
     * @param $password
     */
    public function __construct($from, $username, $password)
    {
        $this->from = $from;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Set post data.
     *
     * @param $to
     * @param $text
     *
     * @return array
     */
    private function setPostData($to, $text)
    {
        return [
            'from' => $this->from,
            'to'   => (array) $to,
            'text' => $text,
        ];
    }

    /**
     * Do send sms.
     *
     * @see https://www.infobip.com/en/blog/step-by-step-sms-api-php-tutorial-create-your-new-web-app
     *
     * @param $to
     * @param $text
     *
     * @return array
     */
    public function send($to, $text)
    {
        $postDataJson = json_encode($this->setPostData($to, $text));

        // Set retry time if response is null or empty
        $retrytime = 0;
        retry_from_here:

        $ch = curl_init();
        // Setting options
        curl_setopt($ch, CURLOPT_URL, $this->postUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->username.':'.$this->password);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);

        // Response of the POST request
        $response = curl_exec($ch);

        if ($response === '' && $retrytime <= static::RETRY_TIME) {
            $retrytime++;
            goto retry_from_here;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $responseBody = json_decode($response);
        curl_close($ch);

        return [$httpCode, $responseBody];
    }
}
