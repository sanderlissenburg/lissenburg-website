<?php

declare(strict_types=1);

namespace App;

use App\Application\Repository\StoryRepository;
use App\Infrastructure\Repository\DbalStoryRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Psr\Container\ContainerInterface;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'abstract_factories' => [
                ReflectionBasedAbstractFactory::class,
            ],
            'invokables' => [
                Infrastructure\Handler\PingHandler::class => Infrastructure\Handler\PingHandler::class,
            ],
            'factories'  => [
                Infrastructure\Handler\HomePageHandler::class => Infrastructure\Handler\HomePageHandlerFactory::class,
                Infrastructure\Handler\AboutPageHandler::class => ReflectionBasedAbstractFactory::class,
                Infrastructure\Handler\StoryDetailHandler::class => ReflectionBasedAbstractFactory::class,
                StoryRepository::class => function(ContainerInterface $container) {
                    return new DbalStoryRepository($container->get(Connection::class));
                },
                Connection::class => function() {
                    $connectionParams = [
                        'url' => 'mysql://root:secret@mysql/lissenburg_website',
                    ];
                    return DriverManager::getConnection($connectionParams);
                }
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }
}
