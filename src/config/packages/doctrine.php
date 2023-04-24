<?php declare(strict_types = 1);

use App\Constants\Enum\Definition;
use App\Constants\Enum\Environment;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\DoctrineConfig;

return static function (DoctrineConfig $config, ContainerConfigurator $container): void {
    $dbal = $config
        ->dbal();

    $connection = $dbal
        ->connection($default = 'default')
        ->serverVersion(15)
        ->url('%env(resolve:DATABASE_URL)%')
        ->logging('%kernel.debug%');

    $orm = $config
        ->orm();

    $em = $orm
        ->defaultEntityManager($default)
        ->entityManager($default);

    $orm
        ->autoGenerateProxyClasses(true);

    $em
        ->namingStrategy('doctrine.orm.naming_strategy.underscore_number_aware');

    $em
        ->mapping('App')
        ->isBundle(false)
        ->type('attribute')
        ->alias('App')
        ->prefix('App\Entity')
        ->dir('%kernel.project_dir%/src/Entity');

    if (Environment::TEST->value === $container->env()) {
        $connection
            ->dbnameSuffix('_test%env(default::TEST_TOKEN)%')
            ->logging(false);
    }

    if (in_array($container->env(), [Environment::PROD->value, Environment::STAGE->value, ], true)) {
        $orm
            ->autoGenerateProxyClasses(false);

        $em
            ->queryCacheDriver()
            ->type('pool')
            ->pool(Definition::PROJECT_CACHE_KEY->value);

        $em
            ->resultCacheDriver()
            ->type('pool')
            ->pool(Definition::PROJECT_CACHE_KEY->value);
    }
};
