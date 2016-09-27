<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get(
    'shipping',
    function (\Anomaly\ShippingModule\Shipping\ShippingResolver $shipping) {

        $users = \Anomaly\UsersModule\User\UserModel::all();

        $methods = $shipping->resolve(['country' => 'US']);

        /* @var \Anomaly\ShippingModule\Method\Contract\MethodInterface $method */
        foreach ($methods as $method) {
            echo $method->getName() . ' ' . $method->quote($users->first()->shippable, ['postal_code' => 61241]) . '<br>';
        }
    }
);
