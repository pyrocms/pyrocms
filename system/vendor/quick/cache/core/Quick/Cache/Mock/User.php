<?php namespace Quick\Cache\Mock;
/*
 * This file belongs to the Quick Cache package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * copyright 2012 -- Jerel Unruh -- http://unruhdesigns.com
 */

class User
{
    public function get_by_email($email)
    {
        return array('first' => 'Billy', 'last' => 'the Kid');
    }

    public function get()
    {
        return 'jimbobjones';
    }
}
