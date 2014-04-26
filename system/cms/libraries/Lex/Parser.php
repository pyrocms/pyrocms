<?php
/**
 * Part of the Lex Template Parser.
 *
 * @author     Dan Horrigan
 * @license    MIT License
 * @copyright  2011 Dan Horrigan
 */

class LexParsingException extends Exception { }

class Lex_Parser
{
	protected $allow_php = false;
	protected $regex_setup = false;
	protected $scope_glue = '.';
	protected $tag_regex = '';
	protected $cumulative_noparse = false;

	protected $in_condition = false;

	protected $variable_regex = '';
	protected $variable_loop_regex = '';
	protected $variable_tag_regex = '';

	protected $callback_tag_regex = '';
	protected $callback_loop_tag_regex = '';

	protected $noparse_regex = '';

	protected $conditional_regex = '';
	protected $conditional_else_regex = '';
	protected $conditional_end_regex = '';
	protected $conditional_exists_regex = '';
	protected $conditional_not_regex = '';
	protected $conditional_data = array();

	protected static $extractions = array(
		'noparse' => array(),
	);
	
	protected static $data = null;
	protected static $callback_data = array();
	
	/**
	 * The main Lex parser method.  Essentially acts as dispatcher to
	 * all of the helper parser methods.
	 *
	 * @param   string        $text      Text to parse
	 * @param   array|object  $data      Array or object to use
	 * @param   mixed         $callback  Callback to use for Callback Tags
	 * @return  string
	 */
	public function parse($text, $data = array(), $callback = false, $allow_php = false)
	{
		$this->setup_regex();
		$this->allow_php = $allow_php;
		
		// Is this the first time parse() is called?
		if (Lex_Parser::$data === null)
		{
			// Let's store the local data array for later use.
			Lex_Parser::$data = $data;
		}
		else
		{
			// Let's merge the current data array with the local scope variables
			// So you can call local variables from within blocks.
			$data = array_merge(Lex_Parser::$data, $data);
			
			// Since this is not the first time parse() is called, it's most definately a callback,
			// let's store the current callback data with the the local data
			// so we can use it straight after a callback is called.
			Lex_Parser::$callback_data = $data;
		}

		// The parse_conditionals method executes any PHP in the text, so clean it up.
		if ( ! $allow_php)
		{
			$text = str_replace(array('<?', '?>'), array('&lt;?', '?&gt;'), $text);
		}

		$text = $this->parse_comments($text);
		$text = $this->extract_noparse($text);
		$text = $this->extract_looped_tags($text, $data, $callback);

		// Order is important here.  We parse conditionals first as to avoid
		// unnecessary code from being parsed and executed.
		$text = $this->parse_conditionals($text, $data, $callback);
		$text = $this->inject_extractions($text, 'looped_tags');
		$text = $this->parse_variables($text, $data, $callback);
		$text = $this->inject_extractions($text, 'callback_blocks');
		
		if ($callback)
		{
			//$text = $this->parse_variables($text, $data, $callback);
			$text = $this->parse_callback_tags($text, $data, $callback);
		}
		
		// To ensure that {{ noparse }} is never parsed even during consecutive parse calls
		// set $cumulative_noparse to true and use Lex_Parser::inject_noparse($text); immediately
		// before the final output is sent to the browser
		if ( ! $this->cumulative_noparse)
		{
			$text = $this->inject_extractions($text);
		}

		return $text;
	}

	/**
	 * Removes all of the comments from the text.
	 *
	 * @param   string  $text  Text to remove comments from
	 * @return  string
	 */
	public function parse_comments($text)
	{
		$this->setup_regex();
		return preg_replace('/\{\{#.*?#\}\}/s', '', $text);
	}

