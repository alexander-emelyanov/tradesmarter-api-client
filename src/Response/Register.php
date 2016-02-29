<?php

namespace TradeSmarter\Response;

class Register
{
    /**
     * @var string
     */
    protected $id;

    public function construct($id){
        $this->id = $id;
    }

    /**
     * Returns the newly created userID.
     * @return string
     */
    public function getId(){
        return $this->id;
    }
}