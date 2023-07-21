<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Streams\Core\Filesystem\Filesystem;
use Streams\Core\Support\Facades\Messages;

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

Route::streams('login', [
    'as' => 'login',
    'redirect' => '/streams/ui/form.login',
]);

Route::streams('{entry.path}', [
    'stream' => 'pages',
]);

Route::get('logout', function () {

    Auth::logout();

    return Redirect::to('/streams/ui/form.login');
});

Route::get('files/sync', function () {

    (new Filesystem)->index('public://');

    File::deleteDirectory(base_path('streams/data/files'));
    File::moveDirectory(base_path('streams/data/core.filesystem'), base_path('streams/data/files'), true);
    File::deleteDirectory(base_path('streams/data/core.filesystem'));

    Messages::success("Synced");

    return Redirect::back();
});
