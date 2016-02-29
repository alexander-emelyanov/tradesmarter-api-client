<?php

namespace TradeSmarter;

class ApiClient
{

    /**
     * @var string
     */
    protected $url;

    public function construct($url)
    {
        $this->url = $url;
    }

    /**
     * Returns a list of supported countries.
     * @return \TradeSmarter\Response\Country[]
     */
    public function countries()
    {
    }

    /**
     * @param \TradeSmarter\Request\Register $request
     * @return \TradeSmarter\Response\Register
     */
    public function register($request)
    {

    }

}