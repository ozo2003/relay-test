<?php declare(strict_types = 1);

use Symfony\Config\DebugConfig;

return static function (DebugConfig $config): void {
    $config
        ->dumpDestination(value: 'tcp://%env(VAR_DUMPER_SERVER)%');
};
