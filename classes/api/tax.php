<?php

namespace Openair\Api;


use Openair\Api\Abstract_Api;


class Tax extends Abstract_Api
{

    public function location()
    {
        return new Tax\Location( $this->client );
    }

    public function rate()
    {
        return new Tax\Rate( $this->client );
    }
    
}