	/**
	 * Recursivly parses all of the variables in the given text and
	 * returns the parsed text.
	 *
	 * @param   string        $text  Text to parse
	 * @param   array|object  $data  Array or object to use
	 * @return  string
	 */
	public function parse_variables($text, $data, $callback = null)
	{
		$this->setup_regex();
		
		/**
		 * $data_matches[][0][0] is the raw data loop tag
		 * $data_matches[][0][1] is the offset of raw data loop tag
		 * $data_matches[][1][0] is the data variable (dot notated)
		 * $data_matches[][1][1] is the offset of data variable
		 * $data_matches[][2][0] is the content to be looped over
		 * $data_matches[][2][1] is the offset of content to be looped over
		 */
		if (preg_match_all($this->variable_loop_regex, $text, $data_matches, PREG_SET_ORDER + PREG_OFFSET_CAPTURE))
		{
			foreach ($data_matches as $index => $match)
			{
				if ($loop_data = $this->get_variable($match[1][0], $data))
				{
					$looped_text = '';

					foreach ($loop_data as $item_data)
					{
						$str = $this->extract_looped_tags($match[2][0], $item_data, $callback);
						$str = $this->parse_conditionals($str, $item_data, $callback);
						$str = $this->inject_extractions($str, 'looped_tags');

						$str = $this->parse_variables($str, $item_data, $callback);

						// extract any noparse tags that may have been the value of another tag
						$str = $this->extract_noparse($str);
						
						if ($callback !== null)
						{
							$str = $this->parse_callback_tags($str, $item_data, $callback);
						}
						
						$looped_text .= $str;
					}
					$text = preg_replace('/'.preg_quote($match[0][0], '/').'/m', addcslashes($looped_text, '\\$'), $text, 1);
				}
				else // It's a callback block.
				{
					// Let's extract it so it doesn't conflict 
					// with the local scope variables in the next step.
					$text = $this->create_extraction('callback_blocks', $match[0][0], $match[0][0], $text);
				}
			}
		}

		/**
		 * $data_matches[0] is the raw data tag
		 * $data_matches[1] is the data variable (dot notated)
		 */
		if (preg_match_all($this->variable_tag_regex, $text, $data_matches))
		{
			foreach ($data_matches[1] as $index => $var)
			{
				if (($val = $this->get_variable($var, $data, '__lex_no_value__')) !== '__lex_no_value__')
				{
					$text = str_replace($data_matches[0][$index], $val, $text);
				}
			}
		}

		return $text;
	}

	/**
	 * Parses all Callback tags, and sends them through the given $callback.
	 *
	 * @param   string  $text            Text to parse
	 * @param   mixed   $callback        Callback to apply to each tag
	 * @param   bool    $in_conditional  Whether we are in a conditional tag
	 * @return  string
	 */
	public function parse_callback_tags($text, $data, $callback)
	{
		$this->setup_regex();
		$in_condition = $this->in_condition;

		if ($in_condition)
		{
			$regex = '/\{\s*('.$this->variable_regex.')(\s+.*?)?\s*\}/ms';
		}
		else
		{
			$regex = '/\{\{\s*('.$this->variable_regex.')(\s+.*?)?\s*(\/)?\}\}/ms';
		}
		/**
		 * $match[0][0] is the raw tag
		 * $match[0][1] is the offset of raw tag
		 * $match[1][0] is the callback name
		 * $match[1][1] is the offset of callback name
		 * $match[2][0] is the parameters
		 * $match[2][1] is the offset of parameters
		 * $match[3][0] is the self closure
		 * $match[3][1] is the offset of closure
		 */
		while (preg_match($regex, $text, $match, PREG_OFFSET_CAPTURE))
		{
			$selfClosed = false;
			$parameters = array();
			$tag = $match[0][0];
			$start = $match[0][1];
			$name = $match[1][0];
			if (isset($match[2]))
			{
				$cb_data = $data;
				if ( !empty(Lex_Parser::$callback_data))
				{
					$cb_data = array_merge(Lex_Parser::$callback_data, (array) $data);
				}
				$raw_params = $this->inject_extractions($match[2][0], '__cond_str');
				$parameters = $this->parse_parameters($raw_params, $cb_data, $callback);
			}

			if (isset($match[3]))
			{
				$selfClosed = true;
			}

			$content = '';

			$temp_text = substr($text, $start + strlen($tag));
			if (preg_match('/\{\{\s*\/'.preg_quote($name, '/').'\s*\}\}/m', $temp_text, $match, PREG_OFFSET_CAPTURE) && ! $selfClosed)
			{
				$content = substr($temp_text, 0, $match[0][1]);
				$tag .= $content.$match[0][0];
				
				// Is there a nested block under this one existing with the same name?
				$nested_regex = '/\{\{\s*('.preg_quote($name, '/').')(\s.*?)\}\}(.*?)\{\{\s*\/\1\s*\}\}/ms';
				if (preg_match($nested_regex, $content.$match[0][0], $nested_matches))
				{
					$nested_content = preg_replace('/\{\{\s*\/'.preg_quote($name, '/').'\s*\}\}/m', '', $nested_matches[0]);
					$content = $this->create_extraction('nested_looped_tags', $nested_content, $nested_content, $content);
				}
			}

			$replacement = call_user_func_array($callback, array($name, $parameters, $content));
			$replacement = $this->parse_recursives($replacement, $content, $callback);
			
			if ($in_condition)
			{
				$replacement = $this->value_to_literal($replacement);
			}
			$text = preg_replace('/'.preg_quote($tag, '/').'/m', addcslashes($replacement, '\\$'), $text, 1);
			$text = $this->inject_extractions($text, 'nested_looped_tags');
		}
		return $text;
	}

