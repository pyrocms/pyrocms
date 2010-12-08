<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Formation
 *
 * A CodeIgniter library that creates forms via a config file.  It
 * also contains functions to allow for creation of forms on the fly.
 *
 * @package		Formation
 * @author		Dan Horrigan <http://dhorrigan.com>
 * @license		Apache License v2.0
 * @copyright	2010 Dan Horrigan
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
| -------------------------------------------------------------------
| FORMATION CONFIG
| -------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Form Wrapper tags
|--------------------------------------------------------------------------
|
| These tags will wrap the different elements in the form.
|
| Example:
| $formation['form_wrapper_open']	= '<ul>';
| $formation['form_wrapper_close']	= '</ul>';
|
| $formation['input_wrapper_open']	= '<li>';
| $formation['input_wrapper_close']	= '</li>';
|
| $formation['label_wrapper_open']	= '<label for="%s">';
| $formation['label_wrapper_close']	= '</label>';
|
| $formation['required_location']	= 'after';
| $formation['required_tag']		= '<span class="required">*</span>';
|
| Would result in the following form:
| <form action="" method="post">
| <ul>
|     <li>
|         <label for="first_name">First Name</label>
|         <input type="text" name="first_name" id="first_name" value="" />
|     </li>
| </ul>
| </form>
*/
$formation['form_wrapper_open']		= '<fieldset>';
$formation['form_wrapper_close']	= '</fieldset>';

$formation['input_wrapper_open']	= '<p>';
$formation['input_wrapper_close']	= '</p>';

$formation['label_wrapper_open']	= '<label for="%s">';
$formation['label_wrapper_close']	= '</label>';

$formation['required_location']		= 'after';
$formation['required_tag']			= '<span class="required">*</span>';

/* End of file formation.php */
