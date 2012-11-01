<?php

namespace Openair\Api;

use Openair\Api\Abstract_Api;


class Project extends Abstract_Api
{
    /**
     * Search users by username:
     *
     * @param  string $keyword the keyword to search
     * @return array list of users found
     */
    public function find($keyword)
    {
        return $this->get('legacy/user/search/'.urlencode($keyword));
    }

    public function get_list( ){

        $this->set_node( 'Read', array( 'Project' ), array( 'type' => 'Project', 'method' => 'all', 'limit' => $this->limit ) );
        $result = $this->post( array(), array( 'include_headers' => true ) );


        if ( isset( $result['Read'] ) && !empty( $result['Read'] ) ){
            $return = array(
                        'data'      => $result['Read']['Project'],
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


    public function get( $id = null ){

        if ( ! $id )
        {
            return false;
        }

        $this->set_node( 'Read', array( 'Project' => array( 'id' => $id ) ), array( 'type' => 'Project', 'method' => 'equal to', 'limit' => $this->limit ) );

        $result = $this->post( array(), array( 'include_headers' => true ) );

        if ( isset( $result['Read'] ) && !empty( $result['Read'] ) ){
            $return = array(
                        'data'      => $result['Read']['Project'],
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
