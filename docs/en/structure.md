# Application Structure

- [Introduction](#introduction)
- [The Addons Directory](#the-addons-directory)
- [The App Directory](#the-app-directory)
- [The Core Directory](#the-core-directory)
- [The Database Directory](#the-database-directory)

<hr>

<a name="introduction"></a>
## Introduction

The application structure of PyroCMS is nearly identical to the [application structure of Laravel](https://laravel.com/docs/5.1/structure). 

<hr>

<a name="the-addons-directory"></a>
## The Addons Directory

The `addons` directory is where all addons not included in the composer.json file should be kept.

<div class="alert alert-info">
<strong>Note:</strong> Typically addons in the addons directory are committed to your project repository.
</div>

#### Addon directory structure

Just like composer packages PyroCMS addons have a `vendor` slug that is included in their path. Addons also include the site's `application reference` and the addon's `type` in it's full path.  

    addons/{reference}/{vendor}/{addon}-{type}

An example could be: 

    addons/pyro/anomaly/documentation-module

##### Sharing addons between applications

All addons in the `composer.json` file will be available for all applications in your PyroCMS installation.

You can also share addons by placing them in the `addons/shared` folder.
 
    addons/shared/anomaly/documentation-module

<a name="the-app-directory"></a>
## The App Directory

The `app` directory can be used just like in a native Laravel application. While it is recommended to bundle your application logic in addons the app directory can be helpful for odds and ends that do not fit in to your addons.

<a name="the-core-directory"></a>
## The Core Directory

Any addon required by your `composer.json` folder will be located in the `core` directory within it's vendor directory.

<div class="alert alert-warning">
<strong>Warning:</strong> It is not advised to commit your core directory!
</div>

<a name="the-database-directory"></a>
## The Database Directory

The `database` directory works exactly the same as a native Laravel application. Because most migrations and seeds are within addons, it can be helpful to put miscellaneous seeds and migrations in the `database` directory.

