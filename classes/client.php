<?php

namespace Openair;

use Openair\Api,
    Openair\Api\Api_Interface,
    Openair\Request,
    Openair\Request_Curl;


/**
 * Simple FuelPHP Openair client
 *
 * API requests in OpenAir are only supported using POST and PUT protocols.
 *
 *
 * @author Ross Tweedie <r.tweedie@gmail.com>
 *
 * Website: http://github.com/digitales/Fuel-Openair
 */
class Client
{


    /**
     * Constant for authentication method. Indicates the default, but deprecated
     * login with username and token in URL.
     */
    const AUTH_URL_TOKEN = 'url_token';

    /**
     * Constant for authentication method. Indicates the new favored login method
     * with username and password via HTTP Authentication.
     */
    const AUTH_HTTP_PASSWORD = 'http_password';

    /**
     * Constant for authentication method. Indicates the new login method with
     * with username and token via HTTP Authentication.
     */
    const AUTH_HTTP_TOKEN = 'http_token';


    protected static $_user, $_api_token, $_url, $_driver;
    protected static $_api_url, $_api_key, $_company, $_namespace;
    protected static $_username, $_password;

    protected $payload;

    protected $options, $params = array();


    /**
     * The httpClient instance used to communicate with GitHub
     *
     * @var HttpClientInterface
     */
    private $client = null;

    /**
     * The list of loaded API instances
     *
     * @var array
     */
    private $apis = array();

    /**
     * HTTP Headers
     *
     * @var array
     */
    private $headers = array();

    /**
     * HTTP status code
     *
     * @var string
     */
    private $status_code = null;

    /**
     * Instantiate a new GitHub client
     *
     * @param HttpClientInterface $httpClient custom http client
     */
    public function __construct( )
    {
        if ( !isset( static::$_api_url ) || static::$_api_url =='' ){
            $this->setup();
        }
    }

    /**
     * Set up the client with the config settings
     *
     * @param null
     * @return Github\Client fluent interface
     */
    public function setup()
    {
        $config = \Config::load('openair', true);

        static::$_api_url       = $config[ $config['active'] ]['api_url'];
        static::$_api_key       = $config[ $config['active'] ]['api_key'];
        static::$_company       = $config[ $config['active'] ]['company'];
        static::$_namespace     = $config[ $config['active'] ]['namespace'];


        // Set the request attributes
        $this->payload['attr'] = array( 'API_Ver' => '1.0',
                                        'client' => 'Due Friday',
                                        'client_ver' => '1.0',
                                        'namespace' => static::$_namespace,
                                        'key' => static::$_api_key
                                      );

        // We need to use the CURL driver for this to work.
        $this->set_option( 'driver', 'curl' );

        return $this;
    }

    public function get_payload()
    {
        return $this->payload;
    }

    public function get_url()
    {
        return static::$_api_url;
    }

    public function get_username()
    {
        return static::$_username;
    }

    public function get_password()
    {
        return static::$_password;
    }


    public function set_attribute( $attr, $value, $node = null )
    {
        return $this->set_attributes( array( $attr => $value ), $node );
    }


    public function set_attributes( array $attrs, $node = null )
    {
        if ( $node ) { $payload = $this->payload[ $node ]; }

        foreach( $attrs AS $attr_key => $attr_value ){
            $payload['attr'][ $attr_key ] = $attr_value;
        }

        $this->payload = $payload;

        return $this;
    }


    public function set_node( $node, $params, $attributes = array() )
    {

        $this->payload[ $node ] = $params;
        if ( $attributes ){
            $this->payload[ $node ]['attr'] = $attributes;
        }

        return $this;
    }


    /**
     * Set the company for the API request
     *
     * @param string $company
     * @return Client fluent interface
     */
    public function set_company( $company ){
        self::$_company = $company;
        return $this;
    }

    public function get_company()
    {
        return static::$_company;
    }

    /**
	 * Sets options on the driver
	 *
	 * @param   array  $options
	 * @return  Github\Client fluent interface
	 */
	public function set_options(array $options)
	{
		foreach ($options as $key => $val)
		{
			$this->options[$key] = $val;
		}

		return $this;
	}


    /**
	 * Sets a single option/value
	 *
	 * @param   int|string $option
	 * @param   mixed $value
	 * @return  Github\Client fluent interface
	 */
	public function set_option($option, $value)
	{
		return $this->set_options(array($option => $value));
	}


    /**
	 * Sets params for the driver
	 *
	 * @param   array  $options
	 * @return  Github\Client fluent interface
	 */
	public function set_params(array $options)
	{
		foreach ($options as $key => $val)
		{
			$this->params[$key] = $val;
		}

		return $this;
	}


