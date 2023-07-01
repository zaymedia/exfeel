<?php

declare(strict_types=1);

use App\Console\Bot\BotHelper;
use App\Console\Bot\Callbacks\StartCallback;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use Psr\Container\ContainerInterface;

use function App\Components\env;

return [
    BotMan::class => static function (ContainerInterface $container): BotMan {
        /**
         * @psalm-suppress MixedArrayAccess
         * @var array{
         *     telegram_token: string,
         * } $config
         */
        $config = $container->get('config')['botman'];

        DriverManager::loadDriver(TelegramDriver::class);

        return BotManFactory::create([
            'telegram' => [
                'token' => $config['telegram_token'],
            ],
        ]);
    },

    //    StartCallback::class => static function (ContainerInterface $container): StartCallback {
    //        return new StartCallback(
    //            $container->get(BotHelper::class)
    //        );
    //    },

    'config' => [
        'botman' => [
            'telegram_token' => env('TELEGRAM_API_KEY'),
        ],
    ],
];
