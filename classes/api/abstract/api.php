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

    protected $_node_name;

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


    protected function set_node_name( $node_name )
    {
        $this->_node_name = $node_name;
        return $this;
    }

    protected function get_node_name( )
    {
        return $this->_node_name;
    }


    /**
     * Find the item, or list of items from OpenAir
     *
     * @param integer $id || null
     *
     * @return array
     */
    function find( $id = null )
    {
        if ( ! $id ){
            $this->set_node( 'Read', array( $this->_node_name ), array( 'type' => $this->_node_name, 'method' => 'all', 'limit' => $this->limit ) );
        } else {
            $this->set_node( 'Read', array( $this->_node_name => array( 'id' => $id ) ), array( 'type' => $this->_node_name, 'method' => 'equal to', 'limit' => $this->limit ) );
        }

        $result = $this->post( array(), array( 'include_headers' => true ) );

        if ( isset( $result['Read'] ) && !empty( $result['Read'] ) ){
            $return = array(
                        'data'      => $result['Read'][ $this->_node_name ],
                        'status'    => array(
                                        'code' => $result['Read']['@attributes']['status'],
                                        'message' => \Openair\Error::get_error( $result['Read']['@attributes']['status'] )
                                        )
                        );
            return $return;
        } else {
            return false;
        }
    }

}
