<?php
namespace Openair;

class OpenairException extends \Exception {}

class Openair{

    protected static $_url, $_apiKey, $_namespace, $_company, $_method, $active;

    public function __construct(){
        self::_init();
    }


    public static $version = '1.0';

    protected static $request = null;

    public static function _init()
	{
        if ( ! static::$_url ){
            self::__setup();
        }

        $options['driver'] = 'curl';
        /* $options['auth'] = 'basic';
        $options['user'] = $user['username'];
        $options['pass'] = $user['password'];
        */

        //$options['set_header'] = 'namespace';

        $options['Content-Type'] = 'application/xml';

        $method = 'post';

		static::$request = new \Request( self::$_url, $options, $method );

        // set the request attributes
        // static::$request::$main->add_param( 'stuff', 'bbbbb');

	}


    private static function __setup()
    {
        $config = \Config::load('openair', true);

        static::$_url           = $config[ $config['active'] ]['url'];
        static::$_apiKey        = $config[ $config['active'] ]['api_key'];
        static::$_namespace     = $config[ $config['active'] ]['namespace'];
        static::$_company       = $config[ $config['active'] ]['company'];
    }

    /**
	 * Magic pass-through to the Request instance.
	 *
	 * @param   string  $method  The called method
	 * @param   array   $args    The method arguments
	 * @return  mixed   The method results
	 * @throws  BadMethodCallException
	 */
	public static function __callStatic( $method, $args )
	{
		if ( is_callable(array( static::$request, $method ) ) ){
			return call_user_func_array( array( static::$request, $method ), $args );
		}

		throw new \BadMethodCallException( 'Method Openair::' . $method . ' does not exist.' );
	}

}
