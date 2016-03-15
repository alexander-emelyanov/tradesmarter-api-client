<?php

namespace TradeSmarter\Tests;

class CountriesTest extends TestCase
{
    public function __construct(){
        parent::__construct();
    }

    public function testCountries(){
        $countries = $this->apiClient->countries();
        $this->assertNotEmpty($countries, 'Retrieved countries list is empty');
        foreach ($countries as $country) {
            $this->assertNotEmpty($country->getId(), 'Country has not ID');
            $this->assertNotEmpty($country->getName(), 'Country has not name');
            $this->assertNotEmpty($country->getDialCode(), 'Country has not dial code');
            $this->assertNotEmpty($country->getDefaultLanguage(), 'Country has not default language');
        }
    }


}