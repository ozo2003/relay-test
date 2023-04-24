<?php declare(strict_types = 1);

use Symfony\Config\TwigConfig;

return static function (TwigConfig $config): void {
    $config
        ->defaultPath('%kernel.project_dir%/templates')
        ->debug('%kernel.debug%')
        ->strictVariables('%kernel.debug%')
        ->autoReload(true)
        ->optimizations(-1);
};
