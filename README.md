# Plivo 
[![Latest Stable Version](https://poser.pugx.org/bodyansky/plivo/version)](https://packagist.org/packages/bodyansky/plivo) [![Total Downloads](https://poser.pugx.org/bodyansky/plivo/downloads)](https://packagist.org/packages/bodyansky/plivo) [![Latest Unstable Version](https://poser.pugx.org/bodyansky/plivo/v/unstable)](https://packagist.org/packages/bodyansky/plivo) [![License](https://poser.pugx.org/bodyansky/plivo/license.svg)](https://packagist.org/packages/bodyansky/plivo)   
A Plivo SMS integration for Laravel

## Project is archived

Since producing this package, Plivo have updated their own API package which is comprehensive. As such I've decided to archive this project as I am not doing any current development on it. 

## Installation

This package requires PHP 7.4+, and includes a Laravel 7 Service Provider and Facade.

To install through composer include the package in your `composer.json`.

    "bodyansky/plivo": "1.1.0"

Run `composer install` or `composer update` to download the dependencies or you can run `composer require bodyansky/plivo`.

### Refresh Autoloader

At this point some users may need to run the command `composer dump-autoload`. Alternatively, you can run `php artisan optimize`
which should include the dump-autoload command.

### Laravel 7+ Integration

To use the package with Laravel 5 firstly add the Messaging service provider to the list of service providers 
in `app/config/app.php`.

```php
'providers' => [
  Bodyansky\Plivo\MessagingServiceProvider::class
];
```
    
Add the `Messaging` facade to your aliases array.

```php
'aliases' => [
  'Messaging' => Bodyansky\Plivo\Facades\Messaging::class,
];
```
    
Publish the config and migration files using 
```sh
php artisan vendor:publish --provider="Bodyansky\Plivo\MessagingServiceProvider"
```

To access Plivo/Messaging you can either use the Facade or the Messaging instance is bound to the IOC container and you can 
then dependency inject it via its contract.

```php
Messaging::get('foo');

public function __construct(Bodyansky\Plivo\Contracts\Services\Messaging $messaging)
{
    $this->messaging = $messaging;
}
```
    
## Configuration File

Once you have published the config files, you will find a `Plivo.php` file in the `config` folder. You should 
look through these settings and update these where necessary. 

## Env

You will need to add the following to your `.env` file and update these with your own settings

```env
PLIVO_AUTH_ID=<auth_id>
PLIVO_AUTH_TOKEN=<auth_token>
PLIVO_SOURCE_NUMBER=<default_sms_number>
```

## Example Usage

```php
use Bodyansky\Plivo\Contracts\Services\Messaging;
    
public function sendMessage(Messaging $messaging) 
{
    $msg = $messaging->msg('Hello World!')->to('0123456789')->sendMessage(); 
}

// Or you can simply use the helper function
   
text('+44123456789', 'Just reminding you to attend the Dentist at 3.30pm');

Text takes three arguments, to, message and optionally from.

// If text is already defined as a function in your application you can use
text_message($to, $message, $from); // or
plivo_send_text($to, $message, $from);
```
