# Aura Di ContainerBuiler config for Tactician

A simple [aura/di](https://github.com/auraphp/Aura.Di) container config for [league/tactician](http://tactician.thephpleague.com).

Add `Seahorse\Tactician\Config` to your [ContainerBuilder](https://github.com/auraphp/Aura.Di/blob/3.x/docs/config.md).

`League\Tactician\CommandBus` has the service name `league:tactician/commandbus`


## Mapping commands to handlers

In your `ContainerBuilder` configuration class you need to map commands to handlers.

```php
$di->set('service-name', $di->lazyNew('Your\Handler'));

$di->values['commandsToHandlersMap'] = [
    YourCommand::CLASS => 'service-name',
];
```

## Adding middleware

Override the middleware params in your `ContainerBuilder` configuration class.

```php
$di->params['League\Tactician\CommandBus']['middleware'] = $di->lazyArray([
        // add your middleware, order is important
        $di->lazyNew('League\Tactician\Plugins\LockingMiddleware'),
        $di->lazyNew('League\Tactician\Handler\CommandHandlerMiddleware'),
    ]
);
```