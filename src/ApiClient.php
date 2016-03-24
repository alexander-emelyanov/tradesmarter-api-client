<?php

namespace TradeSmarter;

use GuzzleHttp;
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
        $url = $this->url.'/index/countries';
        $response = $this->request($url);
        $payload = new Payload($response);
        $countries = [];
        foreach ($payload->getData() as $countryInfo) {
            $countries[] = new Country($countryInfo['id'], $countryInfo['name'], $countryInfo['dialCode'], $countryInfo['defLang']);
        }

        return $countries;
    }

    /**
     * Registers a new user.
     *
     * @param \TradeSmarter\Requests\Register $request
     *
     * @return \TradeSmarter\Responses\Register
     */
    public function register(\TradeSmarter\Requests\Register $request)
    {
        $url = $this->url.'/index/register';
        $data = [
            'firstName' => $request->getFirstName(),
            'lastName'  => $request->getLastName(),
            'email'     => $request->getEmail(),
            'confirmed' => 1,
            'password'  => md5($request->getPassword()),
            'phone'     => $request->getPhone(),
            'country'   => $request->getCountry(),
            'locale'    => $request->getLocale(),
            'landing'   => json_encode($request->getParams()),
            'lead'      => 0,
        ];
        $response = $this->request($url, $data);

        // Ugly hack for unpredictable API. Some times this API returns JSON, sometimes - integer...
        try {
            $payload = new Payload($response);
        } catch (\Exception $e) {
            $payload = new Payload("{\"id\":$response}");
        }

        // $payload = new Payload($response);
        return new Register($payload);
    }

    /**
     * Logs a user in and provides a session token for authenticated actions. This can be done either by email/password,
     * or using the previous session token.
     *
     * @param \TradeSmarter\Requests\Login $request
     *
     * @return \TradeSmarter\Responses\Login
     */
    public function login(\TradeSmarter\Requests\Login $request)
    {
        $url = $this->url.'/index/login';
        $data = [
            'email'    => $request->getEmail(),
            'password' => md5($request->getPassword()),
        ];
        $response = $this->request($url, $data);
        $payload = new Payload($response);

        return new Login($payload);
    }

    /**
     * Send request to TradeSmarter API endpoint.
     *
     * @param string $url
     * @param array  $data
     *
     * @return string
     */
    protected function request($url, $data = [])
    {
        try {
            return $this->httpClient->post($url, ['form_params' => $data])->getBody()->getContents();
        } catch (GuzzleHttp\Exception\ServerException $exception) {
            return $exception->getResponse()->getBody()->getContents();
        }
    }
}