	/**
	 * Parses all conditionals, then executes the conditionals.
	 *
	 * @param   string  $text      Text to parse
	 * @param   mixed   $data      Data to use when executing conditionals
	 * @param   mixed   $callback  The callback to be used for tags
	 * @return  string
	 */
	public function parse_conditionals($text, $data, $callback)
	{
		$this->setup_regex();
		preg_match_all($this->conditional_regex, $text, $matches, PREG_SET_ORDER);

		$this->conditional_data = $data;

		/**
		 * $matches[][0] = Full Match
		 * $matches[][1] = Either 'if', 'unless', 'elseif', 'unlessif'
		 * $matches[][2] = Condition
		 */
		foreach ($matches as $match)
		{
			$this->in_condition = true;

			$condition = $match[2];

			// Extract all literal string in the conditional to make it easier
			if (preg_match_all('/(["\']).*?(?<!\\\\)\1/', $condition, $str_matches))
			{
				foreach ($str_matches[0] as $m)
				{
					$condition = $this->create_extraction('__cond_str', $m, $m, $condition);
				}
			}
			$condition = preg_replace($this->conditional_not_regex, '$1!$2', $condition);

			if (preg_match_all($this->conditional_exists_regex, $condition, $exists_matches, PREG_SET_ORDER))
			{
				foreach ($exists_matches as $m)
				{
					$exists = 'true';
					if ($this->get_variable($m[2], $data, '__doesnt_exist__') === '__doesnt_exist__')
					{
						$exists = 'false';
					}
					$condition = $this->create_extraction('__cond_exists', $m[0], $m[1].$exists.$m[3], $condition);
				}
			}

			$condition = preg_replace_callback('/\b('.$this->variable_regex.')\b/', array($this, 'process_condition_var'), $condition);

			if ($callback)
			{
				$condition = preg_replace('/\b(?!\{\s*)('.$this->callback_name_regex.')(?!\s+.*?\s*\})\b/', '{$1}', $condition);
				$condition = $this->parse_callback_tags($condition, $data, $callback);

				// Re-extract the strings that have now been possibly added.
				if (preg_match_all('/(["\']).*?(?<!\\\\)\1/', $condition, $str_matches))
				{
					foreach ($str_matches[0] as $m)
					{
						$condition = $this->create_extraction('__cond_str', $m, $m, $condition);
					}
				}

			}
			
			// Re-process for variables, we trick processConditionVar so that it will return null
			$this->in_condition = false;
			$condition = preg_replace_callback('/\b('.$this->variable_regex.')\b/', array($this, 'process_condition_var'), $condition);
			$this->in_condition = true;

			// Re-inject any strings we extracted
			$condition = $this->inject_extractions($condition, '__cond_str');
			$condition = $this->inject_extractions($condition, '__cond_exists');

			$conditional = '<?php '.$match[1].' ('.$condition.'): ?>';

			$text = preg_replace('/'.preg_quote($match[0], '/').'/m', addcslashes($conditional, '\\$'), $text, 1);
		}

		$text = preg_replace($this->conditional_else_regex, '<?php else: ?>', $text);
		$text = preg_replace($this->conditional_end_regex, '<?php endif; ?>', $text);

		$text = $this->parse_php($text);
		$this->in_condition = false;
		return $text;
	}

