<?php

namespace TradeSmarter;

use GuzzleHttp;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use TradeSmarter\Requests\Login as LoginRequest;
use TradeSmarter\Requests\Transactions as TransactionsRequest;
use TradeSmarter\Responses\Country;
use TradeSmarter\Responses\Login as LoginResponse;
use TradeSmarter\Responses\Register;
use TradeSmarter\Responses\Transactions as TransactionsResponse;

class ApiClient implements LoggerAwareInterface
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

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger = null;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
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
    public function login(LoginRequest $request)
    {
        $url = $this->url.'/index/login';
        $data = [
            'email'    => $request->getEmail(),
            'password' => md5($request->getPassword()),
        ];
        $response = $this->request($url, $data);
        $payload = new Payload($response);

        return new LoginResponse($payload);
    }

    /**
     * Gets a user’s paginated transaction history.
     *
     * @param \TradeSmarter\Requests\Transactions $request
     *
     * @return \TradeSmarter\Responses\Transactions
     */
    public function transactions(TransactionsRequest $request)
    {
        $loginResponse = $this->login(new LoginRequest([
            'email'    => $request->getEmail(),
            'password' => $request->getPassword(),
        ]));

        $url = $this->url.'/user/transactions';
        $data = [
            'session'   => $loginResponse->getSession(),
            'formatted' => $request->isFormatted(),
        ];
        $response = $this->request($url, $data);
        $payload = new Payload($response);

        return new TransactionsResponse($payload);
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
            return (string) $this->getHttpClient()->post($url, ['form_params' => $data])->getBody();
        } catch (GuzzleHttp\Exception\ServerException $exception) {
            return (string) $exception->getResponse()->getBody();
        }
    }

    protected function getHttpClient()
    {
        if (!is_null($this->httpClient)) {
            return $this->httpClient;
        }

        $stack = GuzzleHttp\HandlerStack::create();

        if ($this->logger instanceof LoggerInterface) {
            $stack->push(GuzzleHttp\Middleware::log(
                $this->logger,
                new GuzzleHttp\MessageFormatter(GuzzleHttp\MessageFormatter::DEBUG)
            ));
        }

        $this->httpClient = new GuzzleHttp\Client([
            'handler'  => $stack,
        ]);

        return $this->httpClient;
    }
}
