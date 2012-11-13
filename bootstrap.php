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
	'Openair\\Client'                       => __DIR__.'/classes/client.php',

    'Openair\\Error'                        => __DIR__.'/classes/error.php',

    'Openair\\Request'                      => __DIR__.'/classes/request.php',
    'Openair\\Request_Curl'                 => __DIR__.'/classes/request/curl.php',

    'Openair\\Exception_Argument_Invalid'   => __DIR__.'/classes/exception/argument/invalid.php',



    'Openair\\Api\\Api_Interface'           => __DIR__.'/classes/api/api_interface.php',
    'Openair\\Api\\Abstract_Api'            => __DIR__.'/classes/api/abstract/api.php',

    'Openair\\Api\\Category'                => __DIR__.'/classes/api/category.php',
    'Openair\\Api\\Category\\One'           => __DIR__.'/classes/api/category/one.php',
    'Openair\\Api\\Category\\Two'           => __DIR__.'/classes/api/category/two.php',
    'Openair\\Api\\Category\\Three'         => __DIR__.'/classes/api/category/three.php',
    'Openair\\Api\\Category\\Four'          => __DIR__.'/classes/api/category/four.php',
    'Openair\\Api\\Category\\Five'          => __DIR__.'/classes/api/category/five.php',

    'Openair\\Api\\Customer'                => __DIR__.'/classes/api/customer.php',

    'Openair\\Api\\Error'                   => __DIR__.'/classes/api/error.php',

    'Openair\\Api\\Project'                 => __DIR__.'/classes/api/project.php',
    'Openair\\Api\\Project\\Stage'          => __DIR__.'/classes/api/project/stage.php',
    'Openair\\Api\\Project\\Task'           => __DIR__.'/classes/api/project/task.php',
    'Openair\\Api\\Project\\Task\\Type'     => __DIR__.'/classes/api/project/task/type.php',

    'Openair\\Api\\Report'                  => __DIR__.'/classes/api/report.php',

    'Openair\\Api\\Schedule_Request'        => __DIR__.'/classes/api/schedule_request.php',
    'Openair\\Api\\Schedule_Request\\Item'  => __DIR__.'/classes/api/schedule_request/item.php',

    'Openair\\Api\\Tax'                     => __DIR__.'/classes/api/tax.php',
    'Openair\\Api\\Tax\\Location'           => __DIR__.'/classes/api/tax/location.php',
    'Openair\\Api\\Tax\\Rate'               => __DIR__.'/classes/api/tax/rate.php',

    'Openair\\Api\\Time_Type'               => __DIR__.'/classes/api/time_type.php',

    'Openair\\Api\\User'                    => __DIR__.'/classes/api/user.php',

));


/* End of file bootstrap.php */
