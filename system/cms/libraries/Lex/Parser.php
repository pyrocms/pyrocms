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
	protected $regex_setup = false;
	protected $scope_glue = '.';
	protected $tag_regex = '';

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
	protected $conditional_data = array();

	protected $extractions = array(
		'noparse' => array(),
	);

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

		// The parse_conditionals method executes any PHP in the text, so clean it up.
		if ( ! $allow_php)
		{
			$text = str_replace(array('<?', '?>'), array('&lt;?', '?&gt;'), $text);
		}

		$text = $this->parse_comments($text);
		$text = $this->extract_noparse($text);
		$text = $this->extract_looped_tags($text);

		// Order is important here.  We parse conditionals first as to avoid
		// unnecessary code from being parsed and executed.
		$text = $this->parse_conditionals($text, $data, $callback);
		$text = $this->inject_extractions($text, 'looped_tags');
		$text = $this->parse_variables($text, $data, $callback);

		if ($callback)
		{
			$text = $this->parse_callback_tags($text, $data, $callback);
		}

		$text = $this->inject_extractions($text);

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
						$str = $this->parse_conditionals($match[2][0], $item_data, $callback);
						$str = $this->parse_variables($str, $item_data, $callback);
						if ($callback !== null)
						{
							$str = $this->parse_callback_tags($str, $item_data, $callback);
						}
						$looped_text .= $str;
					}
					$text = preg_replace('/'.preg_quote($match[0][0], '/').'/m', $looped_text, $text, 1);
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
				if ($val = $this->get_variable($var, $data))
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
			$regex = '/\{\{\s*('.$this->variable_regex.')(\s+.*?)?\s*\}\}/ms';
		}
		/**
		 * $match[0][0] is the raw tag
		 * $match[0][1] is the offset of raw tag
		 * $match[1][0] is the callback name
		 * $match[1][1] is the offset of callback name
		 * $match[2][0] is the parameters
		 * $match[2][1] is the offset of parameters
		 */
		while (preg_match($regex, $text, $match, PREG_OFFSET_CAPTURE))
		{
			$parameters = array();
			$tag = $match[0][0];
			$start = $match[0][1];
			$name = $match[1][0];
			if (isset($match[2]))
			{
				$parameters = $this->parse_parameters($match[2][0], $data, $callback);
			}

			$content = '';

			$temp_text = substr($text, $start + strlen($tag));

			if (preg_match('/\{\{\s*\/'.preg_quote($name, '/').'\s*\}\}/m', $temp_text, $match, PREG_OFFSET_CAPTURE))
			{
				$content = substr($temp_text, 0, $match[0][1]);
				$tag .= $content.$match[0][0];
			}

			$replacement = call_user_func_array($callback, array($name, $parameters, $content));

			if ($in_condition)
			{
				$replacement = $this->value_to_literal($replacement);
			}
			$text = preg_replace('/'.preg_quote($tag, '/').'/m', $replacement, $text, 1);
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
		$this->in_condition = true;

		/**
		 * $matches[][0] = Full Match
		 * $matches[][1] = Either 'if', 'unless', 'elseif', 'unlessif'
		 * $matches[][2] = Condition
		 */
		foreach ($matches as $match)
		{
			$condition = $match[2];

			// Extract all literal string in the conditional to make it easier
			if (preg_match_all('/(?!\{.*)(["\']).*?(?<!\\\\)\1(?!.*\})/', $condition, $str_matches))
			{
				foreach ($str_matches[0] as $m)
				{
					$condition = $this->create_extraction('__cond_str', $m, $m, $condition);
				}
			}

			$condition = preg_replace_callback('/\b('.$this->variable_regex.')\b/', array($this, 'process_condition_var'), $condition);

			if ($callback)
			{
				$condition = preg_replace('/\b(?!\{\s*)('.$this->callback_name_regex.')(?!\s+.*?\s*\})\b/', '{$1}', $condition);
				$condition = $this->parse_callback_tags($condition, $data, $callback);
			}

			// Re-inject any strings we extracted
			$condition = $this->inject_extractions($condition, '__cond_str');

			$conditional = '<?php '.$match[1].' ('.$condition.'): ?>';

			$text = preg_replace('/'.preg_quote($match[0], '/').'/m', $conditional, $text, 1);
		}

		$text = preg_replace($this->conditional_else_regex, '<?php else: ?>', $text);
		$text = preg_replace($this->conditional_end_regex, '<?php endif; ?>', $text);

		$text = $this->parse_php($text);
		$this->in_condition = false;
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
			return $value;
		}
		elseif (is_string($value))
		{
			return '"'.addslashes($value).'"';
		}
		elseif (is_object($value) and is_callable(array($value, '__toString')))
		{
			return '"'.addslashes((string) $value).'"';
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

		$this->callback_block_regex = '/\{\{\s*('.$this->variable_regex.')(\s+.*?)?\s*\}\}(.*?)\{\{\s*\/\1\s*\}\}/ms';

		$this->noparse_regex = '/\{\{\s*noparse\s*\}\}(.*?)\{\{\s*\/noparse\s*\}\}/ms';

		$this->conditional_regex = '/\{\{\s*(if|elseif)\s*((?:\()?(.*?)(?:\))?)\s*\}\}/ms';
		$this->conditional_else_regex = '/\{\{\s*else\s*\}\}/ms';
		$this->conditional_end_regex = '/\{\{\s*(\/if|endif)\s*\}\}/ms';

		$this->regex_setup = true;
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
	protected function extract_looped_tags($text)
	{
		/**
		 * $matches[][0] is the raw match
		 */
		if (preg_match_all($this->callback_block_regex, $text, $matches, PREG_SET_ORDER))
		{
			foreach ($matches as $match)
			{
				$text = $this->create_extraction('looped_tags', $match[0], $match[0], $text);
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
		$this->extractions[$type][$hash] = $replacement;

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
			foreach ($this->extractions as $type => $extractions)
			{
				foreach ($extractions as $hash => $replacement)
				{
					$text = str_replace("{$type}_{$hash}", $replacement, $text);
					unset($this->extractions[$type][$hash]);
				}
			}
		}
		else
		{
			if ( ! isset($this->extractions[$type]))
			{
				return $text;
			}

			foreach ($this->extractions[$type] as $hash => $replacement)
			{
				$text = str_replace("{$type}_{$hash}", $replacement, $text);
				unset($this->extractions[$type][$hash]);
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
		foreach (explode($this->scope_glue, $key) as $key_part)
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
		echo eval('?>'.$text.'<?php ');

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

		if (preg_match_all('/(.*?)\s*=\s*(\'|\")(.*?)\\2/is', trim($parameters), $matches))
		{
			$return = array();
			foreach ($matches[1] as $i => $attr)
			{
				$return[trim($matches[1][$i])] = $matches[3][$i];
			}

			return $return;
		}

		return array();
	}
}
