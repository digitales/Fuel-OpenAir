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
	'Openair\\Client'                   => __DIR__.'/classes/client.php',

    'Openair\\Error'                    => __DIR__.'/classes/error.php',

    'Openair\\Request'                  => __DIR__.'/classes/request.php',
    'Openair\\Request_Curl'             => __DIR__.'/classes/request/curl.php',

    'Openair\\Model_Abstract'           => __DIR__.'/classes/model/abstract.php',
    'Openair\\Model_Read'               => __DIR__.'/classes/model/read.php',

    'Openair\\Api\\Api_Interface'       => __DIR__.'/classes/api/api_interface.php',
    'Openair\\Api\\Abstract_Api'        => __DIR__.'/classes/api/abstract/api.php',

    'Openair\\Api\\User'                => __DIR__.'/classes/api/user.php',

    'Openair\\Api\\Project'             => __DIR__.'/classes/api/project.php',
    'Openair\\Api\\Project\\Stage'       => __DIR__.'/classes/api/project/stage.php',
    'Openair\\Api\\Project\\Task'        => __DIR__.'/classes/api/project/task.php',
    'Openair\\Api\\Project\\Task\\Type'   => __DIR__.'/classes/api/project/task/type.php',


));


/* End of file bootstrap.php */
