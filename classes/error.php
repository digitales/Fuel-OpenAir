<?php
namespace Openair;

/**
 * Open error class
 *
 * Convert an error code into an human readble string.
 *
 * @author Ross Tweedie <r.tweedie@gmail.com>
 *
 * Website: http://github.com/digitales/Fuel-Openair
 */
class Error extends \Fuel\Core\Error
{

    protected static $status_codes = array(
            // Server error codes
            0 => 'Success',
            1 => 'Unknown error',
            2 => 'Not logged in',
            3 => 'Too many arguments',
            4 => 'Too few arguments',
            5 => 'Unknown Command',
            6 => 'Access from an invalid URL',
            7 => 'Invalid OffLine version',
            8 => 'Failure + Dynamic Message',
            9 => 'Logged out',
            10 => 'Invalid parameters',

            // CreateUser error codes
            201 => 'invalid company',
            202 => 'duplicate user nick',
            203 => 'too few arguments',
            204 => 'Namespace error',
            205 => 'Workschedule error',

            //CreateAccount errors
            301 => 'duplicate company nick too few arguments',
            302 => 'too few arguments',
            303 => 'please pick a different password',
            304 => 'Not enabled',

            // Auth errors
            401 => 'Auth failed : No such company/user/pass',
            402 => 'Old TB login',
            403 => 'No company name supplied',
            404 => 'No user name supplied',
            405 => 'No user password supplied',
            406 => 'Invalid Company name',
            408 => 'Bad password',
            409 => 'Account cancelled',
            410 => 'Inactive user',
            411 => 'Account conflict, contact customer service',
            412 => 'Wrong namespace for account',
            413 => 'Account not privileged to access API',
            414 => 'Temporarily unavailable',
            415 => 'Account archived',
            416 => 'User locked',
            417 => 'Restricted IP address',
            418 => 'Invalid uid session',

            // API login errors
            501 => 'API authentication required',
            502 => 'API authentication failed',
            503 => 'Invalid or missing key attribute',
            504 => 'Invalid or missing namespace attribute',
            505 => 'The namespace and key do not match',
            506 => 'Authentication key disabled',
            555 => 'You have exceeded the limit set for the account for input objects',
            556 => 'XML API rate limit exceeded',

            // Read errors
            601 => 'Invalid id/code',
            602 => 'Invalid field',
            603 => 'Invalid type or method',
            604 => 'Attachment size exceeds space available',
            605 => 'N/A',
        );

    public static function get_error( $error_code )
    {
        if ( isset ( self::$status_codes[ $error_code ] ) ){
            return self::$status_codes[ $error_code ];
        }else{
            return 'Error code not found, please consult the API documentation for error code '. $error_code ;
        }
    }

}
