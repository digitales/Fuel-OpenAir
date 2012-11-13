<?php

namespace Openair\Api;

use Openair\Api\Abstract_Api;


class Schedule_Request extends Abstract_Api
{
    protected $_node_name = 'Schedulerequest';


    public function item()
    {
        return new Schedule_Request\Item( $this->client );
    }


}
