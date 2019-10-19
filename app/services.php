<?php

use App\Action\UserSearchAction;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\Setup;
use Infrastructure\Doctrine\DoctrineUserRepository;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use UsersSearch\UserRepository;

return [
    'errorHandler' => function(Container $container) {
        return function (Request $request, Response $response, Throwable $exception) use ($container) {
            $container->get(LoggerInterface::class)->error($exception->getMessage());
            return $response->withStatus(500)->write('Error');
        };
    },

    LoggerInterface::class => function (Container $container) {
        $logSettings = $container->get('settings')['logger'];

        $logger = new Logger($logSettings['name']);

        if ($logSettings['toStderr']) {
            $stderrHandler = new StreamHandler('php://stderr');
            $logger->pushHandler($stderrHandler);
        }

        if (!empty($logSettings['filename'])) {
            $rotatingFileHandler = new RotatingFileHandler($logSettings['filename'], 60, Logger::DEBUG);
            $logger->pushHandler($rotatingFileHandler);
        }

        return $logger;
    },

    EntityManagerInterface::class => function(Container $container) {

        $settings = $container->get('settings');

        $config = Setup::createYAMLMetadataConfiguration(
            $settings['doctrine']['mappingPaths'],
            $settings['doctrine']['isDevMode']
        );

        $namingStrategy = new UnderscoreNamingStrategy();
        $config->setNamingStrategy($namingStrategy);
        $config->setMetadataCacheImpl(new ArrayCache());
        $config->setQueryCacheImpl(new ArrayCache());
        $config->setResultCacheImpl(new ArrayCache());

        $config->setProxyDir($settings['doctrine']['proxyDir']);
        $config->setProxyNamespace('Doctrine\Proxies');

        return EntityManager::create($settings['database'], $config);
    },

    /**
     * Repositories
     */
    UserRepository::class => function(Container $container) {
        return new DoctrineUserRepository($container->get(EntityManagerInterface::class));
    },

    /**
     * Controllers
     */
    UserSearchAction::class => function (Container $container) {
        return new UserSearchAction($container->get(UserRepository::class));
    }
];
