# Action Middleware

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "ucraft-com/action-middleware": "^1.0"
    }
}
```

And run composer to update your dependencies:

    composer update

Or you can simply run

    composer require ucraft-com/action-middleware

## Basic Usage


```php

    use Uc\ActionMiddleware\ActionMiddlewareRunner;
    use Uc\ActionMiddleware\Enums\ActionType;
    
    $action = ActionType::CREATE_CUSTOMER;
    $args = $request->all();
    
    $result = ActionMiddlewareRunner::run($action, $args);

```
