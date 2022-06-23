<?php

namespace App\Streams;

use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Contracts\Auth\Authenticatable;

class StreamsGuard
{

    protected array $except = [
        'POST:api/login',
        'GET:api/streams/users',
        'POST:api/streams/users/entries',
        'GET:api/streams/users/entries',
    ];

    protected $user;

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        if ($this->isSkipped()) {
            return true;
        }

        return (bool) $this->user();
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if (!$token = Request::bearerToken()) {
            $token = Request::get('token');
        }

        if (!$token) {
            return null;
        }

        if (!$token = Streams::repository('tokens')->findBy('token', $token)) {
            return null;
        }

        return $token->expand('user');
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id()
    {
        if (!$user = $this->user()) {
            return null;
        }

        return $user->id;
    }

    public function validate(array $credentials = [])
    {
        dd(__METHOD__);
    }

    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }

    public function isSkipped(): bool
    {
        $verb = Request::method();
        $path = Request::path();

        return (bool) collect($this->except)
            ->first(fn ($skip) => $skip == "{$verb}:{$path}");
    }
}
