<?php

namespace Openair\Api\Project;

use Openair\Api\Abstract_Api;


class Task extends Abstract_Api
{
    protected $_node_name = 'Projecttask';

    function find_for_project( $id = null )
    {

        if ( ! $id ){
            $this->set_node( 'Read', array( $this->_node_name ), array( 'type' => $this->_node_name, 'method' => 'all', 'limit' => $this->limit ) );
        } else {
            $this->set_node( 'Read', array( $this->_node_name => array( 'projectid' => $id ) ), array( 'type' => $this->_node_name, 'method' => 'equal to', 'limit' => $this->limit ) );
        }

        $result = $this->post( array(), array( 'include_headers' => true ) );

        if ( isset( $result['Read'] ) && !empty( $result['Read'] ) ){
            $return = array(
                        'data'      => $result['Read']['Projecttask'],
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
