<?php

namespace TradeSmarter\Tests;

use TradeSmarter\Exceptions\EmailAlreadyExists;
use TradeSmarter\Requests\Login;
use TradeSmarter\Requests\Register;

class UsersTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function testCountriesRetrieving()
    {
        $countries = $this->apiClient->countries();
        $this->assertNotEmpty($countries, 'Retrieved countries list is empty');
    }

    /**
     * @return \TradeSmarter\Responses\Country
     */
    public function getRandomCountry()
    {
        $countries = $this->apiClient->countries();
        shuffle($countries);

        return array_pop($countries);
    }

    public function testRegister()
    {
        $email = 'text'.time().'@gmail.com';
        $password = md5(rand());

        $request = new Register([
            'firstName' => $this->faker->firstName,
            'lastName'  => $this->faker->lastName,
            'email'     => $email,
            'confirmed' => 1,
            'password'  => $password,
            'phone'     => $this->faker->randomNumber(8),
            'country'   => $this->getRandomCountry()->getId(),
            'locale'    => 'en-US',
            'params'    => [],
            'lead'      => 0,
        ]);

        /** @var \TradeSmarter\Responses\Register $response */
        $response = $this->apiClient->register($request);
        $this->assertGreaterThan(0, $response->getId(), 'User is not registered, his ID not received');

        $request = new Login([
            'email'    => $email,
            'password' => $password,
        ]);

        /** @var \TradeSmarter\Responses\Login $response */
        $response = $this->apiClient->login($request);
        $this->assertNotEmpty($response->getSession(), 'Login failed, session not retrieved.');
    }

    public function testEmailAlreadyExistsException()
    {
        $email = 'test.2'.time().'@gmail.com';
        $password = md5(rand());

        $request = new Register([
            'firstName' => $this->faker->firstName,
            'lastName'  => $this->faker->lastName,
            'email'     => $email,
            'confirmed' => 1,
            'password'  => $password,
            'phone'     => $this->faker->randomNumber(8),
            'country'   => $this->getRandomCountry()->getId(),
            'locale'    => 'en-US',
            'params'    => [],
            'lead'      => 0,
        ]);

        /** @var \TradeSmarter\Responses\Register $response */
        $response = $this->apiClient->register($request);
        $this->assertTrue($response->isSuccess());

        try {
            $this->apiClient->register($request);
            $this->assertTrue(false, 'Abnormal registration behavior. Email already exists error not received.');
        } catch (EmailAlreadyExists $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false, '\TradeSmarter\EmailAlreadyExists exception not raised.');
        }
    }
}