	/**
	 * Goes recursively through a callback tag with a passed child array.
	 * 
	 * @param string  $text - The replaced text after a callback.
	 * @param string  $orig_text - The original text, before a callback is called.
	 * @param mixed   $callback
	 * @return string $text
	 */
	public function parse_recursives($text, $orig_text, $callback)
	{
		// Is there a {{ *recursive [array_key]* }} tag here, let's loop through it.
		if (preg_match($this->recursive_regex, $text, $match))
		{
			$array_key = $match[1];
			$tag = $match[0];
			$next_tag = null;
			$children = Lex_Parser::$callback_data[$array_key];
			$child_count = count($children);
			$count = 1;
			
			// Is the array not multi-dimensional? Let's make it multi-dimensional.
			if ($child_count == count($children, COUNT_RECURSIVE))
			{
				$children = array($children);
				$child_count = 1;
			}
			
			foreach ($children as $child)
			{
				$has_children = true;

				// If this is a object let's convert it to an array.
				is_array($child) OR $child = (array) $child;
				
				// Does this child not contain any children?
				// Let's set it as empty then to avoid any errors.
				if ( ! array_key_exists($array_key, $child))
				{
					$child[$array_key] = array();
					$has_children = false;
				}
				
				$replacement = $this->parse($orig_text, $child, $callback, $this->allow_php);
				
				// If this is the first loop we'll use $tag as reference, if not
				// we'll use the previous tag ($next_tag)
				$current_tag = ($next_tag !== null) ? $next_tag : $tag;
				
				// If this is the last loop set the next tag to be empty
				// otherwise hash it.
				$next_tag = ($count == $child_count) ? '' : md5($tag.$replacement);
				
				$text = str_replace($current_tag, $replacement.$next_tag, $text);
				
				if ($has_children)
				{
					$text = $this->parse_recursives($text, $orig_text, $callback);
				}
				$count++;
			}
		}
		return $text;
	}

	/**
	 * Gets or sets the Scope Glue
	 *
	 * @param   string|null  $glue  The Scope Glue
	 * @return  string
	 */
	public function scope_glue($glue = null)
	{
		if ($glue !== null)
		{
			$this->regex_setup = false;
			$this->scope_glue = $glue;
		}

		return $glue;
	}

	/**
	 * Sets the noparse style. Immediate or cumulative.
	 *
	 * @param	bool $mode
	 * @return	void
	 */
	public function cumulative_noparse($mode)
	{
		$this->cumulative_noparse = $mode;
	}

	/**
	 * Injects noparse extractions.
	 *
	 * This is so that multiple parses can store noparse
	 * extractions and all noparse can then be injected right
	 * before data is displayed.
	 *
	 * @param	string	$text	Text to inject into
	 * @return	string
	 */
	public static function inject_noparse($text)
	{
		if (isset(Lex_Parser::$extractions['noparse']))
		{
			foreach (Lex_Parser::$extractions['noparse'] AS $hash => $replacement)
			{
				if (strpos($text, "noparse_{$hash}") !== false)
				{
					$text = str_replace("noparse_{$hash}", $replacement, $text);
				}
			}
		}

		return $text;
	}

	/**
	 * This is used as a callback for the conditional parser.  It takes a variable
	 * and returns the value of it, properly formatted.
	 *
	 * @param   array  $match  A match from preg_replace_callback
	 * @return  string
	 */
	protected function process_condition_var($match)
	{
		$var = is_array($match) ? $match[0] : $match;
		if (in_array(strtolower($var), array('true', 'false', 'null', 'or', 'and')) or
		    strpos($var, '__cond_str') === 0 or
		    strpos($var, '__cond_exists') === 0 or
		    is_numeric($var))
		{
			return $var;
		}

		$value = $this->get_variable($var, $this->conditional_data, '__process_condition_var__');

		if ($value === '__process_condition_var__')
		{
			return $this->in_condition ? $var : 'null';
		}

		return $this->value_to_literal($value);
	}

	/**
	 * This is used as a callback for the conditional parser.  It takes a variable
	 * and returns the value of it, properly formatted.
	 *
	 * @param   array  $match  A match from preg_replace_callback
	 * @return  string
	 */
	protected function process_param_var($match)
	{
		return $match[1].$this->process_condition_var($match[2]);
	}

