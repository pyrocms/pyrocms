---
title: Structure
---

## Structure[](#structure)

This section will go over the general application structure of PyroCMS.

The application structure of PyroCMS is nearly identical to the [application structure of Laravel](https://laravel.com/docs/5.3/structure).



### The Addons Directory[](#structure/the-addons-directory)

The `addons` directory is where all addons not included in the composer.json file should be kept.

<div class="alert alert-info">**Note:** Typically addons in the addons directory are committed to your project repository.</div>



#### Addon Directory Structure[](#structure/the-addons-directory/addon-directory-structure)

Just like composer packages PyroCMS addons have a `vendor` slug that is included in their path. Addons also include the site's `application reference` and the addon's `type` in it's full path.

    addons/{application}/{vendor}/{addon}-{type}

An example could be:

    addons/your_site/anomaly/documentation-module



#### Sharing Addons Between Applications[](#structure/the-addons-directory/sharing-addons-between-applications)

All addons in the `composer.json` file will be available for all applications in your PyroCMS installation.

You can also share addons by placing them in the `addons/shared` folder.

    addons/shared/anomaly/documentation-module



### The App Directory[](#structure/the-app-directory)

The `app` directory can be used just like in a native Laravel application. While it is recommended to bundle your application logic in addons the app directory can be used all the same.

For more information on using the `app` folder for application services please refer to [Laravel documentation](https://laravel.com/docs/5.3/structure#the-app-directory).



### The Bootstrap Directory[](#structure/the-bootstrap-directory)

The `bootstrap` directory contains files that bootstrap the framework and configure autoloading. This directory also houses a cache directory which contains framework generated files for performance optimization such as the route and services cache files.

You will notice the `bootstrap/app.php` file also replaces the `console kernel` and `http kernel` with Pyro's own.



### The Config Directory[](#structure/the-config-directory)

The `config` directory, as the name implies, contains all of your application's configuration files. It's a great idea to read through all of these files and familiarize yourself with all of the options available to you.

You will notice a `streams.php` configuration file that can be used to alter the boot process of the Streams Platform, the engine of PyroCMS.

For configuring addons and the Streams Platform further please refer to [#configuration](configuration section).



### The Core Directory[](#structure/the-core-directory)

The `core` directory contains any addon required by your `composer.json` file. Any file contained in the `composer.json` dependencies is considered part of your website or application's core dependencies.

<div class="alert alert-warning">**Warning:** It is not advised to commit your core directory!</div>



### The Database Directory[](#structure/the-database-directory)

The `database` directory works exactly the same as a native Laravel application. Because most migrations and seeds are within addons, it can be helpful to put miscellaneous seeds and migrations in the `database` directory.



### The Public Directory[](#structure/the-public-directory)

The `public` directory contains the `index.php` file, which is the entry point for all requests entering your application. This directory also houses your assets such as images, JavaScript, and CSS.

The `Asset` service in the [/documentation/streams-platform](Streams Platform) also uses the public directory to cache images and assets from various themes and addons. Cached assets can be found in the `public/app/{application}/assets` directory.



### The Resources Directory[](#structure/the-resources-directory)

The `resources` directory contains Laravel views as well as raw, un-compiled Laravel assets such as LESS, SASS, or JavaScript. This directory also houses all of your language files.

While you can use the resources directory exactly like you would in a native Laravel application you are encouraged to bundle language files, assets, and views in their respective addons that you are developing for your website or application.

<div class="alert alert-info">**Note:** It is highly encouraged to bundle your resources into their respective addons that you develop.</div>

The `resources` directory will also contain override files for addon config, views, and language files. You will be published to the `resources/{application}/addons` directory then when running the corresponding Artisan commands.



### The Routes Directory[](#structure/the-routes-directory)

The routes directory contains all of the route definitions for your application. By default, three route files are included with Laravel: web.php, api.php, and console.php.

<div class="alert alert-info">**Note:** It is highly encouraged to bundle your routes into their respective addons that you develop.</div>

The web.php file contains routes that the RouteServiceProvider places in the web middleware group, which provides session state, CSRF protection, and cookie encryption. If your application does not offer a stateless, RESTful API, all of your routes will most likely be defined in the web.php file.

The api.php file contains routes that the RouteServiceProvider places in the api middleware group, which provides rate limiting. These routes are intended to be stateless, so requests entering the application through these routes are intended to be authenticated via tokens and will not have access to session state.

The console.php file is where you may define all of your Closure based console commands. Each Closure is bound to a command instance allowing a simple approach to interacting with each command's IO methods. Even though this file does not define HTTP routes, it defines console based entry points (routes) into your application.

<div class="alert alert-primary">**Pro Tip:** These routes are loaded FIRST. This means that duplicate subsequent routes will override them by name and route path.</div>



### The Storage Directory[](#structure/the-storage-directory)

The `storage` directory contains your compiled Twig and Blade templates, file based sessions, file caches, and other files generated by the framework. This directory is segregated into `app`, `framework`, `logs`, and `streams` directories. The `app` directory may be used to store any files generated by your application. The `framework` directory is used to store framework generated files and caches. The `logs` directory contains your application's log files. And finally, the `streams` directory contains your stream generated entry models, addon caches, and private storage (non-public uploads for example).

The `storage/app/public` directory may be used to store user-generated files, such as profile avatars, that should be publicly accessible. You should create a symbolic link at public/storage which points to this directory. You may create the link using the php artisan `storage:link` command.



### The Vendor Directory[](#structure/the-vendor-directory)

The `vendor` directory contains your [Composer](https://getcomposer.org/) dependencies.
