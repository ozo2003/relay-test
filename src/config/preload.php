<?php declare(strict_types = 1);

if ('prod' === ($_ENV['APP_ENV'] ?? null) && file_exists($path = dirname(__DIR__) . '/var/cache/prod/App_KernelProdContainer.preload.php')) {
    opcache_compile_file($path);
}
