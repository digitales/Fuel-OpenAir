<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2012 Fuel Development Team
 * @link       http://fuelphp.com
 */

Autoloader::add_core_namespace('Openair');

Autoloader::add_classes(array(
	'Openair\\Openair'              => __DIR__.'/classes/openair.php',

    'Openair\\Client'               => __DIR__.'/classes/client.php',

    'Openair\\Error'               => __DIR__.'/classes/error.php',

    'Openair\\Request'              => __DIR__.'/classes/request.php',
    'Openair\\Request_Curl'         => __DIR__.'/classes/request/curl.php',

    'Openair\\Model_Abstract'       => __DIR__.'/classes/model/abstract.php',
    'Openair\\Model_Read'           => __DIR__.'/classes/model/read.php',

    'Openair\\Api\\Api_Interface'                => __DIR__.'/classes/api/api_interface.php',
    'Openair\\Api\\Abstract_Api'                 => __DIR__.'/classes/api/abstract/api.php',

    'Openair\\Api\\User'                 => __DIR__.'/classes/api/user.php',



));


/* End of file bootstrap.php */
