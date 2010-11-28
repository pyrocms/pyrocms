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
 *		http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

class Tags
{
	private $_trigger = '';
	private $_l_delim = '{';
	private $_r_delim = '}';
	private $_mark = 'k0dj3j4nJHDj22j';
	private $_tag_count = 0;

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
			if (isset($this->{'_'.$key}))
			{
				$this->{'_'.$key} = $val;
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
		$orig_content = $this->parse_globals($content, $data);


		$open_tag_regex = $this->_l_delim.$this->_trigger.'.*?'.$this->_r_delim;

		while (($start = strpos($orig_content, $this->_l_delim.$this->_trigger)) !== FALSE)
		{
			$content = $orig_content;

			if ( ! preg_match('/'.$open_tag_regex.'/i', $content, $tag))
			{
				break;
			}

			// We use these later
			$tag_len = strlen($tag[0]);
			$full_tag = $tag[0];

			// Trim off the left and right delimeters
			$tag = trim($full_tag, $this->_l_delim.$this->_r_delim);

			// Get the segments of the tag
			$segments = preg_replace('/(.*?)\s+.*/', '$1', $tag);

			// Get the attribute string
			$attributes = (preg_match('/\s+.*/', $tag, $args)) ? trim($args[0]) : '';

			// Lets start to create the parsed tag
			$parsed['full_tag'] = $full_tag;
			$parsed['attributes'] = $this->_parse_attributes($attributes);
			$parsed['full_segments'] = str_replace($this->_trigger, '', $segments);
			$parsed['segments'] = $this->_parse_segments($parsed['full_segments']);

			// Set the end tag to search for
			$end_tag = $this->_l_delim.'/'.$segments.$this->_r_delim;

			// Lets trim off the first part of the content
			$content = substr($content, $start + $tag_len);

			// If there is an end tag, get and set the content.
			if (($end = strpos($content, $end_tag)) !== FALSE)
			{
				$parsed['content'] = substr($content, 0, $end);
				$parsed['full_tag'] .= $parsed['content'].$end_tag;
			}
			else
			{
				$parsed['content'] = '';
			}
			$parsed['marker'] = 'marker_'.$this->_tag_count.$this->_mark;

			$orig_content = str_replace($parsed['full_tag'], $parsed['marker'], $orig_content);
			$parsed_tags[] = $parsed;
			$this->_tag_count++;
		}

		if (empty($parsed_tags))
		{
			$orig_content = $this->parse_php($this->parse_conditionals($orig_content), $data);
			return array('content' => $orig_content, 'tags' => array());
		}

		// Lets replace all the data tags first
		if ( ! empty($data))
		{
			// Clean up the array
			$data = $this->_force_array($data);

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
					$return_data = $this->_parse_data_double($tag, $data);
				}

				// If the tag referenced data then put that data in the content
				if ($return_data !== FALSE)
				{
					$orig_content = str_replace($tag['marker'], $return_data, $orig_content);
					unset($parsed_tags[$key]);
				}
			}
		}

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

		return array('content' => $orig_content, 'tags' => $parsed_tags);
	}

	// --------------------------------------------------------------------

	public function parse_conditionals($content)
	{
		preg_match_all('#{if (.*?)}#i', $content, $matches, PREG_OFFSET_CAPTURE);

		$len_offset = 0;
		foreach ($matches[0] as $match)
		{
			$replacement = preg_replace('#((^|\(|\)|\s|\+|\-|\*|\/|\.|\||\&|\>|\<|\=)((?!true|false|null)[a-z][a-z0-9]*))#i', '$2\$$3', $match[0]);
			$content = substr($content, 0, $match[1] + $len_offset).$replacement.substr($content, $match[1] + strlen($match[0]) + $len_offset);
			$len_offset += strlen($replacement) - strlen($match[0]);
		}

		preg_match_all('#{elseif (.*?)}#i', $content, $matches, PREG_OFFSET_CAPTURE);

		$len_offset = 0;
		foreach ($matches[0] as $match)
		{
			$replacement = preg_replace('#((^|\(|\)|\s|\+|\-|\*|\/|\.|\||\&|\>|\<|\=)((?!true|false|null)[a-z][a-z0-9]*))#i', '$2\$$3', $match[0]);
			$content = substr($content, 0, $match[1] + $len_offset).$replacement.substr($content, $match[1] + strlen($match[0]) + $len_offset);
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
		echo eval('?>'.$_content_to_parse.'<?php ');
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
			if (is_object($value))
			{
				$value = (array) $value;
			}
			
			if ( ! is_array($value))
			{
				$content = str_replace('{'.$var.'}', $value, $content);
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
		foreach ($tag['segments'] as $segment)
		{
			if ( ! is_array($data) OR ! isset($data[$segment]))
			{
				return FALSE;
			}
			$data = $data[$segment];
		}

		$temp = new Tags;
		foreach ($data as $val)
		{
			$return = $temp->parse($tag['content'], $val);
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