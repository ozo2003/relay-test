<?php declare(strict_types = 1);

use App\Constants\Enum\Definition;
use App\Constants\Enum\Environment;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $config, ContainerConfigurator $container): void {
    $redisProvider = 'cache.adapter.redis';
    $adapters = [
        'cache.adapter.apcu',
        'cache.adapter.array',
    ];

    if (!in_array($container->env(), [Environment::DEV->value, Environment::TEST->value, ], true)) {
        $adapters[] = 'cache.adapter.filesystem';
    }

    $projectPool = Definition::PROJECT_CACHE_KEY->value;

    $config->cache()
        ->pool($projectPool)
            ->adapters([[
                'name' => $redisProvider,
                'provider' => 'snc_redis.cache',
            ], ...$adapters]);

    $config
        ->cache()
            ->directory('%kernel.cache_dir%/pools')
            ->prefixSeed(Definition::PROJECT->value . '_%env(APP_ENV)%_')
            ->defaultRedisProvider('snc_redis.cache')
            ->app($projectPool)
            ->system($projectPool);
};
