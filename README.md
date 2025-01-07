# Action Middleware Package
This package provides middleware functionality for handling actions in your Laravel application. Below, you'll find information on how to install, configure.
## Installation

1. Add the package to your composer.json file:
```json
{
    "require": {
        "ucraft-com/action-middleware": "*"
    }
}
```

And run composer to update your dependencies:

    composer update

Or you can simply run

    composer require ucraft-com/action-middleware

2. Publish the configuration file:


    php artisan vendor:publish --tag=action-middleware

3. Configure your middleware settings in the published config/action-middleware.php file.

## Basic Usage

Once installed and configured, you can start using the middleware to handle actions in your application. The default service provider and gateway interfaces provide flexibility for handling various use cases.

Example:
```php
    use Uc\ActionMiddleware\ActionMiddlewareRunner;
    use Uc\ActionMiddleware\Enums\ActionType;
    
    $result = ActionMiddlewareRunner::run(ActionType::CREATE_CUSTOMER, $request->all());
```
