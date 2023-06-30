<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Webhooks\Telegram;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use Exception;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ZayMedia\Shared\Components\Sentry;
use ZayMedia\Shared\Http\Response\JsonDataSuccessResponse;

#[OA\Get(
    path: '/webhooks/telegram/hooks',
    description: 'Webhooks',
    summary: 'Webhooks',
    tags: ['Webhooks']
)]
#[OA\Response(
    response: '200',
    description: 'Successful operation'
)]
final class HooksAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly Sentry $sentry
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // https://api.telegram.org/bot6194699354:AAGsIq2wAHBi44A2Vzj3zeEMpBvZ77oSMy4/setwebhook?url=https://exfeel.zay.media/v1/webhooks/telegram/hooks

        $bot_api_key  = '6194699354:AAGsIq2wAHBi44A2Vzj3zeEMpBvZ77oSMy4';
        // $bot_username = 'exfeelbot';

        DriverManager::loadDriver(TelegramDriver::class);

        $botman = BotManFactory::create([
            'telegram' => [
                'token' => $bot_api_key,
            ],
        ]);

        $this->sentry->capture(
            new Exception(json_encode($request->getParsedBody()))
        );

        $this->sentry->capture(
            new Exception($botman->getMessage()->getText())
        );

        $botman->hears('hello', function (BotMan $bot) {
            $bot->reply('Hello yourself.');
        });

        $botman->listen();

        return new JsonDataSuccessResponse();
    }
}
