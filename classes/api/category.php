<?php

namespace Openair\Api;

use Openair\Api\Abstract_Api;


class Category extends Abstract_Api
{
    protected $_node_name = 'Category';


    public function one()
    {
        return new Category\One( $this->client );
    }

    public function two()
    {
        return new Category\Two( $this->client );
    }

    public function three()
    {
        return new Category\Three( $this->client );
    }

    public function four()
    {
        return new Category\Four( $this->client );
    }

    public function five()
    {
        return new Category\Five( $this->client );
    }


}
