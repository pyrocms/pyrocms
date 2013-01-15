<?php

class Sentry_SessionProvider implements Cartalyst\Sentry\Sessions\SessionInterface
{
    /**
     * Returns the session key.
     *
     * @return string
     */
    public function getKey()
    {
        return 'pyrousersess';
    }

    /**
     * Put a key / value pair in the session.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function put($value)
    {
        ci()->session->set_userdata($this->getKey(), $value);
    }

    /**
     * Get the requested item from the session.
     *
     * @return mixed
     */
    public function get()
    {
        return ci()->session->userdata($this->getKey());
    }

    /**
     * Remove an item from the session.
     *
     * @param  string  $key
     * @return void
     */
    public function forget()
    {
        ci()->session->unset_userdata($this->getKey());
    }
}