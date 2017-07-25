<?php
namespace Seahorse\Tactician;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;

class Config extends ContainerConfig
{
    public function define(Container $di)
    {
        $di->params['League\Tactician\Container\ContainerLocator'] = [
            'container' => $di,
            'commandNameToHandlerMap' => $di->lazyValue('commandsToHandlersMap'),
        ];

        $di->params['League\Tactician\Handler\CommandHandlerMiddleware'] = [
            'commandNameExtractor' => $di->lazyNew('League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor'),
            'handlerLocator'       => $di->lazyNew('League\Tactician\Container\ContainerLocator'),
            'methodNameInflector'  => $di->lazyNew('League\Tactician\Handler\MethodNameInflector\HandleInflector')
        ];

        $di->params['League\Tactician\CommandBus']['middleware'] = $di->lazyArray([
                $di->lazyNew('League\Tactician\Plugins\LockingMiddleware'),
                $di->lazyNew('League\Tactician\Handler\CommandHandlerMiddleware'),
            ]
        );

        $di->set('league:tactician/commandbus', $di->lazyNew('League\Tactician\CommandBus'));
    }
}