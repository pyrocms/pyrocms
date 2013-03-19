<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Helper Plugin
 *
 * Various helper plugins.
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Plugins
 */
class Plugin_Helper extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Helper',
	);
	public $description = array(
		'en' => 'Access helper functions and other helpful items.',
		'el' => 'Πρόσβαση σε helper functions και άλλα χρήσιμα.',
		'fr' => 'Accéder aux fonctions helper et à d\'autres éléments utiles.',
		'it' => 'Accedi alle funzioni di aiuto e ad altre cose utili',
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger example
	 *
	 * @todo fill the  array with details about this plugin, then uncomment the return value.
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'lang' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Retrieve a translated string from a language file.'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'line' => array(// this is the order-dir="asc" attribute
						'type' => 'text',// Can be: slug, number, flag, text, array, any.
						'flags' => '',// flags are predefined values like this.
						'default' => '',// attribute defaults to this if no value is given
						'required' => true,// is this attribute required?
					),
				),
			),// end lang method
			'config' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Retrieve a config item from a configuration file.'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'item' => array(// this is the order-dir="asc" attribute
						'type' => 'text',// Can be: slug, number, flag, text, array, any.
						'flags' => '',// flags are predefined values like this.
						'default' => '',// attribute defaults to this if no value is given
						'required' => true,// is this attribute required?
					),
				),
			),// end config method
			'date' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Format a date for any timestamp. Defaults to the CMS format and the current timestamp.'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'format' => array(// this is the order-dir="asc" attribute
						'type' => 'text',// Can be: slug, number, flag, text, array, any.
						'flags' => '',// flags are predefined values like this.
						'default' => Settings::get('date_format'),// attribute defaults to this if no value is given
						'required' => false,// is this attribute required?
					),
					'timestamp' => array(// this is the order-dir="asc" attribute
						'type' => 'number',// Can be: slug, number, flag, text, array, any.
						'flags' => '',// flags are predefined values like this.
						'default' => now(),// attribute defaults to this if no value is given
						'required' => false,// is this attribute required?
					),
				),
			),// end date method
			'gravatar' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Output a Gravatar avatar based on the email provided.'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'email' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
					'size' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '50',
						'required' => false,
					),
					'rating' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'g',
						'required' => false,
					),
					'url-only' => array(
						'type' => 'flag',
						'flags' => 'Y|N',
						'default' => 'N',
						'required' => false,
					),
				),
			),// end gravatar method
			'strip' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Strip whitespace from content and replace it with the specified characters.'
				),
				'single' => false,// will it work as a single tag?
				'double' => true,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'replace' => array(// this is the order-dir="asc" attribute
						'type' => 'any',
						'flags' => '',
						'default' => 'a single space',
						'required' => false,
					),
				),
			),// end strip method
			'count' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Count loops of a double tag and optionally output the count.'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'identifier' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'default',
						'required' => false,
					),
					'start' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '1',
						'required' => false,
					),
					'mode' => array(
						'type' => 'flag',
						'flags' => 'add|subtract',
						'default' => 'add',
						'required' => false,
					),
					'return' => array(
						'type' => 'flag',
						'flags' => 'true',
						'default' => 'false',
						'required' => false,
					),
				),
			),// end count method
			'show_count' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Use to output the count from the {{ helper:count }} method elsewhere on the page.'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(),
			),// end show_count method
		);

		$this->config->load('parser');
		$allowed = config_item('allowed_functions');
		sort($allowed);

		foreach ($allowed as $function)
		{
			$info[$function] = array(
				'description' => array(
					'en' => 'Call the PHP function '.$function.'(). Any attribute values provided will be passed as arguments.'
				),
				'single' => true,
			);
		}

		return $info;
	}

	/** @var boolean A flag for the counter functions for loops. */
	static $_counter_increment = true;

	/**
	 * Data
	 *
	 * Loads a theme partial
	 *
	 * Usage:
	 *
	 *     {{ helper:lang line="foo" }}
	 *
	 * @return string The language string
	 */
	public function lang()
	{
		$line = $this->attribute('line');

		return $this->lang->line($line);
	}

	/**
	 * Config
	 *
	 * Displays a config item
	 *
	 * Usage:
	 *
	 *     {{ helper:config item="foo" }}
	 *
	 * @return string The configuration key's value
	 */
	public function config()
	{
		$item = $this->attribute('item');

		return config_item($item);
	}

	/**
	 * Date
	 *
	 * Displays the current date or formats a timestamp that is passed to it.
	 *
	 * Usage:
	 *
	 *     {{ helper:date format="Y" }}
	 *
	 * Outputs: 2011
	 *
	 *     {{ helper:date format="Y" timestamp="2524608000" }}
	 *
	 * Outputs: 2050
	 *
	 * @return string The date and time formatted appropriately.
	 */
	public function date()
	{
		$this->load->helper('date');

		$format    = $this->attribute('format');
		$timestamp = $this->attribute('timestamp', now());

		return format_date($timestamp, $format);
	}

	/**
	 * Gravatar
	 *
	 * Provides for showing Gravatar images.
	 *
	 * Usage:
	 *
	 *     {{ helper:gravatar email="some-guy@example.com" size="50" rating="g" url-only="true" }}
	 *
	 * @return string An image element or the URL to the gravatar.
	 */
	public function gravatar()
	{
		$email    = $this->attribute('email', '');
		$size     = $this->attribute('size', '50');
		$rating   = $this->attribute('rating', 'g');
		$url_only = str_to_bool($this->attribute('url-only', false));

		return gravatar($email, $size, $rating, $url_only);
	}

	/**
	 * Replace
	 *
	 * Replaces whitespace in the content.
	 *
	 * Usage:
	 *
	 *     {{ helper:replace replace="   " }}
	 *
	 * Outputs:
	 * all whitespace replaced by three spaces.
	 *
	 * @return string The final content string.
	 */
	public function strip()
	{
		return preg_replace('!\s+!', $this->attribute('replace', ' '), $this->content());
	}

	/**
	 * Add counting to tag loops
	 *
	 * @example
	 * Usage:
	 *
	 *     {{ blog:posts }}
	 *         {{ helper:count }} -- {{title}}
	 *     {{ /blog:posts }}
	 *
	 * Outputs:
	 *
	 *     1 -- This is an example title
	 *     2 -- This is another title
	 *
	 * @example
	 * Usage:
	 *
	 *     {{ blog:posts }}
	 *         {{ helper:count mode="subtract" start="10" }} -- {{title}}
	 *     {{ /blog:posts }}
	 *
	 * Outputs:
	 *
	 *     10 -- This is an example title
	 *     9  -- This is another title
	 *
	 * You can add a second counter to a page by setting a unique identifier:
	 *
	 *     {{ files:listing folder="foo" }}
	 *         {{ helper:count identifier="files" return="false" }}
	 *         {{name}} -- {{slug}}
	 *     {{ /files:listing }}
	 *     You have {{ helper:show_count identifier="files" }} files.
	 * 
	 * @return string|int
	 */
	public function count()
	{
		static $count = array();

		$identifier = $this->attribute('identifier', 'default');

		// Use a default of 1 if they haven't specified one and it's the first iteration
		if ( ! isset($count[$identifier]))
		{
			$count[$identifier] = $this->attribute('start', 1);
		}
		// lets check to see if they're only wanting to show the count
		elseif (self::$_counter_increment)
		{
			// count up unless they specify to "subtract"
			($this->attribute('mode') == 'subtract') ? $count[$identifier]-- : $count[$identifier]++;
		}

		// set this back to continue counting again next time
		self::$_counter_increment = true;

		return (str_to_bool($this->attribute('return', true))) ? $count[$identifier] : null;
	}

	/**
	 * Get the total count of the set.
	 *
	 * Not to be used without a {{ helper:count }}
	 *
	 * Usage:
	 *
	 *     {{ helper:show_count identifier="files" }}
	 *
	 * Outputs:
	 *     Test -- test
	 *     Second -- second
	 *     You have 2 files.
	 *
	 * @return int The total set count.
	 */
	public function show_count()
	{
		self::$_counter_increment = false;

		return self::count();
	}

	/**
	 * Execute whitelisted php functions
	 *
	 * Usage:
	 *
	 *     {{ helper:foo parameter1="bar" parameter2="bar" }}
	 *
	 * NOTE: the attribute name is irrelevant as only the values are concatenated and passed as arguments.
	 * 
	 * @param string $name
	 * @param array $args
	 * @return mixed
	 */
	public function __call($name, $args)
	{
		$this->config->load('parser');

		if (function_exists($name) and in_array($name, config_item('allowed_functions')))
		{
			$attributes = $this->attributes();
			
			// unset automatically set attributes
			if ( isset($attributes['parse_params']) ) {
				unset($attributes['parse_params']);
			}
			
			return call_user_func_array($name, $attributes);
		}

		return 'Function not found or is not allowed';
	}

}