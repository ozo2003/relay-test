<?php declare(strict_types = 1);

use App\Constants\Enum\Definition;
use Symfony\Config\SncRedisConfig;

return static function (SncRedisConfig $snc): void {
    foreach (['default', 'cache', 'session', ] as $db => $key) {
        $snc
            ->client(alias: $key)
                ->type(value: 'relay')
                ->alias(value: $key)
                ->dsns(value: [
                    sprintf('%%env(REDIS_URL)%%/%s', $db),
                ])
                ->logging(value: false)
                ->options()
                    ->connectionPersistent(value: true)
                    ->throwErrors(value: false)
                    ->prefix(value: sprintf('%s_%%env(APP_ENV)%%_%s_', Definition::PROJECT->value, $key))
                    ->serialization('msgpack');
    }
};