	/**
	 * Takes a value and returns the literal value for it for use in a tag.
	 *
	 * @param   string  $value  Value to convert
	 * @return  string
	 */
	protected function value_to_literal($value)
	{
		if ($value === null)
		{
			return "null";
		}
		elseif ($value === true)
		{
			return "true";
		}
		elseif ($value === false)
		{
			return "false";
		}
		elseif (is_numeric($value))
		{
			return '"'.$value.'"';
		}
		elseif (is_string($value))
		{
			return '"'.addslashes($value).'"';
		}
		elseif (is_object($value) and is_callable(array($value, '__toString')))
		{
			return '"'.addslashes((string) $value).'"';
		}
		elseif (is_array($value))
		{
			return !empty($value) ? "true" : "false";
		}
		else
		{
			return $value;
		}
	}

	/**
	 * Sets up all the global regex to use the correct Scope Glue.
	 *
	 * @return  void
	 */
	protected function setup_regex()
	{
		if ($this->regex_setup)
		{
			return;
		}
		$glue = preg_quote($this->scope_glue, '/');

		$this->variable_regex = $glue === '\\.' ? '[a-zA-Z0-9_'.$glue.']+' : '[a-zA-Z0-9_\.'.$glue.']+';
		$this->callback_name_regex = $this->variable_regex.$glue.$this->variable_regex;
		$this->variable_loop_regex = '/\{\{\s*('.$this->variable_regex.')\s*\}\}(.*?)\{\{\s*\/\1\s*\}\}/ms';
		$this->variable_tag_regex = '/\{\{\s*('.$this->variable_regex.')\s*\}\}/m';

		$this->callback_block_regex = '/\{\{\s*('.$this->variable_regex.')(\s.*?)\}\}(.*?)\{\{\s*\/\1\s*\}\}/ms';

		$this->recursive_regex = '/\{\{\s*\*recursive\s*('.$this->variable_regex.')\*\s*\}\}/ms';
		
		$this->noparse_regex = '/\{\{\s*noparse\s*\}\}(.*?)\{\{\s*\/noparse\s*\}\}/ms';

		$this->conditional_regex = '/\{\{\s*(if|elseif)\s*((?:\()?(.*?)(?:\))?)\s*\}\}/ms';
		$this->conditional_else_regex = '/\{\{\s*else\s*\}\}/ms';
		$this->conditional_end_regex = '/\{\{\s*(\/if|endif)\s*\}\}/ms';
		$this->conditional_exists_regex = '/(\s+|^)exists\s+('.$this->variable_regex.')(\s+|$)/ms';
		$this->conditional_not_regex = '/(\s+|^)not(\s+|$)/ms';

		$this->regex_setup = true;
		
		// This is important, it's pretty unclear by the documentation
		// what the default value is on <= 5.3.6
		ini_set('pcre.backtrack_limit', 1000000);
	}

	/**
	 * Extracts the noparse text so that it is not parsed.
	 *
	 * @param   string  $text  The text to extract from
	 * @return  string
	 */
	protected function extract_noparse($text)
	{
		/**
		 * $matches[][0] is the raw noparse match
		 * $matches[][1] is the noparse contents
		 */
		if (preg_match_all($this->noparse_regex, $text, $matches, PREG_SET_ORDER))
		{
			foreach ($matches as $match)
			{
				$text = $this->create_extraction('noparse', $match[0], $match[1], $text);
			}
		}

		return $text;
	}
	
	/**
	 * Extracts the looped tags so that we can parse conditionals then re-inject.
	 *
	 * @param   string  $text  The text to extract from
	 * @return  string
	 */
	protected function extract_looped_tags($text, $data = array(), $callback = null)
	{
		/**
		 * $matches[][0] is the raw match
		 */
		if (preg_match_all($this->callback_block_regex, $text, $matches, PREG_SET_ORDER))
		{
			foreach ($matches as $match)
			{
				// Does this callback block contain parameters?
				if ($this->parse_parameters($match[2], $data, $callback))
				{
					// Let's extract it so it doesn't conflict with local variables when
					// parse_variables() is called.
					$text = $this->create_extraction('callback_blocks', $match[0], $match[0], $text);
				}
				else
				{
					$text = $this->create_extraction('looped_tags', $match[0], $match[0], $text);
				}
			}
		}

		return $text;
	}

	/**
	 * Extracts text out of the given text and replaces it with a hash which
	 * can be used to inject the extractions replacement later.
	 *
	 * @param   string  $type         Type of extraction
	 * @param   string  $extraction   The text to extract
	 * @param   string  $replacement  Text that will replace the extraction when re-injected
	 * @param   string  $text         Text to extract out of
	 * @return  string
	 */
	protected function create_extraction($type, $extraction, $replacement, $text)
	{
		$hash = md5($replacement);
		Lex_Parser::$extractions[$type][$hash] = $replacement;

		return str_replace($extraction, "{$type}_{$hash}", $text);
	}

