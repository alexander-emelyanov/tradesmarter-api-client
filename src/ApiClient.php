<?php

namespace TradeSmarter;

use GuzzleHttp;
use TradeSmarter\Exceptions\EmailAlreadyExists;
use TradeSmarter\Responses\Register;

class ApiClient
{
    const ERROR_EMAIL_ALREADY_EXISTS = 10;

    const ERROR_MISSING_FIELD = 11;
    /**
     * @var string
     */
    protected $url;

    /**
     * @var \GuzzleHttp\ClientInterface A Guzzle HTTP client.
     */
    protected $httpClient;

    public function __construct($url, GuzzleHttp\ClientInterface $httpClient = null)
    {
        $this->url = $url;
        $this->httpClient = $httpClient ? : new GuzzleHttp\Client();
    }

    /**
     * Returns a list of supported countries.
     *
     * @return \TradeSmarter\Responses\Country[]
     */
    public function countries()
    {
    }

    /**
     * @param \TradeSmarter\Request\Register $request
     *
     * @return \TradeSmarter\Responses\Register
     */
    public function register($request)
    {
        $url = $this->url . '/index/register';
        $data = [
            'firstName' => $request->getFirstName(),
            'lastName' => $request->getLastName(),
            'email' => $request->getEmail(),
            'confirmed' => 1,
            'password' => md5($request->getPassword()),
            'phone' => $request->getPhone(),
            'country' => $request->getCountry(),
            'locale' => $request->getLocale(),
            'landing' => json_encode($request->getParams()),
            'lead' => 0,
        ];

        try{
            $serverResponse = $this->httpClient->post($url, ['form_params' => $data])->getBody()->getContents();
            return new Register(intval($serverResponse));
        } catch (GuzzleHttp\Exception\ServerException $exception){
            $serverResponse = $exception->getResponse()->getBody()->getContents();
            $this->processFailedResponse(new Payload($serverResponse));
        }
    }

    protected function processFailedResponse(Payload $payload)
    {
        $errorCode = isset($payload['error']['code']) ? $payload['error']['code'] : null;
        switch ($errorCode) {
            case static::ERROR_EMAIL_ALREADY_EXISTS: {
                throw new EmailAlreadyExists($payload, "Email already exists");
            }
            default: {
                throw new Exception($payload, "Unknown error");
            }
        }
    }
}