<?php declare(strict_types = 1);

use App\Constants\Enum\Environment;
use App\Constants\Enum\Role;
use App\Entity\User;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Config\SecurityConfig;

return static function (SecurityConfig $config, ContainerConfigurator $container): void {
    $config
        ->passwordHasher(PasswordAuthenticatedUserInterface::class, 'auto');

    $config
        ->provider('user_provider')
            ->entity()
                ->class(User::class)
                ->property('email');

    $config
        ->roleHierarchy(Role::ROLE_ADMIN->value, 'ROLE_ALLOWED_TO_SWITCH');

    $config
        ->accessControl()
            ->path('^/')
            ->roles(AuthenticatedVoter::PUBLIC_ACCESS);

    $config
        ->firewall(Environment::DEV->value)
        ->pattern('/(_(wdt|profiler)|css|images|js|map|png|jpe?g|gif|bmp|ico|svg)/')
        ->security(false)
        ->lazy(true);

    $login = $config
        ->firewall('login');

    $login
        ->jsonLogin()
        ->usernamePath('email')
        ->checkPath('api_users_login');

    $login
        ->pattern('^/api');

    $login
        ->logout()
        ->path('app_users_logout');

    $login
        ->switchUser()
        ->parameter('X-Switch-User');

    if (Environment::TEST->value === $container->env()) {
        $config
            ->passwordHasher(PasswordAuthenticatedUserInterface::class)
            ->algorithm($algo = 'xxh3')
            ->hashAlgorithm($algo)
            ->encodeAsBase64(false)
            ->iterations(0);
    }
};
