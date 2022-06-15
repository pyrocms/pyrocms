<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

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

Route::streams('/', [
    'entry' => 'homepage',
    'stream' => 'pages',
]);

Route::streams('{entry.path}', [
    'stream' => 'pages',
]);

Route::get('logout', function () {
    
    Auth::logout();

    return Redirect::to('ui/form.login');
});
