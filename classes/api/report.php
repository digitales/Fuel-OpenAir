<?php

namespace Openair\Api;

use Openair\Api\Abstract_Api;

class Report extends Abstract_Api
{

    protected $_node_name = 'Report';


    /**
     * Get a particular report
     *
     * @param integer $id
     *
     */
    public function get_report( $id )
    {
        //$this->unset_node( 'Read' );

        $this->set_node( 'Report', array( 'Report' => array( 'relatedid' => $id,  'email_report' => 1) ), array( 'type' => 'Reportf' ) );

        echo 'payload<pre>'.print_r($this->client->get_payload(), 1).'</pre>';


        $result = $this->post( array(), array( 'include_headers' => true ) );

        echo 'STATUS:'. \Openair\Error::get_error( $result['Report']['@attributes']['status'] );

        echo 'results<pre>'.print_r($result,1).'</pre>';



        exit;

        if ( isset( $result['Report'] ) && !empty( $result['Report'] ) ){


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
