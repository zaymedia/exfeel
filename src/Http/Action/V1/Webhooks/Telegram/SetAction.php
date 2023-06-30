<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Webhooks\Telegram;

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ZayMedia\Shared\Http\Response\HtmlResponse;

#[OA\Get(
    path: '/webhooks/telegram/set',
    description: 'Webhooks',
    summary: 'Webhooks',
    tags: ['Webhooks']
)]
#[OA\Response(
    response: '200',
    description: 'Successful operation'
)]
final class SetAction implements RequestHandlerInterface
{
    public function __construct(
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $bot_api_key  = '6194699354:AAGsIq2wAHBi44A2Vzj3zeEMpBvZ77oSMy4';
        $bot_username = 'exfeelbot';
        $hook_url = 'https://exfeel.zay.media/v1/webhooks/telegram/set';

        // https://github.com/php-telegram-bot/example-bot/blob/master/hook.php

        try {
            $telegram = new Telegram($bot_api_key, $bot_username);

            $result = $telegram->setWebhook($hook_url);

            return new HtmlResponse(
                html: $result->getDescription()
            );
        } catch (TelegramException $e) {
            return new HtmlResponse(
                html: $e->getMessage()
            );
        }
    }
}
