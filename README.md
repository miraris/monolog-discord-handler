# monolog-discord-handler

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
], 'name', 'subname', 'DEBUG'));

```

### Multiple webhook URLs


```php
<?php
require 'vendor/autoload.php';

$log = new Monolog\Logger('name');

$log->pushHandler(new DiscordHandler\DiscordHandler([
    'https://discordapp.com/api/webhooks/xxx/yyy',
    'https://discordapp.com/api/webhooks/xxx/yyy',
], 'name', 'subname', 'DEBUG'));

```
