<?php

namespace TradeSmarter\Tests;

use TradeSmarter\ApiClient;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /** @var \TradeSmarter\ApiClient */
    protected $apiClient;

    /**
     * @var \Faker\Generator A Faker fake data generator.
     */
    protected $faker;

    /**
     * Sets up a test with some useful objects.
     */
    public function setUp()
    {
        $url = getenv('TRADESMARTER_URL');
        if (!$url) {
            throw new \Exception('Environment variable TRADESMARTER_URL is required');
        }
        $this->apiClient = new ApiClient($url);

        $this->faker = \Faker\Factory::create();
    }

    /**
     * Free resources.
     */
    public function tearDown()
    {
    }
}
