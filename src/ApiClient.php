<?php

namespace TradeSmarter;

use GuzzleHttp;
use TradeSmarter\Exceptions\EmailAlreadyExists;
use TradeSmarter\Responses\Country;
use TradeSmarter\Responses\Login;
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
        $this->httpClient = $httpClient ?: new GuzzleHttp\Client();
    }

    /**
     * Returns a list of supported countries.
     *
     * @return \TradeSmarter\Responses\Country[]
     */
    public function countries()
    {
        $url = $this->url . '/index/countries';
        $response = $this->makeRequest($url);
        $payload = new Payload($response);
        $countries = [];
        foreach ($payload->getData() as $countryInfo){
            $countries[] = new Country($countryInfo['id'], $countryInfo['name'], $countryInfo['dialCode']);
        }
        return $countries;
    }

    /**
     * @param \TradeSmarter\Requests\Register $request
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
        $response = $this->makeRequest($url, $data);
        return new Register(intval(trim($response, '"')));
    }

    /**
     * Logs a user in and provides a session token for authenticated actions. This can be done either by email/password,
     * or using the previous session token.
     *
     * @param \TradeSmarter\Requests\Login $request
     * @return \TradeSmarter\Responses\Login
     */
    public function login($request){
        $url = $this->url . '/index/login';
        $data = [
            'email' => $request->getEmail(),
            'password' => md5($request->getPassword()),
        ];
        $response = $this->request($url, $data);
        $payload = new Payload($response);
        return new Login($payload);
    }

    protected function request($url, $data = []){
        try{
            return $this->httpClient->post($url, ['form_params' => $data])->getBody()->getContents();
        } catch (GuzzleHttp\Exception\ServerException $exception) {
            return $exception->getResponse()->getBody()->getContents();
        }
    }

    /**
     * @param $url
     * @param $data
     * @return string
     */
    protected function makeRequest($url, $data = []){
        try{
            return $this->httpClient->post($url, ['form_params' => $data])->getBody()->getContents();
        } catch (GuzzleHttp\Exception\ServerException $exception) {
            $serverResponse = $exception->getResponse()->getBody()->getContents();
            $this->processFailedResponse(new Payload($serverResponse));
        }
    }

    protected function processFailedResponse(Payload $payload)
    {
        $errorCode = isset($payload['error']['code']) ? $payload['error']['code'] : null;
        switch ($errorCode) {
            case static::ERROR_EMAIL_ALREADY_EXISTS: {
                throw new EmailAlreadyExists($payload, 'Email already exists');
            }
            default: {
                throw new Exception($payload, 'Unknown error. ' . print_r($payload, 1));
            }
        }
    }
}