<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Webhooks;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ZayMedia\Shared\Components\Sentry;
use ZayMedia\Shared\Http\Response\JsonDataSuccessResponse;

final class TelegramAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly Sentry $sentry
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // https://api.telegram.org/bot6194699354:AAGsIq2wAHBi44A2Vzj3zeEMpBvZ77oSMy4/setwebhook?url=https://exfeel.zay.media/v1/webhooks/telegram
        // https://github.com/php-telegram-bot/example-bot/blob/master/hook.php

        // $this->log($request);

        DriverManager::loadDriver(TelegramDriver::class);

        $botman = BotManFactory::create([
            'telegram' => [
                'token' => \App\Components\env('TELEGRAM_API_KEY'),
            ],
        ]);

        $botman->hears('foo', 'App\Modules\Bot\Command\InstagramPhoto@handleFoo');

        $botman->hears('hello', function (BotMan $bot) {
            $bot->reply('Hello yourself :)))');
        });

        $botman->fallback(function (BotMan $bot) {
            $bot->reply('Sorry, I did not understand these commands.');
        });

        $botman->listen();

        return new JsonDataSuccessResponse();
    }

    private function log(ServerRequestInterface $request): void
    {
        $this->sentry->capture(
            new Exception(json_encode($request->getParsedBody()))
        );
    }
}
