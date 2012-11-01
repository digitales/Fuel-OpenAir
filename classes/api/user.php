<?php
namespace Openair\Api;

use Openair;
/**
 * Searching users, getting user information
 *
 */
class User extends Abstract_Api
{

    /**
     * Authentication a retrieve details on the authenticated user.
     *
     * @param string $username || null
     * @param string $password || null
     * @param string $company || null
     * @return array user details.
     */
    public function whoami( $username = null, $password = null, $company = null )
    {
        if ( ! $username ){ $username = $this->client->get_username(); }
        if ( ! $password ){ $password = $this->client->get_password(); }
        if ( ! $company ){  $company = $this->client->get_company();   }

        $this->set_node( 'Whoami', array( 'Login' => array( 'user' => $username, 'password' => $password, 'company' => $company ) ) );

        $result = $this->post( array(), array( 'include_headers' => true ) );

        if ( isset( $result['Whoami'] ) && !empty( $result['Whoami'] ) ){
            $return = array(
                        'data'      => $result['Whoami']['User'],
                        'status'    => array(
                                        'code' => $result['Whoami']['@attributes']['status'],
                                        'message' => Openair\Error::get_error( $result['Whoami']['@attributes']['status'] )
                                        )
                        );
            return $return;
        } else {
            return false;
        }
    }
}
