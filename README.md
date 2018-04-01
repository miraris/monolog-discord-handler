# monolog-discord-handler

[![Packagist](https://img.shields.io/packagist/dt/miraris/monolog-discord-handler.svg?style=flat-square)](https://packagist.org/packages/agangofkittens/vgwrap)
[![Packagist](https://img.shields.io/packagist/v/miraris/monolog-discord-handler.svg?style=flat-square)](https://packagist.org/packages/miraris/monolog-discord-handler)

A simple Monolog handler for Discord webhooks

-------------------------------------------------

### Dependecies

- PHP >= 5.3
- Monolog >= 1.3

-------------------------------------------------

## 1. Installing

Easy installation via composer. Still no idea what composer is? Find out here [here](http://getcomposer.org).

```composer require lefuturiste/monolog-discord-handler```

-------------------------------------------------

## 2. Usage

Push this handler to your Monolog instance:

### Single webhook URL

```php
<?php
require 'vendor/autoload.php';

$log = new Monolog\Logger('name');

$log->pushHandler(new DiscordHandler\DiscordHandler([
    'https://discordapp.com/api/webhooks/xxx/yyy'
], 'DEBUG'));

```

### Multiple webhook URLs


```php
<?php
require 'vendor/autoload.php';

$log = new Monolog\Logger('name');

$log->pushHandler(new DiscordHandler\DiscordHandler([
    'https://discordapp.com/api/webhooks/xxx/yyy',
    'https://discordapp.com/api/webhooks/xxx/yyy',
], 'DEBUG'));

```

### Laravel

If you'd like to use this in Laravel, you need to create a [custom logging channel](https://laravel.com/docs/5.6/logging#creating-custom-channels) inside `config/logging.php` assuming you're using Laravel 5.6.

```php
'channels' => [
    'custom' => [
        'driver' => 'custom',
        'url' => 'https://discordapp.com/api/webhooks/xxx/yyy',
        'via' => App\Logging\CreateDiscordLogger::class,
        'level' => 'error',
    ],
],
```
Afterwards create the `App\Logging\CreateDiscordLogger` class.

```php
<?php

namespace App\Logging;

use Monolog\Logger;
use DiscordHandler\DiscordHandler;

class CreateDiscordLogger
{
    /**
     * Create a custom Discord Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $log = new Logger('mylogger');
        $log->pushHandler(new DiscordHandler([$config['url']], $config['level']));

        return $log;
    }
}
```

This package has no built-in rate limiting so it's recommended to set the log level to ~warning/error to avoid exceeding the rate limit.