	/**
	 * Sets a single param/value
	 *
	 * @param   int|string  $option
	 * @param   mixed       $value
	 * @return  Github\Client fluent interface
	 */
	public function set_param($option, $value)
	{
		return $this->set_params(array($option => $value));
	}


    /**
     * Authenticate a user for all next requests
     *
     * @param string      $login  Openair username
     * @param string      $secret Openair password
     * @return Openair\Client fluent interface
     */
    public function set_auth($username, $password = null, $company = null)
    {
        if ( $company ){
            self::$_company = $company;
        }

        self::$_username = $username;
        self::$_password = $password;


        $this->payload['Auth'] = array( 'Login' => array( 'user' => self::$_username, 'password' => self::$_password, 'company' => self::$_company ) );

        return $this;
    }


    /**
     * Prepare the request to be performed
     * Ex: $api->get('repos/show/my-username/my-repo')
     *
     * @param string $path the GitHub path
     * @param array $parameters GET parameters
     * @param array $requestOptions reconfigure the request
     * @param string $method
     * @return array  data to be returned
     */
    protected function prepare_request( array $parameters = array(), $requestOptions = array(), $method = 'get' )
    {
        $url = self::get_url();

        $options = $this->options;
        if ( is_array( $parameters ) ){
            $options['params']  = array_merge( $this->params, $parameters );
        }

        $options['Content-Type'] = 'application/xml';

        $options['driver'] = 'curl';

        if ( isset( $requestOptions['include_headers'] ) ){
            $options['options'][CURLOPT_HEADER] = true;
            unset( $requestOptions['include_headers'] );
        }

        $response  = \Request::forge( $url, $options, $method )
                        ->add_param( array( 'request' => self::get_payload() ) )
                        ->set_header( 'Content-Type', 'application/xml' )
                        ->execute()
                        ->response();

        if ( isset( $response->headers ) ){
            $this->set_headers( $response->headers );
        }

        if ( isset( $response->status ) ){
            $this->status_code = (int) $response->status;
        }

        if ( isset( $response->body ) ){
            return \Format::forge( $response->body, 'xml' )->to_array();
        }else{
            return false;
        }
    }

    /**
     * Call any path, POST method
     *
     * @param   array   $parameters       POST parameters
     * @param   array   $requestOptions   reconfigure the request
     * @return  array                     data returned
     */
    public function post( array $parameters = array(), $requestOptions = array())
    {
        return $this->prepare_request( $parameters, $requestOptions, 'post' );
    }


    /**
     * Call any path, PUT method
     *
     * @param   array   $requestOptions   reconfigure the request
     * @return  array                     data returned
     */
    public function put( $requestOptions = array())
    {
        return $this->prepare_request( $parameters, $requestOptions, 'put' );
    }


    /**
     * Get the http client.
     *
     * @return HttpClientInterface a request instance
     */
    public function get_client()
    {
        if ( is_array( $this->headers ) ){
            foreach( $this->headers AS $option => $value ){
                $this->client->set_header( $option, $value );
            }
        } else {
            $this->client->set_header( $this->headers );
        }

        return $this->client;
    }

    /**
     * Inject another http client
     *
     * @param GitHub\Client $client The client instance
     */
    public function set_client( GitHub\Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $name
     *
     * @return ApiInterface
     *
     * @throws \InvalidArgumentException
     */
    public function api($name)
    {
        if (!isset($this->apis[$name])) {
            switch ($name) {
                case 'attachment':
                    $api = new Api\Attachment( $this );
                    break;

                case 'category':
                    $api = new Api\Category( $this );
                    break;

                case 'customer':
                    $api = new Api\Customer( $this );
                    break;
                case 'project':
                    $api = new Api\Project( $this );
                    break;

                case 'schedule_request':
                case 'schedule-request':
                case 'schedulerequest':
                    $api = new Api\Schedule_Request( $this );
                    break;

                case 'tax':
                    $api = new Api\Tax( $this );
                    break;

                case 'time_type':
                case 'time-type':
                case 'timetype':
                    $api = new Api\Time_Type( $this );
                    break;

                case 'user':
                    $api = new Api\User( $this );
                    break;

                default:
                    throw new \Exception_Argument_Invalid();
            }

            $this->apis[$name] = $api;
        }

        return $this->apis[$name];
    }

    /**
     * @return mixed
     */
    public function getRateLimit()
    {
        return $this->get('rate_limit');
    }

    /**
     * Clears used headers
     */
    public function clear_headers()
    {
        $this->setHeaders(array());
    }

    /**
     * @param array $headers
     */
    public function set_headers($headers)
    {
        $this->headers = $headers;
    }

    /**
     * Get the headers
     *
     * @param void
     * @return array
     */
    public function get_headers()
    {
        return $this->headers;
    }

    /**
     * Get the status code
     *
     * @param void
     * @return integer || null
     */
    public function get_status_code()
    {
        return $this->status_code;
    }

}
