<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Webhooks\Telegram;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
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
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $bot_api_key  = '6194699354:AAGsIq2wAHBi44A2Vzj3zeEMpBvZ77oSMy4';
        // $bot_username = 'exfeelbot';

        DriverManager::loadDriver(TelegramDriver::class);

        $botman = BotManFactory::create([
            'telegram' => [
                'token' => $bot_api_key,
            ],
        ]);

        $botman->hears('hello', function (BotMan $bot) {
            $bot->reply('Hello yourself.');
        });

        $botman->listen();

        return new JsonDataSuccessResponse();
    }
}
