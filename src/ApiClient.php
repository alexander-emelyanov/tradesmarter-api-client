<?php

namespace TradeSmarter;

class ApiClient
{

    /**
     * @var string
     */
    protected $url;

    public function construct($url){
        $this->url = $url;
    }

    /**
     * @param \TradeSmarter\Request\Register $request
     * @return \TradeSmarter\Response\Register
     */
    public function register($request){

    }

}