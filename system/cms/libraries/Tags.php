<?php

/**
 * Tags
 *
 * A simple tag parsing library.
 *
 * @package		Tags
 * @version		1.0
 * @author		Dan Horrigan <http://dhorrigan.com>
 * @license		Apache License v2.0
 * @copyright	2010 Dan Horrigan
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * 		http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
class Tags {

	private $_trigger			= '';
	private $_l_delim			= '{';
	private $_r_delim			= '}';
	private $_mark				= 'k0dj3j4nJHDj22j';
	private $_escape			= 'noparse';
	private $_regex_all_tags	= '';
	private $_tag_count			= 0;
	private $_current_callback	= array();
	private $_skip_content		= array();
	private $_tags				= array();

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	The custom config
	 * @return	void
	 */
	public function __construct($config = array())
	{
		foreach ($config as $key => $val)
		{
			if (isset($this->{'_' . $key}))
			{
				$this->{'_' . $key} = $val;
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Set Delimiters
	 *
	 * Set the delimeters for the tags
	 *
	 * @access	public
	 * @param	string	The left delimeter
	 * @param	string	The right delimeter
	 * @return	object	Returns $this to enable method chaining
	 */
	public function set_delimiters($left, $right)
	{
		$this->_l_delim = $left;
		$this->_r_delim = $right;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Trigger
	 *
	 * Sets the tag trigger to use.  This allows you to only consider tags
	 * that have a trigger:
	 *
	 * {tag:name}{/tag:name}
	 *
	 * @access	public
	 * @param	string	The tag trigger
	 * @return	object	Returns $this to enable method chaining
	 */
	public function set_trigger($trigger)
	{
		$this->_trigger = $trigger;

		return $this;
	}

	// --------------------------------------------------------------------


	/**
	 * Set Skip Content
	 *
	 * ...
	 *
	 * @access	public
	 * @param	array	The skip content
	 * @return	object	Returns $this to enable method chaining
	 */
	public function set_skip_content($skip_content = array())
	{
		$this->_skip_content = $skip_content;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Parse
	 *
	 * Parses the content and returns an array with marked content and tags
	 * or the resulting content from calling the callback for each tag.
	 *
	 * @access	public
	 * @param	string	The content to parse
	 * @param	array	The callback for each tag
	 * @return	mixed	Either the tags as array or callback results
	 */
	public function parse($content, $data = array(), $callback = array())
	{
		if (trim($this->_trigger) == '')
		{
			throw new Exception('You must set a trigger before you can parse the content.');

			return $content;
		}

		log_message('debug', 'Tag Class: Parser method Initialized');

		$this->_current_callback	= $callback;
		$this->_regex_all_tags		= '/' . $this->_l_delim . $this->_trigger . '[^' . $this->_l_delim . $this->_r_delim . ']*?' . $this->_r_delim . '/i';
		$this->_tags				= array();

		$content = $this->parse_globals($this->_escape_tags($content), $data);

		if ($this->_skip_content)
		{
			if (preg_match_all('/{[\w\d_]*?}/i', $content, $strs))
			{
				$ignore		= array('{else}');
				$escaped	= array();

				$total	= sizeof($strs[0]);

				for ($i = 0; $i < $total; $i++)
				{
					$str = $strs[0][$i];

					if (in_array($str, $ignore) OR in_array($str, $escaped))
					{
						$ignore[] = $str;

						continue;
					}

					$escaped[($str_escaped = escape_tags($str))] = $str;

					$content = str_replace($str, $str_escaped, $content);
				}

				if ($escaped)
				{
					log_message('debug', "There's a probability of exists a syntax error in:" . PHP_EOL . "\t\t\t\t\t\t\t\t=> " . $content);
				}
			}

			foreach ($this->_skip_content as $marker => $safe_content)
			{
				$content = str_replace($marker, $safe_content, $content);
			}

			$this->_skip_content = array();
		}

		$content = $this->_extract_tags($content);

		if (isset($escaped) && $escaped)
		{
			$content = str_replace(array_keys($escaped), array_values($escaped), $content);
		}

		if ( ! $this->_tags)
		{
			$content = $this->parse_php($this->parse_conditionals($content), $data);

			log_message('debug', 'Tag Class: Parser method End');

			return array(
				'content'	=> $content,
				'tags'		=> array()
			);
		}

		$content = $this->_replace_data($content, $data);

		// If there is a callback, call it for each tag
		if ( ! empty($callback) AND is_callable($callback))
		{
			$remainings = array();

			foreach ($this->_tags as $tag)
			{
				if ($tag['full_segments'] === $this->_escape)
				{
					$content = str_replace($tag['marker'], $tag['content'], $content);

					continue;
				}

				if ($remainings)
				{
					foreach ($remainings as $marker => &$remaining)
					{
						if (strpos($tag['full_tag'], $marker) !== FALSE)
						{
							list($replacements, $return_data) = $remaining;

							$tag['full_tag'] = str_replace($marker, $return_data, $tag['full_tag'], $count);

							foreach ($tag['attributes'] as &$attribute)
							{
								$attribute = str_replace($marker, $return_data, $attribute, $count2);

								if ($count2 >= $count)
								{
									break;
								}
							}

							if ($count >= $replacements)
							{
								unset($remainings[$marker]);
							}
							else
							{
								$remaining[0] -= $count;
							}
						}
					}
				}

				$return_data = call_user_func($callback, $tag);
				$content = str_replace($tag['marker'], $return_data, $content, $count);

				if ($count < $tag['replacements'])
				{
					$remainings[$tag['marker']] = array($tag['replacements'], $return_data);
				}
			}
		}

		// If there is no callback then lets loop through any remaining tags and just set them as ''
		else
		{
			foreach ($this->_tags as $tag)
			{
				$content = str_replace($tag['marker'], '', $content);
			}
		}

		$content = $this->parse_php($this->parse_conditionals($content), $data);

		log_message('debug', 'Tag Class: Parser method End');

		return array(
			'content'	=> $content,
			'tags'		=> $this->_tags
		);
	}

	private function _escape_tags($content = '')
	{
		$a = $this->_l_delim . $this->_trigger . $this->_escape . $this->_r_delim;
		$b = substr_replace($a, '/', 1, 0);

		$offset	= 0;

		while (($start = strpos($content, $a, $offset)) !== FALSE && (($end = strpos($content, $b, ($start += strlen($a)))) !== FALSE))
		{
			$_start = $start;

			while (($_start = strpos($content, $a, $_start)) !== FALSE && ($_start += strlen($a)) < $end)
			{
				$end = strpos($content, $b, ($end += strlen($b)));
			}

			$lenght			= $end - $start;
			$replacement	= escape_tags(substr($content, $start, $lenght));
			$content		= substr_replace($content, $replacement, $start, $lenght);
			$offset			= $start + strlen($replacement . $b);
		}

		return $content;
	}

	private function _extract_tags($orig_content = '', $attemp = 0)
	{
		while (($start = strpos($orig_content, $this->_l_delim . $this->_trigger)) !== FALSE)
		{
			$content = $orig_content;

			if ( ! preg_match($this->_regex_all_tags, $content, $tag))
			{
				break;
			}

			// We use these later
			$tag_len	= strlen($tag[0]);
			$full_tag	= $tag[0];
			$start		= strpos($content, $full_tag);

			// Trim off the left and right delimeters
			$tag = trim($full_tag, $this->_l_delim . $this->_r_delim);

			// Get the segments of the tag
			$segments = preg_replace('/(.*?)\s+.*/', '$1', $tag);

			// Get the attribute string
			$attributes = (preg_match('/\s+.*/', $tag, $args)) ? trim($args[0]) : '';

			// Lets start to create the parsed tag
			$parsed = array(
				'full_tag'		=> $full_tag,
				'attributes'	=> $this->_parse_attributes($attributes),
				'full_segments'	=> str_replace($this->_trigger, '', $segments),
				'segments'		=> $this->_parse_segments(str_replace($this->_trigger, '', $segments)),
				'skip_content'	=> array()
			);

			// Set the end tag to search for
			$end_tag = $this->_l_delim . '/' . $segments . $this->_r_delim;

			// Lets trim off the first part of the content
			$content = substr($content, $start + $tag_len);

			// If there is an end tag, get and set the content.
			if (($end = strpos($content, $end_tag)) !== FALSE)
			{
				if (substr_count($content, '{if', 0, $end) >= substr_count($content, '{/if', 0, $end))
				{
					$content = substr($content, 0, $end);
					$parsed['full_tag']	.= $content . $end_tag;

					$parsed = $this->_skip_content($parsed, $content);
				}
				else
				{
					$parsed['content'] = '';
				}
			}
			else
			{
				$parsed['content'] = '';
			}

			$parsed['marker'] = 'marker_' . ($this->_tag_count++) . $this->_mark;

			$orig_content = str_replace($parsed['full_tag'], $parsed['marker'], $orig_content, $count);

			$parsed['replacements'] = $count;

			$this->_tags[] = $parsed;
		}

		if ($start !== FALSE && $attemp < 1)
		{
			$tag_name = $this->_get_tag_by_pos($orig_content, $start);

			$tag_replace	= $this->_l_delim . escape_tags(trim($tag_name, $this->_l_delim . $this->_r_delim)) . $this->_r_delim;
			$orig_content	= str_replace($tag_name, $tag_replace, $orig_content);

			$orig_content	= $this->_extract_tags($orig_content, $attemp+1);
		}

		return $orig_content;
	}

	private function _get_tag_by_pos($content = '', $start = 0)
	{
		$tag_name		= $this->_l_delim . $this->_trigger;
		$tag_unclosed	= substr($content, $start + strlen($tag_name));
		$tag_name_parts = explode($this->_r_delim, $tag_unclosed);

		// skip
		$i = 0;
		while (list($key, $part) = each($tag_name_parts))
		{
			$tag_name .= $part . $this->_r_delim;

			// there may be something like: foo="{bar}" inside the tag that we need
			if (($l_delim_total = substr_count($part, $this->_l_delim)) > 1)
			{
				$i += $l_delim_total - 1;
			}

			// it seems that now we can close the tag
			if (strpos($part, $this->_l_delim) === FALSE)
			{
				// really, we can!
				if (($i--) == 0)
				{
					break;
				}
			}
		}

		return $tag_name;
	}

	private function _skip_content($tag = array(), $content = '')
	{
		$offset = 0;
		while (($tag_start = strpos($content, $this->_l_delim . $this->_trigger, $offset)) !== FALSE)
		{
			// we need some info before think on skip content
			$tag_segments	= preg_replace('/(.*?)\s+.*/', '$1', substr($content, $tag_start));
			$tag_end		= $this->_l_delim . '/' . trim($tag_segments, $this->_l_delim . $this->_r_delim) . $this->_r_delim;

			// has nested double tag ?
			if (($end = strpos($content, $tag_end, $tag_start)) !== FALSE)
			{
				// what is the tag name ?
				$tag_name = $this->_get_tag_by_pos($content, $tag_start);

				// ok! we have the tag name and a position to starts skip content
				$start	= $tag_start + strlen($tag_name);

				// generate a marker
				$marker = 'skip_' . ($this->_tag_count++) . $this->_mark;

				$safe_content = substr($content, $start, $end - $start);

				if (strpos($safe_content, $this->_mark) !== FALSE)
				{
					foreach ($this->_tags as $_tag)
					{
						if (strpos($safe_content, $_tag['marker']) !== FALSE)
						{
							$safe_content = str_replace($_tag['marker'], $_tag['full_tag'], $safe_content);
						}
					}
				}

				// save a copy of safe content
				$tag['skip_content'][$marker] = $safe_content;

				// finally skip the content
				$content = substr_replace($content, $marker, $start, $end - $start);

				// increase offset position
				$offset = strpos($content, $marker) + strlen($marker . $tag_end);
			}
			else
			{
				// just increase offset position
				++$offset;
			}
		}

		$tag['content'] = $content;

		return $tag;
	}

	private function _replace_data($content = '', $data = array())
	{
		// Clean up the array
		$data = $this->_force_array($data);

		if ( ! (is_array($data) && $data))
		{
			return $content;
		}

		$oc_nok = 0;
		$oc_ok = 0;

		foreach ($this->_tags as $key => $tag)
		{
			// Parse the single tags
			if (empty($tag['content']))
			{
				$return_data = $this->_parse_data_single($tag, $data);
			}

			// Parse the double tags
			else
			{
				$return_data = FALSE;
				if (array_key_exists($tag['segments'][0], $data))
				{
					$return_data = $this->_parse_data_double($tag, $data);
				}
			}

			// If the tag referenced data then put that data in the content
			if ($return_data === FALSE)
			{
				continue;
			}

			$content = str_replace($tag['marker'], $return_data, $content, $count);

			// Search and set missing replacements (tags in content and/or attributes of anothers tags)
			$i = $key;
			while (($count < $tag['replacements']) && isset($this->_tags[++$i]))
			{
				$next_tag =& $this->_tags[$i];

				if ( ! $occurences	= substr_count($next_tag['full_tag'], $tag['marker']))
				{
					continue;
				}

				log_message('debug', 'Tag Class: There more occurrences in:' . PHP_EOL . "\t\t\t\t\t\t\t\t=> " . $next_tag['full_tag']);

				if (($count + $occurences) > $tag['replacements'])
				{
					$count_attributes	= $count;
					$count_content		= $count;

					foreach ($next_tag['attributes'] as $j => $attribute)
					{
						while (($pos = strpos($attribute, $tag['marker'])) !== FALSE)
						{
							$next_tag['attributes'][$j] = substr_replace($attribute, $return_data, $pos, strlen($tag['marker']));

							++$count_attributes;

							if ($count_attributes === $tag['replacements'])
							{
								// todo: update full_tag
								break 3;
							}
						}
					}

					if ($next_tag['content'])
					{
						while (($pos = strpos($next_tag['content'], $tag['marker'])) !== FALSE)
						{
							$next_tag['content'] = substr_replace($next_tag['content'], $return_data, $pos, strlen($tag['marker']));

							++$count_content;

							if ($count_content === $tag['replacements'])
							{
								// todo: update full_tag
								break 3;
							}
						}
					}

					++$oc_nok;
				}
				else
				{
					foreach ($next_tag['attributes'] as $j => $attribute)
					{
						$next_tag['attributes'][$j] = str_replace($tag['marker'], $return_data, $attribute);
					}

					$next_tag['content']	= str_replace($tag['marker'], $return_data, $next_tag['content'], $count_content);
					$next_tag['full_tag']	= str_replace($tag['marker'], $return_data, $next_tag['full_tag'], $count_full_tag);

					++$oc_ok;
				}
			}

			$oc_nok && log_message('debug', sprintf('Tag Class: Find %d occurrences nok', $oc_nok));
			$oc_ok && log_message('debug', sprintf('Tag Class: Find %d occurrences ok', $oc_ok));

			unset($this->_tags[$key]);
		}

		return $content;
	}
	// --------------------------------------------------------------------

	public function parse_conditionals($content)
	{
		if (strpos($content, '{if ') === false)
		{
			return $content;
		}

		preg_match_all('#{if (.*?)}#i', $content, $matches, PREG_OFFSET_CAPTURE);

		$len_offset = 0;
		foreach ($matches[0] as $match)
		{
			$replacement = preg_replace('#((^|\(|\)|\s|\+|\-|\*|\/|\.|\||\&|\>|\<|\=)((?!true|false|null)[a-z][a-z0-9-_]-_*))#i', '$2\$$3', $match[0]);
			$content = substr($content, 0, $match[1] + $len_offset) . $replacement . substr($content, $match[1] + strlen($match[0]) + $len_offset);
			$len_offset += strlen($replacement) - strlen($match[0]);
		}

		preg_match_all('#{elseif (.*?)}#i', $content, $matches, PREG_OFFSET_CAPTURE);

		$len_offset = 0;
		foreach ($matches[0] as $match)
		{
			$replacement = preg_replace('#((^|\(|\)|\s|\+|\-|\*|\/|\.|\||\&|\>|\<|\=)((?!true|false|null)[a-z][a-z0-9-_]*))#i', '$2\$$3', $match[0]);
			$content = substr($content, 0, $match[1] + $len_offset) . $replacement . substr($content, $match[1] + strlen($match[0]) + $len_offset);
			$len_offset += strlen($replacement) - strlen($match[0]);
		}

		$content = preg_replace('#{if (.*?)}#i', '<?php if($1): ?>', $content);
		$content = preg_replace('#{elseif (.*?)}#i', '<?php elseif($1): ?>', $content);
		$content = preg_replace('#{else}#i', '<?php else: ?>', $content);
		$content = preg_replace('#{/if}#i', '<?php endif; ?>', $content);

		return $content;
	}

	// --------------------------------------------------------------------

	private function parse_php($_content_to_parse, $data = array())
	{
		extract($data);
		ob_start();
		echo eval('?>' . $_content_to_parse . '<?php ');
		$_content_to_parse = ob_get_contents();
		ob_end_clean();
		return $_content_to_parse;
	}

	// --------------------------------------------------------------------

	/**
	 * Parse Globals
	 *
	 * Parses global data tags.  These are tags that do not use a trigger
	 * and have a variable in the $data array.  This enables you to use
	 * globals inside of other tags:
	 *
	 * The Tag:
	 * {tag:blog:posts offset="{offset}"}
	 *
	 * The data array:
	 * array(
	 *     'offset' => $this->uri->segment(3),
	 * );
	 *
	 * @access	public
	 * @param	string	The content to parse
	 * @param	array	The globals
	 * @return	string	The parsed content
	 */
	public function parse_globals($content, $data)
	{
		foreach ($data as $var => $value)
		{
			if (is_scalar($value))
			{
				$content = str_replace($this->_l_delim . $var . $this->_r_delim, $value, $content);
			}
		}

		return $content;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the data pertaining to the given single tag.
	 *
	 * Example Data:
	 * $data = array(
	 *     'books' => array(
	 *         'count' => 2
	 *     )
	 * );
	 *
	 * Example Tag:
	 * {books:count}
	 *
	 * @access	private
	 * @param	array	The single tag
	 * @param	array	The data to parse
	 * @return	mixed	Either the data for the tag or FALSE
	 */
	private function _parse_data_single($tag, $data)
	{
		foreach ($tag['segments'] as $segment)
		{
			if ( ! is_array($data) OR ! isset($data[$segment]))
			{
				return FALSE;
			}
			$data = $data[$segment];
		}
		return $data;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the data pertaining to the given double tag.  This will
	 * loop through arrays of given data
	 *
	 * Example Data:
	 * $data = array(
	 *     'books' => array(
	 *         array(
	 *             'title' => 'PHP for Dummies',
	 *             'author' => 'John Doe'
	 *         ),
	 *         array(
	 *             'title' => 'CodeIgniter for Dummies',
	 *             'author' => 'Jane Doe'
	 *         )
	 *     )
	 * );
	 *
	 * Example Tags:
	 * {books}
	 * {title} by {author}<br />
	 * {/books}
	 *
	 * @access	private
	 * @param	array	The double tag
	 * @param	array	The data to parse
	 * @return	mixed	Either the data for the tag or FALSE
	 */
	private function _parse_data_double($tag, $data)
	{
		$return_data = '';
		$new_data = $data;
		foreach ($tag['segments'] as $segment)
		{
			if ( ! is_array($new_data) OR ! isset($new_data[$segment]))
			{
				return FALSE;
			}
			$new_data = $new_data[$segment];
		}
		$temp = new Tags;
		$temp->set_trigger($this->_trigger);
		foreach ($new_data as $val)
		{
			if ( ! is_array($val))
			{
				$val = array($val);
			}

			// We add the array element to the full data array so that full data
			// tags can work within double data tags
			$val = $val + $data;
			$return = $temp->parse($tag['content'], $val, $this->_current_callback);
			$return_data .= $return['content'];
		}
		unset($temp);

		return $return_data;
	}

	// --------------------------------------------------------------------

	/**
	 * Forces normal multi-dimensional arrays and objects into an
	 * array structure that will work with EE/Mojo/CI Parsers.
	 *
	 * @author	Phil Sturgeon <http://philsturgeon.co.uk>
	 * @access	private
	 * @param	mixed	The object or array to clean
	 * @param	int		Used for recursion
	 * @return	array	The clean array
	 */
	private function _force_array($var, $level = 0)
	{
		if (is_object($var))
		{
			$var = (array) $var;
		}

		if (is_array($var))
		{
			// Make sure everything else is array or single value
			foreach ($var as &$child)
			{
				if (is_object($child))
				{
					$child = $this->_force_array($child, $level + 1);
				}
			}
		}

		return $var;
	}

	// --------------------------------------------------------------------

	/**
	 * Parse Attributes
	 *
	 * Parses the string of attributes into a keyed array
	 *
	 * @param	string	The string of attributes
	 * @return	array	The keyed array of attributes
	 */
	private function _parse_attributes($attributes)
	{
		preg_match_all('/(.*?)\s*=\s*(\042|\047)(.*?)\\2/is', $attributes, $parts);

		// The tag has no attrbutes
		if (empty($parts[0]))
		{
			return array();
		}

		// The tag has attributes, so lets parse them
		else
		{
			$attr = array();
			for ($i = 0; $i < count($parts[1]); $i++)
			{
				$attr[trim($parts[1][$i])] = $parts[3][$i];
			}
		}

		return $attr;
	}

	// --------------------------------------------------------------------

	/**
	 * Parse Segments
	 *
	 * Parses the string of segments into an array
	 *
	 * @param	string	The string of segments
	 * @return	array	The array of segments
	 */
	private function _parse_segments($segments)
	{
		$segments = explode(':', $segments);
		return $segments;
	}

}

/* End of file Tags.php */