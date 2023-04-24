<?php declare(strict_types = 1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\RedisSessionHandler;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->parameters()
        ->set('locale', 'en')
        ->set('container.dumper.inline_factories', true);

    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->set(RedisSessionHandler::class)
        ->args([
            service('snc_redis.session'),
        ]);

    $services->load('App\\', __DIR__ . '/../src/*')
        ->exclude([__DIR__ . '/../src/{DependencyInjection,Entity,Migrations,Tests,Utils,Kernel.php}']);
};
