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
	private $_tag_count			= 0;
	private $_current_callback	= array();
	private $_regex_all_tags	= '';
	private $_skip_content		= array();

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

		$this->_current_callback	= $callback;
		$this->_regex_all_tags		= '/' . $this->_l_delim . $this->_trigger . '[^' . $this->_l_delim . $this->_r_delim . ']*?' . $this->_r_delim . '/i';

		$orig_content = $this->parse_globals($content, $data);

		if ($this->_skip_content)
		{
			foreach ($this->_skip_content as $skip_marker => $skip_content)
			{
				$orig_content = str_replace($skip_marker, $skip_content, $orig_content);
			}

			$this->_skip_content = array();
		}

		$parsed_tags = $this->_extract_tags($orig_content);

		if ( ! $parsed_tags)
		{
			$orig_content = $this->parse_php($this->parse_conditionals($orig_content), $data);

			return array(
				'content'	=> $orig_content,
				'tags'		=> array()
			);
		}

		$orig_content = $this->_replace_data($orig_content, $parsed_tags, $data);

		// If there is a callback, call it for each tag
		if ( ! empty($callback) AND is_callable($callback))
		{
			foreach ($parsed_tags as $tag)
			{
				$orig_content = str_replace($tag['marker'], call_user_func($callback, $tag), $orig_content);
			}
		}

		// If there is no callback then lets loop through any remaining tags and just set them as ''
		else
		{
			foreach ($parsed_tags as $tag)
			{
				$orig_content = str_replace($tag['marker'], '', $orig_content);
			}
		}

		$orig_content = $this->parse_php($this->parse_conditionals($orig_content), $data);

		return array(
			'content'	=> $orig_content,
			'tags'		=> $parsed_tags
		);
	}

	public function _extract_tags(&$orig_content = '')
	{
		$parsed_tags = array();

		$_loop_experimental_a = 0;
		while (($start = strpos($orig_content, $this->_l_delim . $this->_trigger)) !== FALSE)
		{
			if ($_loop_experimental_a++ > 200)
			{
				log_message('error', 'erro na busca de tags comuns');
				break;
			}

			$content = $orig_content;

			if ( ! preg_match($this->_regex_all_tags, $content, $tag))
			{
				break;
			}

			// We use these later
			$tag_len	= strlen($tag[0]);
			$full_tag	= $tag[0];

			// Trim off the left and right delimeters
			$tag = trim($full_tag, $this->_l_delim . $this->_r_delim);

			// Get the segments of the tag
			$segments = preg_replace('/(.*?)\s+.*/', '$1', $tag);

			// Get the attribute string
			$attributes = (preg_match('/\s+.*/', $tag, $args)) ? trim($args[0]) : '';

			// Lets start to create the parsed tag
			$parsed = array(
				'full_tag'				=> $full_tag,
				'attributes'			=> $this->_parse_attributes($attributes),
				'full_segments'			=> str_replace($this->_trigger, '', $segments),
				'segments'				=> $this->_parse_segments(str_replace($this->_trigger, '', $segments)),
				'skip_content'			=> array()
			);

			// Set the end tag to search for
			$end_tag = $this->_l_delim . '/' . $segments . $this->_r_delim;

			// Lets trim off the first part of the content
			$content = substr($content, $start + $tag_len);

			// If there is an end tag, get and set the content.
			if (($end = strpos($content, $end_tag)) !== FALSE)
			{
				$content = substr($content, 0, $end);
				$parsed['full_tag']	.= $content . $end_tag;
/*
				$tag_end		= $this->_l_delim . '/' . $this->_trigger;
				$tag_end_len	= strlen($tag_end);
				$offset			= 0;

				$w2 = 0;
				while (($double_end_a = strpos($content, $tag_end, $offset)) !== FALSE
					&& ($double_end_b = strpos($content, $this->_r_delim, $double_end_a)) !== FALSE)
				{
					if ($w2++ > 200)
					{
						log_message('error', 'erro na busca de double tags internas');
						break;
					}

					$tag_start		= $this->_l_delim . $this->_trigger;
					$tag_start		.= substr($content, $double_end_a + $tag_end_len, $double_end_b - ($double_end_a + $tag_end_len));
					$tag_start_len	= strlen($tag_start);

					if (($double_start_a = strpos($content, $tag_start, $offset)) !== FALSE)
					{
						$double_start_b		= $double_start_a + $tag_start_len;
						$tag_start_str		= substr($content, $double_start_b, $double_end_a - $double_start_b);
						$tag_start_parts	= explode($this->_r_delim, $tag_start_str);

						$_skip = 0;
						$w3 = 0;
						while (list($_d_str_key, $_d_str_arg) = each($tag_start_parts))
						{
							if ($w3++ > 200)
							{
								log_message('error', 'erro na simplificação da tag');
								break;
							}

							$tag_start .= $_d_str_arg . $this->_r_delim;

							if (($_l_cont = substr_count($_d_str_arg, $this->_l_delim)) > 1)
							{
								$_skip += $_l_cont - 1;
							}

							if (strpos($_d_str_arg, $this->_l_delim) === FALSE)
							{
								if (($_skip--) == 0)
								{
									$tag_start_len	= strlen($tag_start);
									$double_start_b	= $double_start_a + $tag_start_len;
									break;
								}
							}
						}

						$skip_marker	= 'skip_' . ($this->_tag_count++) . $this->_mark;
						$skip_content	= substr($content, $double_start_b, $double_end_a - $double_start_b);

						$parsed['skip_content'][$skip_marker] = $skip_content;

						$content = substr_replace($content, $skip_marker, $double_start_b, $double_end_a - $double_start_b);

						$offset = strpos($content, $skip_marker) + strlen($skip_marker . $tag_end);
					}
				}*/

				$offset = 0;
				$_loop_experimental_b = 0;
				while (($double_start_a = strpos($content, $this->_l_delim . $this->_trigger, $offset)) !== FALSE)
				{
					if ($_loop_experimental_b++ > 300)
					{
						log_message('error', 'erro na busca de double tags internas');
						break;
					}

					$tag_start			= $this->_l_delim . $this->_trigger;
					$tag_start_str		= substr($content, $double_start_a);
					$tag_segments		= preg_replace('/(.*?)\s+.*/', '$1', $tag_start_str);
					$tag_end			= $this->_l_delim . '/' . trim($tag_segments, $this->_l_delim . $this->_r_delim) . $this->_r_delim;

					if (($double_end_a = strpos($content, $tag_end, $double_start_a)) !== FALSE)
					{
						$tag_start_str	= substr($tag_start_str, strlen($tag_start));
						$tag_start_parts = explode($this->_r_delim, $tag_start_str);

						$_skip = 0;
						while (list($_d_str_key, $_d_str_arg) = each($tag_start_parts))
						{
							$tag_start .= $_d_str_arg . $this->_r_delim;

							if (($_l_cont = substr_count($_d_str_arg, $this->_l_delim)) > 1)
							{
								$_skip += $_l_cont - 1;
							}

							if (strpos($_d_str_arg, $this->_l_delim) === FALSE)
							{
								if (($_skip--) == 0)
								{
									$tag_start_len	= strlen($tag_start);
									$double_start_b	= $double_start_a + $tag_start_len;

									break;
								}
							}
						}

						$skip_marker	= 'skip_' . ($this->_tag_count++) . $this->_mark;
						$skip_content	= substr($content, $double_start_b, $double_end_a - $double_start_b);

						$parsed['skip_content'][$skip_marker] = $skip_content;

						$content = substr_replace($content, $skip_marker, $double_start_b, $double_end_a - $double_start_b);

						$offset = strpos($content, $skip_marker) + strlen($skip_marker . $tag_end);
					}
					else
					{
						$offset += strlen($tag_start);
					}
				}

				$parsed['content']	= $content;
			}
			else
			{
				$parsed['content'] = '';
			}

			$parsed['marker'] = 'marker_' . ($this->_tag_count++) . $this->_mark;

			$orig_content = str_replace($parsed['full_tag'], $parsed['marker'], $orig_content, $count);

			$parsed['replacements'] = $count;

			$parsed_tags[] = $parsed;
		}

		return $parsed_tags;
	}

	function _replace_data($orig_content = '', &$parsed_tags = array(), $data = array())
	{
		// Clean up the array
		$data = $this->_force_array($data);

		if ( ! (is_array($data) && $data))
		{
			return $orig_content;
		}

		$oc_nok = 0;
		$oc_ok = 0;

		foreach ($parsed_tags as $key => $tag)
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

			$orig_content = str_replace($tag['marker'], $return_data, $orig_content, $count);

			// Search and set missing replacements (tags in content and/or attributes of anothers tags)
			$i = $key;
			while (($count < $tag['replacements']) && isset($parsed_tags[++$i]))
			{
				log_message('debug', 'occurrences nok');

				$next_tag	=& $parsed_tags[$i];
				$occurences	= substr_count($next_tag['full_tag'], $tag['marker']);

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
								// update full_tag
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
								// update full_tag
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

					$next_tag['content']	= str_replace($tag['marker'], $return_data, $next_tag['content']);
					$next_tag['full_tag']	= str_replace($tag['marker'], $return_data, $next_tag['full_tag']);

					++$oc_ok;
				}
			}

			log_message('debug', sprintf('%d occurrences nok', $oc_nok));
			log_message('debug', sprintf('%d occurrences ok', $oc_ok));

			unset($parsed_tags[$key]);
		}

		return $orig_content;
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
			$replacement = preg_replace('#((^|\(|\)|\s|\+|\-|\*|\/|\.|\||\&|\>|\<|\=)((?!true|false|null)[a-z][a-z0-9]*))#i', '$2\$$3', $match[0]);
			$content = substr($content, 0, $match[1] + $len_offset) . $replacement . substr($content, $match[1] + strlen($match[0]) + $len_offset);
			$len_offset += strlen($replacement) - strlen($match[0]);
		}

		preg_match_all('#{elseif (.*?)}#i', $content, $matches, PREG_OFFSET_CAPTURE);

		$len_offset = 0;
		foreach ($matches[0] as $match)
		{
			$replacement = preg_replace('#((^|\(|\)|\s|\+|\-|\*|\/|\.|\||\&|\>|\<|\=)((?!true|false|null)[a-z][a-z0-9]*))#i', '$2\$$3', $match[0]);
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
				$content = str_replace('{' . $var . '}', $value, $content);
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
	private function _force_array($var, $level = 1)
	{
		if (is_object($var))
		{
			$var = (array) $var;
		}

		if (is_array($var))
		{
			// Make sure everything else is array or single value
			foreach ($var as $index => & $child)
			{
				$child = $this->_force_array($child, $level + 1);

				if (is_object($child))
				{
					$child = (array) $child;
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