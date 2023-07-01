<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Webhooks;

use App\Console\Bot\WebhookCommand;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ZayMedia\Shared\Http\Response\JsonDataSuccessResponse;

final class TelegramAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly WebhookCommand $handler
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->handler->handle();

        return new JsonDataSuccessResponse();
    }
}
