# Profiler

A PHP 5.3 profiler based off of Laravel 3's Anbu.

## Installation

Installing profiler is simple. First, you'll need to add the package to the `require` attribute of your `composer.json` file.

```json
{
    "require": {
        "loic-sharma/profiler": "1.1.*"
    },
}
``` 


### Installing Using Laravel 4

To enable te profiler in Laravel 4 you will need to register the Service Provider and the Facade.

1. Add `'Profiler\ProfilerServiceProvider',` to the list of service providers in `app/config/app.php`
2. Add `'Profiler' => 'Profiler\Facades\Profiler',` to the list of class aliases in `app/config/app.php`
3. In console run `php artisan config:publish loic-sharma/profiler`

And voila! You can use the profiler.

```php
Profiler::startTimer('testLogging');

// The profiler listens to Laravel's logger.
Log::info('Hello World!');
Log::notice('Some event occured.');

Profiler::endTimer('testLogging');

```

### Installing For Your Own Project

Add the following to your code:

```php
$logger = new Profiler\Logger\Logger;
$profiler = new Profiler\Profiler($logger);
```

You can now use the profiler to your heart's content.

```php

$profiler->startTimer('testLogging');

$logger->debug($object);
$logger->info('Hello World!');
$logger->notice('Some event occurred.');
$logger->warning('Careful: some warning.');
$logger->error('Runtime error.');
$logger->critical('This needs to be fixed now!');
$logger->emergency('The website is down right now.');

$profiler->endTimer('testLogging');

echo $profiler;
```

## Copyright and License

Profiler was written by Loic Sharma. Profiler is released under the 2-clause BSD License. See the LICENSE file for details.

Copyright 2012 Loic Sharma
