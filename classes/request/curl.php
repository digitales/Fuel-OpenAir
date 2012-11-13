<?php

namespace Openair;

use Fuel\Core;


class Request_Curl extends \Fuel\Core\Request_Curl
{

    /**
	 * Function to encode input array depending on the content type
	 *
	 * @param   array $input
	 * @return  mixed encoded output
	 */
	//protected function encode(array $input)
	public function encode(array $input)
    {
        // Detect the request content type, default to 'text/plain'
		$content_type = isset($this->headers['Content-Type']) ? $this->headers['Content-Type'] : $this->response_info('content_type', 'text/plain');

		// Get the correct format for the current content type
		$format = \Arr::key_exists(static::$auto_detect_formats, $content_type) ? static::$auto_detect_formats[$content_type] : null;

		switch($format)
		{
			// Format as XML
			case 'xml':
					/**
					 * If the input array has one item in the top level
					 * then use that item as the root XML element.
					 */
					if(count($input) === 1 && !is_array( $input) )
					{
						$base_node = key($input);
                        return \Format::forge($input[$base_node])->to_xml(null, null, $base_node);
					}
					else
					{
						return self::to_xml( $input );
					}
				break;

			// Format as JSON
			case 'json':
					return \Format::forge($input)->to_json();
				break;

			// Format as PHP Serialized Array
			case 'serialize':
					return \Format::forge($input)->to_serialize();
				break;

			// Format as PHP Array
			case 'php':
					return \Format::forge($input)->to_php();
				break;

			// Format as CSV
			case 'csv':
					return \Format::forge($input)->to_csv();
				break;

			// Format as Query String
			default:
					return http_build_query($input, null, '&');
				break;
		}

    }

    /**
	 * To XML conversion
	 *
	 * @param   mixed        $data
	 * @param   null         $structure
	 * @param   null|string  $basenode
	 * @return  string
	 */
    public function to_xml( $data, $structure = null, $basenode = null )
    {

        if ($data == null)
		{
			$data = $this->_data;
		}

		// turn off compatibility mode as simple xml throws a wobbly if you don't.
		if (ini_get('zend.ze1_compatibility_mode') == 1)
		{
			ini_set('zend.ze1_compatibility_mode', 0);
		}

		if ($structure == null)
		{
            if ( ! $basenode && count( $data ) == 1 ){
                $keys = array_keys($data);
                $basenode = $keys[0];
            }
			$structure = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$basenode />");
		}

		// Force it to be something useful
		if ( ! is_array($data) and ! is_object($data))
		{
			$data = (array) $data;
		}

		foreach ($data as $key => $value)
		{
			// no numeric keys in our xml please!
			if (is_numeric($key))
			{
				// make string key...
				$key = (\Inflector::singularize($basenode) != $basenode) ? \Inflector::singularize($basenode) : 'item';
			}

			// replace anything not alpha numeric
			$key = preg_replace('/[^a-z_\-0-9]/i', '', $key);

			// if there is another array found recrusively call this function
			if (is_array($value) or is_object($value))
			{
                if ( $key == 'attr' ){
                    // Add the attributes.
                    foreach ( $value AS $attr_key => $attr_value ):
                        $structure->addAttribute( $attr_key, $attr_value );
                    endforeach;

                    continue; // We need to continue to the next interation - we don't need the attributes as a new element.
                } else {
                    $node = $structure;

                    if ( isset( $basenode ) && !empty( $basenode ) && ( $basenode == 'Report' || (string)$key !== (string)$basenode )  ){
                        $node = $structure->addChild($key);
                    }
                }


				// recursive call if value is not empty
				if( ! empty($value))
				{
                    $this->to_xml($value, $node, $key);
				}
			}else {
				// add single node.
				$value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, "UTF-8");
				$structure->addChild($key, $value);
			}
		}

		// pass back as string. or simple xml object if you want!
		return $structure->asXML();
    }


}
