<?php

use Anomaly\DefaultAuthenticatorExtension\DefaultAuthenticatorExtension;

return [

    /*
    |--------------------------------------------------------------------------
    | Login Field
    |--------------------------------------------------------------------------
    |
    | Specify whether to use the 'email' or 'username' for logging in.
    |
    */
    'login' => env('LOGIN', 'email'),

    /*
    |--------------------------------------------------------------------------
    | Activation Mode
    |--------------------------------------------------------------------------
    |
    | How do you want to activate users? Available options are:
    |
    | 'email'       - Send an activation email to the user.
    | 'manual'      - Require an admin to manually activate the user.
    | 'automatic'   - Automatically activate the user when they register.
    |
    */
    'activation_mode' => env('ACTIVATION_MODE', 'email'),

    /*
    |--------------------------------------------------------------------------
    | Authenticators
    |--------------------------------------------------------------------------
    |
    | Define login authenticators.
    |
    */
    'authenticators' => [
        \Anomaly\DefaultAuthenticatorExtension\DefaultAuthenticatorExtension::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Minimum Length
    |--------------------------------------------------------------------------
    |
    | Specify the required minimum length for passwords.
    |
    */
    'passwords.minimum_length' => env('PASSWORD_LENGTH', 8),

    /*
    |--------------------------------------------------------------------------
    | Password Requirements
    |--------------------------------------------------------------------------
    |
    | Specify the security requirements for passwords.
    |
    */
    'passwords.requirements' => [
        '[0-9]',
        '[a-z]',
        '[A-Z]',
        '[!@#$%^&*()]',
    ],
];
