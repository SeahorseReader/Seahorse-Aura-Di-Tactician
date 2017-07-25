<?php
namespace Seahorse\Tactician;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;
use League\Tactician\CommandBus;
use League\Tactician\Container\ContainerLocator;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use League\Tactician\Plugins\LockingMiddleware;

class Config extends ContainerConfig
{
    public function define(Container $di)
    {
        $di->params['League\Tactician\Container\ContainerLocator'] = [
            'container' => $di,
            'commandNameToHandlerMap' => $di->lazyValue('commandsToHandlersMap'),
        ];

        $di->set('league:tactician/commandbus', function() use ($di) {
            $commandHandlerMiddleware = new CommandHandlerMiddleware(
                new ClassNameExtractor(),
                $di->newInstance('League\Tactician\Container\ContainerLocator'),
                new HandleInflector()
            );
            return new CommandBus(
                [
                    new LockingMiddleware(),
                    $commandHandlerMiddleware,
                ]
            );
        });
    }
}