	/**
	 * Injects all of the extractions.
	 *
	 * @param   string  $text  Text to inject into
	 * @return  string
	 */
	protected function inject_extractions($text, $type = null)
	{
		if ($type === null)
		{
			foreach (Lex_Parser::$extractions as $type => $extractions)
			{
				foreach ($extractions as $hash => $replacement)
				{
					if (strpos($text, "{$type}_{$hash}") !== false)
					{
						$text = str_replace("{$type}_{$hash}", $replacement, $text);
						unset(Lex_Parser::$extractions[$type][$hash]);
					}
				}
			}
		}
		else
		{
			if ( ! isset(Lex_Parser::$extractions[$type]))
			{
				return $text;
			}

			foreach (Lex_Parser::$extractions[$type] as $hash => $replacement)
			{
				if (strpos($text, "{$type}_{$hash}") !== false)
				{
					$text = str_replace("{$type}_{$hash}", $replacement, $text);
					unset(Lex_Parser::$extractions[$type][$hash]);
				}
			}
		}

		return $text;
	}

	/**
	 * Takes a dot-notated key and finds the value for it in the given
	 * array or object.
	 *
	 * @param   string        $key  Dot-notated key to find
	 * @param   array|object  $data  Array or object to search
	 * @param   mixed         $default  Default value to use if not found
	 * @return  mixed
	 */
	protected function get_variable($key, $data, $default = null)
	{
		if (strpos($key, $this->scope_glue) === false)
		{
			$parts = explode('.', $key);
		}
		else
		{
			$parts = explode($this->scope_glue, $key);
		}
		foreach ($parts as $key_part)
		{
			if (is_array($data))
			{
				if ( ! array_key_exists($key_part, $data))
				{
					return $default;
				}

				$data = $data[$key_part];
			}
			elseif (is_object($data))
			{
				if ( ! isset($data->{$key_part}))
				{
					return $default;
				}

				$data = $data->{$key_part};
			}
			else
			{
				return $default;
			}
		}

		return $data;
	}

	/**
	 * Evaluates the PHP in the given string.
	 *
	 * @param   string  $text  Text to evaluate
	 * @return  string
	 */
	protected function parse_php($text)
	{
		ob_start();
		$result = eval('?>'.$text.'<?php ');

		if ($result === false)
		{
			echo '<br />You have a syntax error in your Lex tags. The snippet of text that contains the error has been output below:<br />';
			exit(str_replace(array('?>', '<?php '), '', $text));
		}

		return ob_get_clean();
	}


	/**
	 * Parses a parameter string into an array
	 *
	 * @param	string	The string of parameters
	 * @return	array
	 */
	protected function parse_parameters($parameters, $data, $callback)
	{
		$this->conditional_data = $data;
		$this->in_condition = true;
		// Extract all literal string in the conditional to make it easier
		if (preg_match_all('/(["\']).*?(?<!\\\\)\1/', $parameters, $str_matches))
		{
			foreach ($str_matches[0] as $m)
			{
				$parameters = $this->create_extraction('__param_str', $m, $m, $parameters);
			}
		}

		$parameters = preg_replace_callback(
			'/(.*?\s*=\s*(?!__))('.$this->variable_regex.')/is',
			array($this, 'process_param_var'),
			$parameters
		);
		if ($callback)
		{
			$parameters = preg_replace('/(.*?\s*=\s*(?!\{\s*)(?!__))('.$this->callback_name_regex.')(?!\s*\})\b/', '$1{$2}', $parameters);
			$parameters = $this->parse_callback_tags($parameters, $data, $callback);
		}

		// Re-inject any strings we extracted
		$parameters = $this->inject_extractions($parameters, '__param_str');
		$this->in_condition = false;

		if (preg_match_all('/(.*?)\s*=\s*(\'|"|&#?\w+;)(.*?)(?<!\\\\)\2/s', trim($parameters), $matches))
		{
			$return = array();
			foreach ($matches[1] as $i => $attr)
			{
				$return[trim($matches[1][$i])] = stripslashes($matches[3][$i]);
			}

			return $return;
		}

		return array();
	}
}