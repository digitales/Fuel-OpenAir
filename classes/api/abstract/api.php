<?php

namespace Openair\Api;

use Openair;

use Fuel\Core\Request;
use Fuel\Core\Request_Curl;

/**
 * Abstract class for Api classes
 *
 * @author Ross Tweedie <r.tweedie@gmail.com>
 */
abstract class Abstract_Api implements Api_Interface
{
    /**
     * The client
     *
     * @var Client
     */
    protected $client;

    protected $limit = 500;

    /**
     * @param Client $client
     */
    public function __construct( Openair\Client $client )
    {
        $this->client = $client;
    }


    protected function set_node( $node, $params, $attributes = array())
    {
        $this->client->set_node( $node, $params, $attributes );
    }


    /**
     * {@inheritDoc}
     */
    protected function post( array $parameters = array(), $requestOptions = array())
    {
        return $this->client->post( $parameters, $requestOptions);
    }

    /**
     * {@inheritDoc}
     */
    protected function put( array $parameters = array(), $requestOptions = array())
    {
        return $this->client->put( $parameters, $requestOptions);
    }

    protected function get_openair_status_code( )
    {
        return $this->client->get_openair_status_code();
    }

}
