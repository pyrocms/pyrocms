<?php

class Sentry_CookieProvider implements Cartalyst\Sentry\Cookies\CookieInterface
{
    /**
     * Returns the cookie key.
     *
     * @return string
     */
    public function getKey()
    {
        return 'pyrouser';
    }

    /**
     * Put a key / value pair in the cookie with an
     * expiry.
     *
     * @param  mixed   $value
     * @param  int     $minutes
     * @return void
     */
    public function put($value, $minutes)
    {
        $expire = Carbon::now()->addMinutes($minutes);

        set_cookie(
            $this->getKey(),
            $value,
            $expire->timestamp,
            config_item('cookie_domain'),
            config_item('cookie_path'),
            config_item('cookie_prefix'),
            config_item('cookie_secure'),
            config_item('cookie_httponly') ?: false
        );
    }

    /**
     * Put a key / value pair in the cookie forever.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function forever($value)
    {
        $this->put($value, 99999999999999);
    }

    /**
     * Get the requested item from the session.
     *
     * @return mixed
     */
    public function get()
    {
        return get_cookie($this->getKey());
    }

    /**
     * Remove an item from the cookie.
     *
     * @param  string  $key
     * @return void
     */
    public function forget()
    {
        delete_cookie(
            $this->getKey(), 
            config_item('cookie_domain'),
            config_item('cookie_path'),
            config_item('cookie_prefix')
        );
    }

}