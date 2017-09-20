---
title: Configuration
---

## Configuration[](#configuration)

This section will describe how configuration works in PyroCMS and how to access it. For the most part configuration in PyroCMS works exactly the same as [https://laravel.com/docs/5.3/configuration](configuration in Laravel).



### Accessing Configuration[](#configuration/accessing-configuration)

You may easily access your configuration values using the global `config` helper function from anywhere in your application. The configuration values may be accessed using "dot" syntax, which includes the name of the file and option you wish to access. A default value may also be specified and will be returned if the configuration option does not exist:

    $value = config('app.timezone');

To set configuration values at runtime, pass an array to the `config` helper:

    config(['app.timezone' => 'America/Chicago']);



### Streams Platform Configuration[](#configuration/streams-platform-configuration)

The Streams Platform contains it's own configuration. You may easily access configuration values for the Streams Platform just the same as you would any other configuration. Configuration values for the Streams Platform have a `streams::` prefix:

    $value = config('streams::locales.default');

To set configuration values at runtime, pass an array to the `config` helper:

    config(['streams::assets.paths.my_path' => 'my/example/path']);



#### Publishing streams configuration[](#configuration/streams-platform-configuration/publishing-streams-configuration)

In order to configure the Streams Platform without modifying core files you will need to publish the Streams Platform with the following command:

     php artisan streams:publish

You can then find the Streams Platform configuration files in `resources/{application}/streams/config`.



### Addon Configuration[](#configuration/addon-configuration)

Addons contain their own configuration. You may easily access configuration values for addons just the same as you would any other configuration. Configuration values for addons have a `vendor.type.slug::` prefix based on their `dot namespace`:

    $value = config('anomaly.module.users::config.login');

To set configuration values at runtime, pass an array to the `config` helper:

    config(['anomaly.module.users::config.login' => 'username']);



#### Publishing addon configuration[](#configuration/addon-configuration/publishing-addon-configuration)

In order to configure addons without modifying core files you will need to publish the addon with the following command:

     php artisan addon:publish vendor.type.slug

You can then find the addon configuration files in `resources/{application}/{vendor}/{slug}-{type}/config`.
