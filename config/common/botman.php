<?php

declare(strict_types=1);

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\RedisCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Storages\Drivers\RedisStorage;
use BotMan\Drivers\Telegram\TelegramDriver;
use Psr\Container\ContainerInterface;

use function App\Components\env;

return [
    BotMan::class => static function (ContainerInterface $container): BotMan {
        /**
         * @psalm-suppress MixedArrayAccess
         * @var array{
         *     telegram_token: string,
         *     redis_host: string,
         *     redis_port: string,
         *     redis_password: string,
         * } $config
         */
        $config = $container->get('config')['botman'];

        DriverManager::loadDriver(TelegramDriver::class);

        return BotManFactory::create([
            'telegram' => [
                'token' => $config['telegram_token'],
            ],
            new RedisCache(
                host: $config['redis_host'],
                port: (int)$config['redis_port'],
                auth: $config['redis_password'],
            ),
            null,
            new RedisStorage(
                host: $config['redis_host'],
                port: (int)$config['redis_port'],
                auth: $config['redis_password'],
            ),
        ]);
    },

    'config' => [
        'botman' => [
            'telegram_token'    => env('TELEGRAM_API_KEY'),
            'redis_host'        => env('REDIS_HOST'),
            'redis_port'        => env('REDIS_PORT'),
            'redis_password'    => env('REDIS_PASSWORD'),
        ],
    ],
];
