<?php

declare(strict_types=1);

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\RedisCache;
use BotMan\BotMan\Cache\SymfonyCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Storages\Drivers\RedisStorage;
use BotMan\Drivers\Telegram\TelegramDriver;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

use function App\Components\env;

return [
    BotMan::class => static function (ContainerInterface $container): BotMan {
        /**
         * @psalm-suppress MixedArrayAccess
         * @var array{
         *     telegram_token: string,
         *     redis_host: string,
         *     redis_port: int,
         *     redis_password: string,
         * } $config
         */
        $config = $container->get('config')['botman'];

        DriverManager::loadDriver(TelegramDriver::class);

        $adapter = new FilesystemAdapter();

        return BotManFactory::create([
            'telegram' => [
                'token' => $config['telegram_token'],
            ],
            new SymfonyCache($adapter),
            //            new RedisCache(
            //                host: $config['redis_host'],
            //                port: $config['redis_port'],
            //                auth: $config['redis_password'],
            //            ),
            //            null,
            //            new RedisStorage(
            //                host: $config['redis_host'],
            //                port: $config['redis_port'],
            //                auth: $config['redis_password'],
            //            ),
        ]);
    },

    'config' => [
        'botman' => [
            'telegram_token'    => env('TELEGRAM_API_KEY'),
            'redis_host'        => env('REDIS_HOST'),
            'redis_port'        => (int)env('REDIS_PORT'),
            'redis_password'    => env('REDIS_PASSWORD'),
        ],
    ],
];
