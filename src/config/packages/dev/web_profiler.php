<?php declare(strict_types = 1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\FrameworkConfig;
use Symfony\Config\WebProfilerConfig;

return static function (WebProfilerConfig $config, ContainerConfigurator $container, FrameworkConfig $framework): void {
    $config
        ->toolbar(true)
        ->interceptRedirects(false);

    $framework
        ->profiler()
        ->onlyExceptions(false)
        ->collectSerializerData(true);
};
